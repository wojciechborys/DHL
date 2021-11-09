<?php
namespace SD\File\Importer;

use SD\File\Exceptions;

/**
 * Klasa do obsługi pobierania plików.
 *
 * @version 1.0.0
 */
abstract class FileImporter implements Importer {

	/**
	 * Kontrolka wykonania pobierania.
	 *
	 * @var bool
	 */
	protected $executed = false;

	/**
	 * Kontrolka sukcesu pobierania.
	 *
	 * @var bool
	 */
	protected $succeeded = false;

	/**
	 * Dozwolone rozszerzenia.
	 *
	 * @var int
	 */
	protected $valid_ext = array();

	/**
	 * Minimalny rozmiar pliku w bajtach.
	 *
	 * @var int
	 */
	protected $min_size = 0;

	/**
	 * Maksymalny rozmiar pliku w bajtach.
	 *
	 * @var int
	 */
	protected $max_size = 0;

	/**
	 * Pierwotna nazwa pobranego pliku.
	 *
	 * @var string
	 */
	protected $name = '';

	/**
	 * Lokalizacja pobranego pliku na dysku.
	 *
	 * @var string
	 */
	protected $path = '';

	/**
	 * Typ pliku na podstawie rozszerzenia.
	 *
	 * @var string
	 */
	protected $content_type = '';

	/**
	 * Typ mime pliku na podstawie zawartości.
	 *
	 * @var string
	 */
	protected $mime_type = '';

