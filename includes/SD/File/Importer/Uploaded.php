<?php
namespace SD\File\Importer;

use SD\File\Exceptions;

/**
 * Importer wgrtywanych na serwer.
 *
 * @version 1.0.0
 */
class Uploaded extends FileImporter {

	/**
	 * Komunikat o błędzie (do celów administracyjnych - obiekt rzuca
	 * wyjątki, które mogą stanowić informację dla użytkownika).
	 *
	 * @var string
	 */
	protected $error;

	/**
	 * Konstruktor.
	 *
	 * @param string $file_key Nazwa klucza tablicy $_FILES, w którym znajduje się plik.
	 */
	public function __construct ( $file_key ) {
		$this->file_key = $file_key;
	} // __construct()

	/**
	 * Importuje plik.
	 *
	 * @throws SD\File\Exceptions\ImporterException
	 * @return void
	 */
	protected function import () {
		if ( !isset($_FILES[ $this->file_key ]) || !is_array($_FILES[ $this->file_key ]) ) {
			throw new Exceptions\UploadedImporterException(
				__('No file has been sent or improper key of the array of files provided.', 'mm-theme'),
				Exceptions\UploadedImporterException::ERR_NO_FILE
			);
		}

		$this->name = $_FILES[ $this->file_key ]['name'];;
		$this->path = $_FILES[ $this->file_key ]['tmp_name'];

		$this->check_file_errors();
		$this->test_file_size();
		$this->test_file_ext();

		$this->succeeded = true;
	} // import()

	/**
	 * Zwraca rozmiar pobranego pliku w bajtach.
	 *
	 * @return int
	 */
	public function get_file_size () {
		if ( $this->has_succeeded() ) {
			return $_FILES[ $this->file_key ]['size'];
		}

		return 0;
	} // get_file_size()

	/**
	 * Sprawdza, czy PHP sygnalizuje błędy z plikiem.
	 *
	 * @throws SD\File\Exceptions\UploadedImporterException
	 * @return void
	 */
	protected function check_file_errors () {
		$code = $_FILES[ $this->file_key ]['error'];

		if ( $code !== UPLOAD_ERR_OK ) {

			switch ( $code ) :
				case UPLOAD_ERR_INI_SIZE :
					$error = __( 'The file exceedes maximum allowed size limit set in PHP configuration [error: UPLOAD_ERR_INI_SIZE].', 'mm-theme' );
				//	$error = 'Przesłany plik przekracza dozwolony limit określony w konfiguracji PHP [błąd: UPLOAD_ERR_INI_SIZE].';
					$err_code = Exceptions\UploadedImporterException::ERR_INI_SIZE;
					break;
				case UPLOAD_ERR_FORM_SIZE :
					$error = __( 'The file exceedes maximum allowed size limit specified for the form [error: UPLOAD_ERR_FORM_SIZE].', 'mm-theme' );
				//	$error = 'Przesłany plik przekracza dozwolony limit określony na poziomie formularza [błąd: UPLOAD_ERR_FORM_SIZE].';
					$err_code = Exceptions\UploadedImporterException::ERR_FORM_SIZE;
					break;
				case UPLOAD_ERR_PARTIAL :
					$error = __( 'The file has been partially loaded [error: UPLOAD_ERR_PARTIAL].', 'mm-theme' );
				//	$error = 'Plik nie znalazł się na serwerze w całości [błąd: UPLOAD_ERR_PARTIAL].';
					$err_code = Exceptions\UploadedImporterException::ERR_PARTIAL;
					break;
				case UPLOAD_ERR_NO_FILE :
					$error = __( 'No file has been sent [error: UPLOAD_ERR_NO_FILE].', 'mm-theme' );
				//	$error = 'Brak pliku [błąd: UPLOAD_ERR_NO_FILE].';
					$err_code = Exceptions\UploadedImporterException::ERR_NO_FILE;
					break;
				case UPLOAD_ERR_NO_TMP_DIR :
					$error = __( 'The file has not been saved due to problems with temporary directory [error: UPLOAD_ERR_NO_TMP_DIR].', 'mm-theme' );
				//	$error = 'Plik nie został zapisany ze względu na problem z kataerroriem TMP [błąd: UPLOAD_ERR_NO_TMP_DIR].';
					$err_code = Exceptions\UploadedImporterException::ERR_NO_TMP_DIR;
					break;
				case UPLOAD_ERR_CANT_WRITE :
					$error = __( 'The file has not been saved due to problems with writing permissions [error: UPLOAD_ERR_CANT_WRITE].', 'mm-theme' );
				//	$error = 'Plik nie został zapisany ze względu na problem uprawnieniami zapisywania [błąd: UPLOAD_ERR_CANT_WRITE].';
					$err_code = Exceptions\UploadedImporterException::ERR_CANT_WRITE;
					break;
				case UPLOAD_ERR_EXTENSION :
					$error = __( 'The file has not been saved because of improper file extension [error: UPLOAD_ERR_EXTENSION].', 'mm-theme' );
				//	$error = 'Plik nie został zapisany ze względu na nieprawidłowe rozszerzenie [błąd: UPLOAD_ERR_EXTENSION].';
					$err_code = Exceptions\UploadedImporterException::ERR_EXTENSION;
					break;
				default :
					$error = __( 'An unidentified problem occured while trying to save the file. No further information available.', 'mm-theme' );
				//	$error = 'Nieokreślony błąd przy zapisywaniu pliku.';
					$err_code = Exceptions\UploadedImporterException::ERR_UNDEFINED;
					break;
			endswitch;

			throw new Exceptions\UploadedImporterException( $error, $code );
		}
	} // check_file_errors()

} // SD\File\Uploaded
