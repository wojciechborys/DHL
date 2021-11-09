<?php
namespace SD\Dotmailer;

use SD\Dotmailer\Connect;

/**
 * Klasa upraszczająca komunikację z API dotmailera.
 */
class Api{

    const SINGLE = 'Single';
    const DOUBLE = 'Double';

    /**
     * Login do usługi.
     *
     * @var string|false
     */
    protected $login;

    /**
     * Hasło do usługi.
     *
     * @var string
     */
    protected $password;

    /**
     * Identyfikator głównej książki adresowej.
     *
     * @var string
     */
    protected $mainBook;

    /**
     * Cache na książki adresowe.
     *
     * @var array
     */
    protected $books;

    /**
     * Obiekt konektora.
     * @var SD\Dotmailer\Connect
     */
    protected $connector;

    /**
     * Konstruktor
     */
    public function __construct() {
        $this->getLogin();
        $this->getPassword();

        $this->connector = new Connect($this->login, $this->password);
    }

    /**
     * Zwraca login do usługi.
     *
     * @return string|false
     */
    public function getLogin() {
        if (empty($this->login)){
            $this->login = \get_option('dotmailer_interface_login', '');
        }

        return $this->login;
    }

    /**
     * Zapisuje login do usługi.
     *
     * @param  string $login
     * @return bool
     */
    public function saveLogin($login) {
        return \update_option('dotmailer_interface_login', (string) $login);
    }

    /**
     * Zwraca hasło do usługi.
     *
     * @return string
     */
    public function getPassword() {
        if (empty($this->password)){
            $this->password = \get_option('dotmailer_interface_password', '');
        }

        return $this->password;
    }

    /**
     * Zapisuje hasło do usługi.
     *
     * @param  string $password
     * @return bool
     */
    public function savePassword($password) {
        return \update_option('dotmailer_interface_password', (string) $password);
    }

    /**
     * Zwraca identyfikator głównej książki adresowej.
     *
     * @return int
     */
    public function getMainAddressBookId() {
        if (empty($this->mainBook)){
            $this->mainBook = (int) \get_option('dotmailer_interface_newsletter_book_id');
        }

        return $this->mainBook;
    }

    /**
     * Zapisuje identyfikator głównej książki adresowej.
     *
     * @return bool
     */
    public function saveMainAddressBookId($bookId) {
        return \update_option('dotmailer_interface_newsletter_book_id', (int) $bookId);
    }

    /**
     * Zwraca zapisane książki adresowe.
     *
     * @return array
     */
    public function getAddressBooks() {
        if (empty($this->books)) {
            $books = \get_option('dotmailer_interface_groups', []);
            $this->books = static::parseAddressBooks($books);
        }

        return $this->books;
    }

    /**
     * Zapisuje książki adresowe.
     *
     * @param  array $books
     * @return bool
     */
    public function saveAddressBooks($books) {
        if (!\is_array($books)) {
            return false;
        }

        $option = static::parseAddressBooks($books);
        return \update_option('dotmailer_interface_groups', $option);
    }

    /**
     * Pobiera książki adresowe z usługi.
     *
     * @return array
     */
    public function getAddressBooksFromService() {
        $addressBooks = $this->connector->listAddressBooks();
        return static::parseAddressBooks($addressBooks);
    }

    /**
     * Parsuje książki adresowe.
     *
     * @param  array $books
     * @return array Tablica tablic konfiguracyjnych złożona z indeksów: 'Id' (int),
     *               'Name' (string), 'Visibility' (bool).
     */
    public static function parseAddressBooks($books) {
        if (!\is_array($books)) {
            return [];
        }

        $parsed = [];

        foreach ($books as $book) {
            if (\is_array($book)) {
                $id = empty($book['Id']) ? false : $book['Id'];
                $name = empty($book['Name']) ? false : $book['Name'];
                $visibility = empty($book['Visibility']) ? false : \ucfirst($book['Visibility']);
            } else {
                $name = $id = $visibility = false;
            }

            if (!$id || !$visibility || !$name) {
                continue;
            }

            $parsed[$id] = [
                'Id'         => $id,
                'Name'       => $name,
                'Visibility' => $visibility,
            ];
        }

        return $parsed;
    }

    /**
     * Dodaje kontakt do głównej książki adresowej.
     *
     * @param string $email E-mail kontaktu.
     * @param array  $data  Dane kontaktu.
     * @return array {
     *   Tablica informująca o wyniku dodawania kontaktu.
     *
     *   @type string    $status  Tekstowy status procesu.
     *   @type int|false $id      Identyfikator kontaktu.
     *   @type int|false $book_id Identyfikator książki adresowej.
     *   @type bool      $success Informacja o sukcesie operacji.
     * }
     */
    public function addContactToMainAddressBook($email, $data = null, $addressBookId = false, $optInType = self::SINGLE) {
        $login = $this->getLogin();
        $password = $this->getPassword();
        $bookId = ($addressBookId) ? $addressBookId : $this->getMainAddressBookId();
      //  var_dump($bookId, $login, $password); die;
        if (!$login || !$password || !$bookId) {
            return [
                'status'  => 'no-data',
                'id'      => false,
                'book_id' => $bookId,
                'success' => false
            ];
        }

        $email = \strtolower($email);
        $contact = $this->connector->getContactByEmail($email);
        $contactExists = !empty($contact) && !empty($contact['Id']);

        if ($contactExists && $this->connector->emailInAddressBook($email, $bookId)) {
            return [
                'status'   => 'exists',
                'id'       => $contact['Id'],
                'book_id'  => $bookId,
                'success'  => true
            ];
        }

        if (!$contactExists) {
            $data = \wp_parse_args($data, [
                'FULLNAME'    => false,
            ]);

            if ($data['FULLNAME']) {
                $fullName = \explode(' ', $data['FULLNAME']);
                $fullName = \array_filter($fullName);

                if (!empty($fullName[0])) {
                    $data['FIRSTNAME'] = $fullName[0];
                }

                if (!empty($fullName[1])) {
                    $data['LASTNAME'] = $fullName[1];
                }
            }

            $parsedData = [];

            foreach ($data as $key => $value) {
                $parsedData[] = [
                    'Key'   => $key,
                    'Value' => $value
                ];
            }

            $added = $this->connector->addEmailToAddressBook(
                $email,
                $bookId,
                $parsedData,
                $optInType
            );
        } else {
            $added = $this->connector->addContactToAddressBook($contact['Id'], $bookId);
        }

        if (empty($added)) {
            return [
                'status'   => 'failed',
                'id'       => $contactExists ? $contact['Id'] : false,
                'book_id'  => $bookId,
                'success'  => false
            ];
        }

        return [
            'status'  => 'success',
            'id'      => $added['Id'],
            'book_id' => $bookId,
            'success' => true
        ];
    }

}
