<?php
namespace SD\Posts;

/**
 * Kreator wpisów.
 */
class Creator {

	/**
	 * Identyfikator wpisu.
	 *
	 * var int
	 */
	protected $ID = 0;

	/**
	 * Pola wpisu (np. 'post_title').
	 *
	 * var array
	 */
	protected $fields;

	/**
	 * Parametry meta.
	 *
	 * var array
	 */
	protected $meta;

	/**
	 * Błędy aktualizacji meta.
	 *
	 * var array
	 */
	protected $meta_errors = array();

	/**
	 * Konstruktor.
	 *
	 * @param array $post Parametry wpisu (np. 'post_title'). Jeśli zostanie
	 *                    podany parametr 'ID', istniejący wpis zostanie zaktualizowany.
	 * @param array $meta Opcjonalny. Parametry meta.
	 */
	public function __construct ( array $post, array $meta = array() ) {
		if ( isset($post['ID']) ) {
			$this->ID = intval( $post['ID'] );
			unset( $post['ID'] );
		}

		$this->fields = $post;
		$this->meta = $meta;
	}

	/**
	 * Tworzy wpis.
	 *
	 * @param bool $meta Czy od razu ustawić wartości meta? Domyślnie: TRUE.
	 * @return int Identyfikator wpisu.
	 */
	public function save ( $meta = true ) {
		if ( $this->ID ) {
			$this->update_post();
		} else {
			$this->create_post();
		}

		if ( $meta ) {
			$this->update_meta();
		}

		return $this->ID;
	}

	/**
	 * Ustawia pole wpisu. Może nadpisać już istniejące.
	 *
	 * @param string $name  Nazwa parametru.
	 * @param mixed  $value Wartość parametru.
	 */
	public function set_field ( $name, $value ) {
		if ( 'ID' === $name ) {
			$this->ID = intval( $value );
		} else {
			$this->fields[ $name ] = $value;
		}
	}

	/**
	 * Ustawia kilka pól wpisu, nadpisując już istniejące.
	 *
	 * @param array $fields Tablica pól wpisu, gdzie klucze to identyfikatory
	 *                     pól wpisu, a wartości - wartości pól.
	 * @return void
	 */
	public function set_fields ( array $fields ) {
		if ( isset($fields['ID']) ) {
			$this->ID = intval( $fields['ID'] );
			unset( $fields['ID'] );
		}

		$this->fields = wp_parse_args( $fields, $this->fields );
	}

	/**
	 * Sprawdza, czy w tablicy pól wpisu i pól meta są jakiekolwiek nie zapisane
	 * jeszcze wartości. Jeśli jako parametr zostanie podany string, sprawdzone
	 * zostaną pola wpisu (string 'post') lub metadanych (string 'meta').
	 *
	 * @param string $type Opcjonalny. Typ pól do sprawdzenia. Jeśli pusty lub
	 *                     typ pól nie istnieje, zostaną sprawdzone wszystkie.
	 * @return bool
	 */
	public function is_empty ( $type = '' ) {
		switch ( $type ) {
			case 'post':
				return empty( $this->fields );
			case 'meta':
				return empty( $this->meta );
			default:
				return empty( ($this->post) && empty($this->meta) );
		}
	}

	/**
	 * Ustawia metadane wpisu.
	 *
	 * @param string $name  Identyfikator meta.
	 * @param mixed  $value Wartość meta.
	 * @return void
	 */
	public function set_meta ( $name, $value ) {
		$this->meta[ $name ] = $value;
	}

	/**
	 * Ustawia kilka metadanych wpisu, nadpisując już istniejące.
	 *
	 * @param array $metas Tablica danych meta, gdzie klucze to identyfikatory
	 *                     meta, a wartości - wartości meta.
	 * @return void
	 */
	public function set_metas ( array $metas ) {
		$this->meta = wp_parse_args($metas, $this->meta);
	}

	/**
	 * Zwraca identyfikator wpisu.
	 *
	 * @return int
	 */
	public function get_ID () {
		return $this->ID;
	}

	/**
	 * Zwraca obiekt wpisu.
	 *
	 * @return WP_Post|null
	 */
	public function get_post () {
		if ( $this->ID ) {
			return get_post( $this->ID );
		}

		return null;
	}

