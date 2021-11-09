<?php
namespace SD\Posts;

/**
 * Klasa zapisująca błędy np. przy tworzeniu wpisu.
 */
class ErrorsSaver {

	/**
	 * Flaga pozwalająca na ustalenie, czy obiekt powinien rzucać wyjątki, czy tylko je zapisywać.
	 *
	 * @var bool
	 */
	protected $suppress;

	/**
	 * Identyfikator metadanych wpisu, które zawierają komunikaty o błędach.
	 *
	 * @var string
	 */
	protected $meta_key;

	/**
	 * Tablica niezapisanych komunikatów.
	 *
	 * @var array
	 */
	protected $notices = array();

	/**
	 * Tablica błędów zapisywania komunikatów.
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Konstruktor.
	 *
	 * @param bool   $suppress_errors Określa, czy wyrzucać wyjątki w razie niepowodzenia.
	 * @param string $meta_key        Identyfikator metadanych wpisu, który zawiera komunikaty o błędach.
	 */
	public function __construct ( $suppress_errors = false, $meta_key = '_mm_save_errors' ) {
		$this->meta_key = $meta_key;
		$this->suppress_errors( $suppress_errors );
	}

	/**
	 * Zapisuje komunikaty, które zostały dodane.
	 *
	 * @return int Liczba zapisanych komunikatów.
	 */
	public function save () {
		$to_save = array();

		array_reverse( $this->notices );

		$saved = 0;
		while ( count($this->notices) > 0 ) {
			$notice = array_pop( $this->notices );
			$ID = $notice['ID'];

			if ( $this->post_exists($ID) ) {
				$sup = $this->is_suppressed();
				$this->no_post_error ( $ID, $notice['message'] );
				$this->suppress( $sup );
				continue;
			}

			if ( isset($to_save[ $ID ]) ) {
				$to_save[ $ID ] = array();
			}

			$to_save[ $ID ][] = array(
				'message' => $notice['message'],
				'date'    => $notice['date']
			);

			$saved++;
		}

		foreach ( $to_save as $ID => $messages ) {
			$prev = $this->get_error_meta( $ID );
			$meta = array_merge( $prev, $messages );
			$this->save_error_meta( $ID, $meta );
		}

		return $saved;
	}

	/**
	 * Dodaje błąd do wewnętrznej tablicy. Tablica musi być później zapisana metodą ErrorsSaver::save().
	 *
	 * @param int    $postID   Identyfikator wpisu.
	 * @param string $message  Komunikat do zapisania.
	 * @return void
	 */
	public function add ( $postID, $message ) {
		$this->notices[] = array(
			'ID'      => $postID,
			'message' => $message,
			'date'    => current_time( 'mysql' )
		);
	}

	/**
	 * Zapisuje komunikat o błędzie.
	 *
	 * @param int    $postID   Identyfikator wpisu.
	 * @param string $message  Komunikat do zapisania.
	 * @return void
	 */
	public function save_message ( $postID, $message ) {
		if ( !$this->post_exists($postID) ) {
			$this->no_post_error( $postID, $message );
		}

		$errors = $this->get_error_meta( $postID );

		$errors[] = array(
			'message' => $message,
			'date'    => current_time( 'mysql' )
		);

		$this->save_error_meta( $postID, $errors );
	}

	/**
	 * Zwraca wartość flagi określającej, czy obiekt wyrzuca wyjątki.
	 *
	 * @param int $postID Identyfikator wpisu.
	 * @return bool
	 */
	public function get_error_meta ( $postID ) {
		$meta = get_post_meta( $postID, $this->meta_key, true );

		if ( !$meta ) {
			$meta = array();
		}

		return $meta;
	}

	/**
	 * Zwraca komunikaty błędów określone w momencie niepowodzenia zapisywania błędów
	 * (np. gdy wpis o podanym ID nie istnieje). Jeśli podany zostanie argument, wyszukane
	 * zostaną tylko te błędy, które mają wartość 'ID' równą podanemu argumentowi.
	 * 
	 * @param mixed $id Opcjonalny. Parametr do wyszukania wiadomości odnoszących się
	 *                  do konkretnego identyfikatora wpisu.
	 * @return array
	 */
	public function get_save_errors ( $id = null ) {
		if ( null !== $id ) {
			$errors = array();

			foreach ( $this->errors as $error ) {
				if ( $error['ID'] === $id ) {
					$errors = $error;
				}
			}

			return $errors;
		}

		return $this->errors;
	}

	/**
	 * Liczy niezapisane komunikaty.
	 * 
	 * @return int
	 */
	public function count_notices () {
		return count( $this->notices );
	}

	/**
	 * Tworzy tablicę wiadomości.
	 * 
	 * @param int $postID Identyfikator wpisu.
	 * @return bool
	 */
	public function post_exists ( $postID ) {
		$post = get_post( $postID ); // wpis jest zapisany w cache
		return ( $post instanceof \WP_Post );
	}

	/**
	 * Zwraca wartość flagi określającej, czy obiekt wyrzuca wyjątki.
	 *
	 * @return bool
	 */
	public function is_suppressed () {
		return $this->suppress;
	}

	/**
	 * Włącz/wyłącza wyrzucanie wyjątków.
	 * 
	 * @param bool $suppress
	 * @return void
	 */
	public function suppress_errors ( $suppress ) {
		$this->suppress = $suppress ? true : false;
	}

	/**
	 * Tworzy błąd związany z nieistnieniem przekazanego wpisu.
	 * 
	 * @param int    $postID  Identyfikator wpisu.
	 * @param string $message Treść wiadomości.
	 * @return bool
	 */
	protected function no_post_error ( $postID, $message ) {
		$error = array( 'ID' => $postID );

		$error['message'] = sprintf( __( 'Unable to save error message to non-existent post (ID: %1$s). The message was: %2$s.', 'mm-theme' ),
		        esc_html( $postID ),
		        $message
		);

		$this->errors[] = $error;

		if ( !$this->suppress ) {
			throw new Exceptions\ErrorsSaverException( $error['message'] );
		}
	}

	/**
	 * Zwraca wartość flagi określającej, czy obiekt wyrzuca wyjątki.
	 *
	 * @param int   $postID Identyfikator wpisu.
	 * @param array $errors Tablica komunikatów do zapisania.
	 * @return void
	 */
	protected function save_error_meta ( $postID, $errors ) {
		update_post_meta( $postID, $this->meta_key, $errors );
	}

} // SD\Posts\ErrorsSaver
