<?php
namespace SD\File\Exceptions;

/**
 * Wyjątek rzucany w momencie wystąpienia błędu w obiekcie Uploaded.
 */
class UploadedImporterException extends ImporterException {

	/**
	 * Kody błędów obiektu Uploaded (zakres 81-100).
	 *
	 * @var int
	 */
	const ERR_UNDEFINED = 81;
	const ERR_INI_SIZE = 82;
	const ERR_FORM_SIZE = 83;
	const ERR_PARTIAL = 84;
	const ERR_NO_FILE = 85;
	const ERR_NO_TMP_DIR = 86;
	const ERR_CANT_WRITE = 87;
	const ERR_EXTENSION = 88;
	const ERR_FILE_UNDEFINED = 89;

} // SD\File\Exceptions\UploadedImporterException