	/**
	 * Tablica mapująca rozszerzenia do typów mime.
	 *
	 * @var array
	 */
	protected static $ext2mime = array(
		'hqx'	=>	array('application/mac-binhex40', 'application/mac-binhex', 'application/x-binhex40', 'application/x-mac-binhex40'),
		'cpt'	=>	'application/mac-compactpro',
		'csv'	=>	array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'),
		'bin'	=>	array('application/macbinary', 'application/mac-binary', 'application/octet-stream', 'application/x-binary', 'application/x-macbinary'),
		'dms'	=>	'application/octet-stream',
		'lha'	=>	'application/octet-stream',
		'lzh'	=>	'application/octet-stream',
		'exe'	=>	array('application/octet-stream', 'application/x-msdownload'),
		'class'	=>	'application/octet-stream',
		'psd'	=>	array('application/x-photoshop', 'image/vnd.adobe.photoshop'),
		'so'	=>	'application/octet-stream',
		'sea'	=>	'application/octet-stream',
		'dll'	=>	'application/octet-stream',
		'oda'	=>	'application/oda',
		'pdf'	=>	array('application/pdf', 'application/force-download', 'application/x-download', 'binary/octet-stream'),
		'ai'	=>	array('application/pdf', 'application/postscript'),
		'eps'	=>	'application/postscript',
		'ps'	=>	'application/postscript',
		'smi'	=>	'application/smil',
		'smil'	=>	'application/smil',
		'mif'	=>	'application/vnd.mif',
		'xls'	=>	array('application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword'),
		'ppt'	=>	array('application/powerpoint', 'application/vnd.ms-powerpoint', 'application/vnd.ms-office', 'application/msword'),
		'pptx'	=> 	array('application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/x-zip', 'application/zip'),
		'wbxml'	=>	'application/wbxml',
		'wmlc'	=>	'application/wmlc',
		'dcr'	=>	'application/x-director',
		'dir'	=>	'application/x-director',
		'dxr'	=>	'application/x-director',
		'dvi'	=>	'application/x-dvi',
		'gtar'	=>	'application/x-gtar',
		'gz'	=>	'application/x-gzip',
		'gzip'  =>	'application/x-gzip',
		'php'	=>	array('application/x-httpd-php', 'application/php', 'application/x-php', 'text/php', 'text/x-php', 'application/x-httpd-php-source'),
		'php4'	=>	'application/x-httpd-php',
		'php3'	=>	'application/x-httpd-php',
		'phtml'	=>	'application/x-httpd-php',
		'phps'	=>	'application/x-httpd-php-source',
		'js'	=>	array('application/x-javascript', 'text/plain'),
		'swf'	=>	'application/x-shockwave-flash',
		'sit'	=>	'application/x-stuffit',
		'tar'	=>	'application/x-tar',
		'tgz'	=>	array('application/x-tar', 'application/x-gzip-compressed'),
		'z'	=>	'application/x-compress',
		'xhtml'	=>	'application/xhtml+xml',
		'xht'	=>	'application/xhtml+xml',
		'zip'	=>	array('application/x-zip', 'application/zip', 'application/x-zip-compressed', 'application/s-compressed', 'multipart/x-zip'),
		'rar'	=>	array('application/x-rar', 'application/rar', 'application/x-rar-compressed'),
		'mid'	=>	'audio/midi',
		'midi'	=>	'audio/midi',
		'mpga'	=>	'audio/mpeg',
		'mp2'	=>	'audio/mpeg',
		'mp3'	=>	array('audio/mpeg', 'audio/mpg', 'audio/mpeg3', 'audio/mp3'),
		'aif'	=>	array('audio/x-aiff', 'audio/aiff'),
		'aiff'	=>	array('audio/x-aiff', 'audio/aiff'),
		'aifc'	=>	'audio/x-aiff',
		'ram'	=>	'audio/x-pn-realaudio',
		'rm'	=>	'audio/x-pn-realaudio',
		'rpm'	=>	'audio/x-pn-realaudio-plugin',
		'ra'	=>	'audio/x-realaudio',
		'rv'	=>	'video/vnd.rn-realvideo',
		'wav'	=>	array('audio/x-wav', 'audio/wave', 'audio/wav'),
		'bmp'	=>	array('image/bmp', 'image/x-bmp', 'image/x-bitmap', 'image/x-xbitmap', 'image/x-win-bitmap', 'image/x-windows-bmp', 'image/ms-bmp', 'image/x-ms-bmp', 'application/bmp', 'application/x-bmp', 'application/x-win-bitmap'),
		'gif'	=>	'image/gif',
		'jpeg'	=>	array('image/jpeg', 'image/pjpeg'),
		'jpg'	=>	array('image/jpeg', 'image/pjpeg'),
		'jpe'	=>	array('image/jpeg', 'image/pjpeg'),
		'jp2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'j2k'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'jpf'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'jpg2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'jpx'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'jpm'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'mj2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'mjp2'	=>	array('image/jp2', 'video/mj2', 'image/jpx', 'image/jpm'),
		'png'	=>	array('image/png',  'image/x-png'),
		'tiff'	=>	'image/tiff',
		'tif'	=>	'image/tiff',
		'css'	=>	array('text/css', 'text/plain'),
		'html'	=>	array('text/html', 'text/plain'),
		'htm'	=>	array('text/html', 'text/plain'),
		'shtml'	=>	array('text/html', 'text/plain'),
		'txt'	=>	'text/plain',
		'text'	=>	'text/plain',
		'log'	=>	array('text/plain', 'text/x-log'),
		'rtx'	=>	'text/richtext',
		'rtf'	=>	'text/rtf',
		'xml'	=>	array('application/xml', 'text/xml', 'text/plain'),
		'xsl'	=>	array('application/xml', 'text/xsl', 'text/xml'),
		'mpeg'	=>	'video/mpeg',
		'mpg'	=>	'video/mpeg',
		'mpe'	=>	'video/mpeg',
		'qt'	=>	'video/quicktime',
		'mov'	=>	'video/quicktime',
		'avi'	=>	array('video/x-msvideo', 'video/msvideo', 'video/avi', 'application/x-troff-msvideo'),
		'movie'	=>	'video/x-sgi-movie',
		'doc'	=>	array('application/msword', 'application/vnd.ms-office'),
		'docx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip'),
		'dot'	=>	array('application/msword', 'application/vnd.ms-office'),
		'dotx'	=>	array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword'),
		'xlsx'	=>	array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/vnd.ms-excel', 'application/msword', 'application/x-zip'),
		'word'	=>	array('application/msword', 'application/octet-stream'),
		'xl'	=>	'application/excel',
		'eml'	=>	'message/rfc822',
		'json'  =>	array('application/json', 'text/json'),
		'pem'   =>	array('application/x-x509-user-cert', 'application/x-pem-file', 'application/octet-stream'),
		'p10'   =>	array('application/x-pkcs10', 'application/pkcs10'),
		'p12'   =>	'application/x-pkcs12',
		'p7a'   =>	'application/x-pkcs7-signature',
		'p7c'   =>	array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
		'p7m'   =>	array('application/pkcs7-mime', 'application/x-pkcs7-mime'),
		'p7r'   =>	'application/x-pkcs7-certreqresp',
		'p7s'   =>	'application/pkcs7-signature',
		'crt'   =>	array('application/x-x509-ca-cert', 'application/x-x509-user-cert', 'application/pkix-cert'),
		'crl'   =>	array('application/pkix-crl', 'application/pkcs-crl'),
		'der'   =>	'application/x-x509-ca-cert',
		'kdb'   =>	'application/octet-stream',
		'pgp'   =>	'application/pgp',
		'gpg'   =>	'application/gpg-keys',
		'sst'   =>	'application/octet-stream',
		'csr'   =>	'application/octet-stream',
		'rsa'   =>	'application/x-pkcs7',
		'cer'   =>	array('application/pkix-cert', 'application/x-x509-ca-cert'),
		'3g2'   =>	'video/3gpp2',
		'3gp'   =>	array('video/3gp', 'video/3gpp'),
		'mp4'   =>	'video/mp4',
		'm4a'   =>	'audio/x-m4a',
		'f4v'   =>	array('video/mp4', 'video/x-f4v'),
		'flv'	=>	'video/x-flv',
		'webm'	=>	'video/webm',
		'aac'   =>	'audio/x-acc',
		'm4u'   =>	'application/vnd.mpegurl',
		'm3u'   =>	'text/plain',
		'xspf'  =>	'application/xspf+xml',
		'vlc'   =>	'application/videolan',
		'wmv'   =>	array('video/x-ms-wmv', 'video/x-ms-asf'),
		'au'    =>	'audio/x-au',
		'ac3'   =>	'audio/ac3',
		'flac'  =>	'audio/x-flac',
		'ogg'   =>	array('audio/ogg', 'video/ogg', 'application/ogg'),
		'kmz'	=>	array('application/vnd.google-earth.kmz', 'application/zip', 'application/x-zip'),
		'kml'	=>	array('application/vnd.google-earth.kml+xml', 'application/xml', 'text/xml'),
		'ics'	=>	'text/calendar',
		'ical'	=>	'text/calendar',
		'zsh'	=>	'text/x-scriptzsh',
		'7zip'	=>	array('application/x-compressed', 'application/x-zip-compressed', 'application/zip', 'multipart/x-zip'),
		'cdr'	=>	array('application/cdr', 'application/coreldraw', 'application/x-cdr', 'application/x-coreldraw', 'image/cdr', 'image/x-cdr', 'zz-application/zz-winassoc-cdr'),
		'wma'	=>	array('audio/x-ms-wma', 'video/x-ms-asf'),
		'jar'	=>	array('application/java-archive', 'application/x-java-application', 'application/x-jar', 'application/x-compressed'),
		'svg'	=>	array('image/svg+xml', 'application/xml', 'text/xml'),
		'vcf'	=>	'text/x-vcard',
		'srt'	=>	array('text/srt', 'text/plain'),
		'vtt'	=>	array('text/vtt', 'text/plain'),
		'ico'	=>	array('image/x-icon', 'image/x-ico', 'image/vnd.microsoft.icon'),
		'odc'	=>	'application/vnd.oasis.opendocument.chart',
		'otc'	=>	'application/vnd.oasis.opendocument.chart-template',
		'odf'	=>	'application/vnd.oasis.opendocument.formula',
		'otf'	=>	'application/vnd.oasis.opendocument.formula-template',
		'odg'	=>	'application/vnd.oasis.opendocument.graphics',
		'otg'	=>	'application/vnd.oasis.opendocument.graphics-template',
		'odi'	=>	'application/vnd.oasis.opendocument.image',
		'oti'	=>	'application/vnd.oasis.opendocument.image-template',
		'odp'	=>	'application/vnd.oasis.opendocument.presentation',
		'otp'	=>	'application/vnd.oasis.opendocument.presentation-template',
		'ods'	=>	'application/vnd.oasis.opendocument.spreadsheet',
		'ots'	=>	'application/vnd.oasis.opendocument.spreadsheet-template',
		'odt'	=>	'application/vnd.oasis.opendocument.text',
		'odm'	=>	'application/vnd.oasis.opendocument.text-master',
		'ott'	=>	'application/vnd.oasis.opendocument.text-template',
		'oth'	=>	'application/vnd.oasis.opendocument.text-web'
	);

	/**
	 * Wykonuje pobieranie pliku.
	 *
	 * @param bool $force Czy wymusić wykonanie czynności?
	 * @return bool
	 */
	public function execute ( $force = false ) {
		if ( $this->executed && !$force ) {
			return $this->succeeded;
		}

		$this->executed = true;

		$this->import();

		$path = $this->get_path();

		$this->succeeded = ( $path && file_exists($path) );

		return $this->succeeded;
	} // execute()

	/**
	 * Importuje plik.
	 *
	 * @return bool
	 */
	abstract protected function import();

	/**
	 * Pobranie informacji o kontrolce wykonania połączenia.
	 *
	 * @return bool
	 */
	public function has_executed () {
		return $this->executed;
	} // has_executed()

	/**
	 * Sprawdzenie, czy połączenie zakończyło się sukcesem.
	 *
	 * @return bool
	 */
	public function has_succeeded () {
		return $this->succeeded;
	} // has_succeeded()

	/**
	 * Pobranie lokalizacji pobranego pliku.
	 *
	 * @return Resource Pobrany obraz
	 */
	public function get_path () {
		return $this->path;
	} // get_path()

	/**
	 * Zwraca nazwę pliku.
	 *
	 * @return string
	 */
	public function get_name () {
		return $this->name;
	} // get_name()

	/**
	 * Zwraca typ zawartości pliku na bazie nazwy pliku.
	 *
	 * @return string
	 */
	public function get_file_type () {
		if ( !$this->content_type && $this->has_succeeded() ) {
			$ft = wp_check_filetype( $this->name );
			$this->content_type = $ft['type'];
		}

		return $this->content_type;
	} // get_file_type()

	/**
	 * Zwraca typ mime pliku.
	 *
	 * @return string
	 */
	public function get_mime_type () {
		if ( !$this->mime_type && $this->has_succeeded() ) {
		//	$this->mime_type = mime_content_type( $this->path );
			$finfo = finfo_open( FILEINFO_MIME_TYPE );
			$this->mime_type = finfo_file( $finfo, $this->path );
			finfo_close( $finfo );
		}

		return $this->mime_type;
	} // get_mime_type()

	/**
	 * Usunięcie obrazu tymczasowego.
	 *
	 * @return void
	 */
	public function delete_file () {
		$path = $this->get_path();

		if ( $path && file_exists($path) ) {
			unlink( $path );
		}
	} // delete_file()

	/**
	 * Ustawia minimalny rozmiar pliku.
	 *
	 * @param int $max_size Maksymalny rozmiar pliku w bajtach.
	 * @return void
	 */
	public function set_min_size ( $max_size ) {
		$this->min_size = absint( $max_size );
	} // set_min_size()

	/**
	 * Ustawia maksymalny rozmiar pliku.
	 *
	 * @param int $max_size Maksymalny rozmiar pliku w bajtach.
	 * @return void
	 */
	public function set_max_size ( $max_size ) {
		$this->max_size = absint( $max_size );
	} // set_max_size()

	/**
	 * Zwraca maksymalny rozmiar pliku w bajtach.
	 *
	 * @return int
	 */
	public function get_max_size () {
		return $this->max_size;
	} // set_max_size()

	/**
	 * Porównuje podaną wartość z wielkością pobranego pliku.
	 *
	 * @param int $size Rozmiar do porównania. Jeśli nie zostanie podany, rozmiar pliku zostanie
	 *                  porównany z rozmiarem maksymalnym.
	 * @return int Liczba wskazująca na stosunek podanego rozmiaru do rozmiaru przesłanego pliku:
	 *             0 - jeśli rozmiary są równe (lub plik nie istnieje), 1 - jeśli podany rozmiar
	 *             jest większy od rozmiaru przesłanego pliku, -1 - jeśli podany romiar jest
	 *             mniejszy niż rozmiar przesłanego pliku.
	 */
	public function compare_size ( $size = null ) {
		$comp = 0;

		if ( $this->has_executed() ) {
			$file_size = $this->get_file_size();

			if ( null === $size ) {
				$size = $this->max_size;
			}

			if ( $size <= $file_size ) {
				$comp = 1;
			} elseif ( $size < $file_size ) {
				$comp = -1;
			}
		}

		return $comp;
	} // compare_size()

	/**
	 * Zwraca rozmiar pobranego pliku w bajtach.
	 *
	 * @return int
	 */
	public function get_file_size () {
		if ( $this->has_executed() ) {
			return filesize( $this->get_path() );
		}

		return 0;
	} // get_file_size()

	/**
	 * Zwraca rozmiar pliku w podanej jednostce.
	 *
	 * @param string $unit Jednostka. Domyślnie bajty.
	 * @return int
	 */
	public function get_size ( $unit = 'B' ) {
		if ( !$this->has_executed() ) {
			return 0;
		}

		$unit = strtolower( $unit );
		$size = $this->get_file_size();

		if ( $size === 0 ) {
			return 0;
		}

		switch ( $unit ) {
			case 'gb':
			case 'gigabytes':
				$size = ( $size / 1024 / 1024 / 1024 );
				break;
			case 'mb':
			case 'megabytes':
				$size = ( $size / 1024 / 1024 );
				break;
			case 'kb':
			case 'kilobytes':
				$size = ( $size / 1024 );
				break;
		}

		return $size;
	} // get_size()

	/**
	 * Sprawdza, czy plik nie jest za duży, o ile maksymalny rozmiar został ustawiony.
	 *
	 * @throws SD\FilesImporter\Exceptions\ImporterException
	 * @return void
	 */
	protected function test_file_size () {
		if ( !$this->has_executed() ) {
			throw new Exceptions\ImporterException(
				__( 'Unable to test file size because the importer has not imported it.', 'mm-theme' ),
				Exceptions\ImporterException::ERR_NOT_SUCCEEDED
			);
		}

		if ( $this->max_size > 0 ) {
			if ( 1 === $this->compare_size() ) {
				$size_in_mb = round( $this->get_file_size('MB'), 2 );
				$maxsize_in_mb = round( ( $this->max_size / 1024 / 1024 ), 2 );

				throw new Exceptions\ImporterException(
					sprintf(
						__( 'The uploaded file exceedes maximum allowed size (%1$d MB). Its size is %2$d MB.', 'mm-theme' ),
						$maxsize_in_mb, $size_in_mb
					),
					Exceptions\ImporterException::ERR_FILE_OVERSIZE
				);
			}
		}
	} // test_file_size()

	/**
	 * Sprawdza, czy plik ma odpowiednie rozszerzenie.
	 *
	 * @throws SD\FilesImporter\Exceptions\ImporterException
	 * @return void
	 */
	public function test_file_ext () {
		if ( empty($this->valid_ext) ) {
			return;
		}

		if ( !$this->has_executed() ) {
			throw new Exceptions\ImporterException(
				__( 'Unable to test file extension because the importer has not imported the file.', 'mm-theme' ),
				Exceptions\ImporterException::ERR_NOT_SUCCEEDED
			);
		}

		$ext = mb_strtolower( pathinfo($this->get_name(), PATHINFO_EXTENSION) );

		if ( !$this->is_valid_ext($ext) ) {
			throw new Exceptions\ImporterException(
				__( 'The file has improper extension.', 'mm-theme'),
				Exceptions\ImporterException::ERR_IMPROPER_EXT
			);
		}
	} // test_file_ext()

	/**
	 * Dodaje dozwolone rozszerzenie/rozszerzenia plików.
	 *
	 * @param string|array $ext Dozwolone rozszerzenie lub tablica rozszerzeń.
	 * @return array Dozwolone rozszerzenia po operacji dodawania.
	 */
	public function add_valid_ext ( $ext ) {
		if ( !is_array($ext) ) {
			$ext = array( $ext );
		}

		$this->valid_ext += array_map( 'strtolower', $ext );
		$this->valid_ext = array_filter( $this->valid_ext ); // potencjalnie puste
		$this->valid_ext = array_unique( $this->valid_ext ); // bez duplikatów
		return $this->valid_ext;
	} // add_valid_ext()

	/**
	 * Zwraca dozwolone rozszerzenia.
	 *
	 * @return array Dozwolone rozszerzenia.
	 */
	public function get_valid_ext () {
		return $this->valid_ext;
	} // get_valid_ext()

	/**
	 * Usuwa dozwolone rozszerzenia.
	 *
	 * @param string|array $ext Rozszerzenie lub tablica rozszerzeń do usunięcia.
	 * @return array Dozwolone rozszerzenia po operacji usuwania.
	 */
	public function remove_valid_ext ( $ext ) {
		if ( !is_array($ext) ) {
			$ext = array( $ext );
		}

		$valid = array_diff( $this->valid_ext, $ext );
		$this->valid_ext = array_values( $valid ); // reindeksowanie tablicy
		return $this->valid_ext;
	} // remove_valid_ext()

	/**
	 * Sprawdza, czy podane rozszerzenie pliku jest dozwolone
	 *
	 * @param string|array $ext Rozszerzenie lub tablica rozszerzeń do sprawdzenia.
	 * @return bool Wynik sprawdzenia.
	 */
	public function is_valid_ext ( $ext ) {
		if ( empty($this->valid_ext) ) {
			return true;
		}

		if ( empty($ext) ) {
			return false;
		}

		if ( !is_array($ext) ) {
			$ext = array( $ext );
		}

		$diff = array_diff( $ext, $this->valid_ext );

		return ( count($diff) === 0 );
	} // is_valid_ext()

} // SD\File\FileImporter
