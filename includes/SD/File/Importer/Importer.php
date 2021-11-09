<?php
namespace SD\File\Importer;

/**
 * Interfejs służący do pobierania obrazów.
 *
 * @version 1.0.1
 */
interface Importer {

	/**
	 * Metoda pobierająca element.
	 *
	 * @return bool
	 */
	public function execute ();

	/**
	 * Metoda zwracająca ścieżkę do pliku razem z nazwą pliku.
	 *
	 * @return string
	 */
	public function get_path ();

	/**
	 * Metoda zwracająca nazwę pliku.
	 *
	 * @return string
	 */
	public function get_name ();

	/**
	 * Metoda kasująca pobrany plik.
	 */
	public function delete_file ();

	/**
	 * Metoda informująca o stanie wykonania pobierania.
	 *
	 * @return bool
	 */
	public function has_executed ();

	/**
	 * Metoda sprawdzająca, czy pobieranie zakończyło się sukcesem.
	 *
	 * @return bool
	 */
	public function has_succeeded ();

	/**
	 * Metoda zwracająca typ treści pliku.
	 *
	 * @return string
	 */
	public function get_file_type ();

	/**
	 * Metoda zwracająca rozmiar pliku.
	 *
	 * @return string
	 */
	public function get_size ();

} // SD\File\Importer
