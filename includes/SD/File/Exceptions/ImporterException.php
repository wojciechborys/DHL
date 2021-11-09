<?php
namespace SD\File\Exceptions;

/**
 * Wyjątek rzucany w momencie wystąpienia ogólnego błędu Importera.
 */
class ImporterException extends Exception {

	/**
	 * Kody błędów obiektu FileImporter (zakres 1-20).
	 *
	 * @var int
	 */
	const ERR_NO_FILE = 1;
	const ERR_TMP_DIR = 2;
	const ERR_FILE_OVERSIZE = 3;
	const ERR_IMPROPER_EXT = 4;
	const ERR_IMPROPER_FILETYPE = 5;
	const ERR_NOT_EXECUTED = 6;
	const ERR_NOT_SUCCEEDED = 7;
	const ERR_FILE_TOOSMALL = 8;

} // SD\File\Exceptions\ImporterException