	/**
	 * Zwraca błędy aktualizacji metadanych.
	 *
	 * @return array
	 */
	public function get_meta_errors () {
		return $this->meta_errors;
	}

	/**
	 * Aktualizuje pola meta i resetuje tablicę.
	 *
	 * @throws SD\Posts\Exceptions\MetaException
	 * @return bool TRUE, jeśli aktualizacja się powiodła lub FALSE, jeśli nie było
	 *              danych do aktualizacji lub nie ma określonego identyfikatora wpisu.
	 */
	public function update_meta () {
		if ( empty($this->meta) ) {
			return false;
		}

		if ( !$this->ID ) {
			throw new Exceptions\MetaException( __('Cannot update metadata of non-existent post.', 'mm-theme') );
		}

		$meta = $this->meta;
		$u = 0;

		foreach ( $meta as $key => $value ) {
			try {
				$this->update_metadata( $key, $value );
				$u++;
				unset( $this->meta[ $key ] );
			} catch ( Exceptions\MetaException $e ) {
				$this->meta_errors[ $key ] = $e->getMessage();
			}
		}

		$error = false;

		if ( 0 === $u ) {
			$error = __( 'Unable to update post metadata.', 'mm-theme' );
		} elseif ( count($meta) > $u ) {
			$error = __( 'Unable to update some post metadata.', 'mm-theme' );
		}

		if ( $error ) {
			$error .= ' ' . sprintf(
				// pierwszy parametr to identyfikator, drugi to nazwa metody
				__( 'Post ID: %1$d. For more information, call %2$s.' ),
			        $this->ID,
			        esc_html( addslashes(get_class($this)) . '::get_meta_errors()' )
			);
			throw new Exceptions\MetaException( $error );
		}

		return true;
	}

	/**
	 * Tworzy wpis i resetuje tablicę parametrów.
	 *
	 * @throws SD\Posts\Exceptions\PostException
	 * @return boo|int Identyfikator wpisu lub FALSE, jeśli nie było danych do aktualizacji.
	 */
	protected function create_post () {
		if ( empty($this->fields) ) {
			return false;
		}

		$postID = wp_insert_post( $this->fields, true );

		if ( $postID instanceof \WP_Error ) {
			throw new Exceptions\PostException( $postID->get_error_message() );
		}

		if ( !$postID ) {
			throw new Exceptions\PostException( __('Unable to create the post.', 'mm-theme') );
		}

		$this->ID = $postID;
		$this->fields = array();
		return $postID;
	}

	/**
	 * Aktualizuje wpis i resetuje tablicę parametrów.
	 *
	 * @throws SD\Posts\Exceptions\PostException
	 * @return int|bool Identyfikator wpisu lub FALSE, jeśli nie było danych do aktualizacji.
	 */
	protected function update_post () {
		if ( empty($this->fields) ) {
			return false;
		}

		$post_arr = $this->fields;
		$post_arr['ID'] = $this->ID;

		$post_arr = wp_slash( $post_arr );
		$postID = wp_update_post( $post_arr, true );

		if ( $postID instanceof \WP_Error ) {
			throw new Exceptions\PostException( $postID->get_error_message() );
		}

		if ( !$postID ) {
			throw new Exceptions\PostException( __('Unable to update the post.', 'mm-theme') );
		}

		$this->fields = array();
		return $postID;
	}

	/**
	 * Aktualizuje metadane wpisu.
	 *
	 * @throws SD\Posts\Exceptions\PostException
	 * @param string $meta_id    Identyfikator metadanych.
	 * @param mixed  $meta_value Wartość metadanych.
	 * @return bool Identyfikator meta, jeśli wcześniej istniał już wpis, TR lub FALSE, jeśli nie było danych do aktualizacji.
	 */
	protected function update_metadata ( $meta_id, $meta_value ) {
        $prev_meta = get_post_meta( $this->ID, $meta_id, true );

        if ($prev_meta === $meta_value) {
            $result = true;
        } else {
            $result = update_post_meta( $this->ID, $meta_id, $meta_value );
        }

		if ( !$result ) {
			throw new Exceptions\MetaException( sprintf(
			    __( 'Post ID: %1$d &ndash; Unable to update metadata. Meta id: %2$s.' ),
			        $this->ID,
			        esc_html( $meta_id )
			) );
		}

		return $result;
	}

} // SD\Posts\Creator
