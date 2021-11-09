<?php
namespace SD\Posts;

/**
 * Klasa pobierająca błędy zapisane np. przy tworzeniu wpisu.
 * Może być trawersowana jak tablica.
 */
class ErrorsGetter implements \Iterator, \Countable {

	/**
	 * Tablica pobranych błędów.
	 *
	 * @var array
	 */
	protected $errors = array();

	/**
	 * Konstruktor.
	 *
	 * @param int    $postID   Identyfikator wpisu
	 * @param string $meta_key Identyfikator metadanych wpisu, który zawiera komunikaty o błędach.
	 */
	public function __construct ( $postID, $meta_key = '_mm_save_errors' ) {
		$errors = get_post_meta( $postID, $meta_key, true );

		if ( !empty($errors) ) {
			if ( !is_array($errors) ) {
				$errors = (array) $errors;
			}

			foreach ( $errors as $error ) {
				if ( !is_array($error) ) {
					$message = $error;
					$date = '';
				} else {
					$message = isset($error['message']) ? $error['message'] : reset($error);
					$date = isset($error['date']) ? $error['date'] : next($error);
				}

				$this->errors[] = array(
					'message' => $message,
					'date'    => $date
				);
			}
		}
	}

	/**
	 * Resetuje wskaźnik.
	 * 
	 * @return mixed
	 */
	function rewind () {
		return reset( $this->errors );
	}

	/**
	 * Zwraca bieżący element.
	 * 
	 * @return mixed
	 */
	function current () {
		return current( $this->errors );
	}

	/**
	 * Zwraca wskaźnik.
	 * 
	 * @return mixed
	 */
	function key () {
		return key( $this->errors );
	}

	/**
	 * Przesuwa wskaźnik o jedną pozycję.
	 * 
	 * @return mixed
	 */
	function next () {
		return next( $this->errors );
	}

	/**
	 * Sprawdza, czy pozycja istnieje.
	 * 
	 * @return bool
	 */
	function valid () {
		return null !== key( $this->errors );
	}

	/**
	 * Liczy liczbę komunikatów.
	 * 
	 * @return bool
	 */
	function count () {
		return count( $this->errors );
	}

} // SD\Posts\ErrorsGetter
