<?php

namespace SD\DotMailer;

use DotMailer\Api as DotMailerApi;

/**
 * Konektor do API dotmailera.
 */
class Connect {

    /**
     * Nazwa użytkownika.
     *
     * @var string
     */
    private $username;

    /**
     * Hasło użytkownika.
     *
     * @var string
     */
    private $password;

    /**
     * Zasoby.
     *
     * @var DotMailer\Api\Resources\IResources|null
     */
	private $resources;

    /**
     * Konstruktor.
     *
     * @param string $username
     * @param string $password
     */
    public function __construct( $username, $password ) {

		$this->username = $username;
        $this->password = $password;

		$credentials = [
		    DotMailerApi\Container::USERNAME => $username,
		    DotMailerApi\Container::PASSWORD => $password
		];

		if (!empty($this->username) && !empty($this->password)) {
            $this->resources = DotMailerApi\Container::newResources($credentials);
        }
    }

    /**
     * Zwraca informacje o koncie.
     *
     * @return array|false|null
     */
	public function getAccountInfo() {

		if (isset($this->resources)) {

			try {
				return \json_decode(
                    $this->resources->GetAccountInfo(),
                    true
                );
			} catch (DotMailerApi\Exception $e) {
				return false;
			}
        }

        return null;
	}

    /**
     * Zwraca listę książek adresowych.
     *
     * @return array|false|null
     */
    public function listAddressBooks() {

		if (isset($this->resources)) {

			try {
				return \json_decode(
                    $this->resources->GetAddressBooks(),
                    true
                );
			} catch (DotMailerApi\Exception $e) {
				return false;
			}
		}

        return null;
    }

    /**
     * Zwraca tablicę pól danych.
     *
     * @return array|false|null
     */
	public function listDataFields() {

        if (isset($this->resources)) {

			try {
				return \json_decode(
                    $this->resources->GetDataFields(),
                    true
                );
			} catch (DotMailerApi\Exception $e) {
				return false;
			}
		}

        return null;
	}

    /**
     * Dodaje e-mail do książki adresowej.
     *
     * @param string $email
     * @param int    $addressBookId
     * @param mixed  $dataFields
     * @return array|false|null
     */
	public function addEmailToAddressBook($email, $addressBookId, $dataFields = "", $optinType = 'Single') {

        if (isset($this->resources)) {
    		try {

    			$apiContact = new DotMailerApi\DataTypes\ApiContact([
    				'Id'		=> -1,
    				'Email'		=> $email,
    				'OptInType'	=> $optinType,
    				'EmailType'	=> "Html",
    				'DataFields' => $dataFields,
    			]);

    			return \json_decode(
                    $this->resources->PostAddressBookContacts($addressBookId, $apiContact),
                    true
                );
    		} catch (DotMailerApi\Exception $e) {
    			return false;
    		}
		}

        return null;
	}

    /**
     * Dodaje kontakt do książki adresowej.
     *
     * @param int $contactId
     * @param int $addressBookId
     * @return array|false|null
     */
	public function addContactToAddressBook($contactId, $addressBookId) {

        if (isset($this->resources)) {
    		try {

    			$contact = \json_decode(
                    $this->resources->GetContactById($contactId),
                    true
                );

                if (empty($contact)) {
                    return false;
                }

                $apiContact = new DotMailerApi\DataTypes\ApiContact($contact);

                return \json_decode(
                    $this->resources->PostAddressBookContacts($addressBookId, $apiContact),
                    true
                );
    		} catch (DotMailerApi\Exception $e) {
    			return false;
    		}
		}

        return null;
	}

    /**
     * Pobiera kontakt na podstawie e-maila.
     *
     * @param  string $email
     * @return array|false|null
     */
	public function getContactByEmail($email) {

        if (isset($this->resources)) {
    		try {
    			return \json_decode(
                    $this->resources->GetContactByEmail($email),
                    true
                );
    		} catch (DotMailerApi\Exception $e) {
    			return false;
    		}
		}

        return null;
    }

    /**
     * Sprawdza, czy e-mail jest już w książce adresowej.
     *
     * @param  string $email
     * @param  int    $addressBookId
     * @return bool|null
     */
	public function emailInAddressBook($email, $addressBookId) {

        if (isset($this->resources)) {

    		try {

                $contact = $this->getContactByEmail($email);

                if (empty($contact)) {
                    return null;
                }

                $contactAddressBooks = \json_decode(
                    $this->resources->GetContactAddressBooks($contact['Id']),
                    true
                );

                if (empty($contactAddressBooks)) {
                    return false;
                }

                $addressBookId = (int) $addressBookId;
                $isIn = false;

                foreach ($contactAddressBooks as $addressBook) {
                    if ($addressBookId === (int) $addressBook['Id']) {
                        $isIn = true;
                        break;
                    }
                }

                return $isIn;
    		} catch (DotMailerApi\Exception $e) {
    			return false;
    		}
		}

        return null;
    }

    /**
     * Zwraca status kontaktu na podstawie e-maila.
     *
     * @param  string $email
     * @return string|false
     */
	public function getStatusByEmail($email) {

		$contact = $this->getContactByEmail($email);

		if (!$contact || $contact["Status"] === null) {
            return false;
        }

        return $contact["Status"];
    }

    /**
     * Wypisuje kontakt z książki adresowej.
     *
     * @param  int $contactId
     * @param  int $addressBookId
     * @return array|bool|null
     */
    public function unSubscribeContact($contactId, $addressBookId) {

        if (isset($this->resources)) {
    		try {

                return \json_decode(
                    $this->resources->DeleteAddressBookContact($addressBookId, $contactId),
                    true
                );
    		} catch (DotMailerApi\Exception $e) {
    			return false;
    		}
		}

        return null;
    }

    /**
     * Wypisuje kontakt z jednej lub więcej książki adresowej na podstawie e-maila.
     *
     * @param  string $email
     * @param  int    $addressBookId
     * @return array|bool|null
     */
	public function unSubscribeContactByEmail($email, $addressBookIds = []) {

		try {

            $contact = $this->getContactByEmail($email);

            if (empty($contact)) {
                return null;
            }

            $contactAddressBooks = \json_decode(
                $this->resources->GetContactAddressBooks($contact['Id']),
                true
            );

            if (empty($addressBookIds)) {
                $addressBookIds = [];

                foreach ($contactAddressBooks as $addressBook) {
                    $addressBookIds[] = (int) $addressBook['Id'];
                }
            } elseif (!\is_array($addressBookId)) {
                $addressBookIds = [(int) $addressBookIds];
            }

            $unsubscribed = [];

            foreach ($contactAddressBooks as $contactBook) {
                $contactBookId = (int) $contactBook['Id'];

                if (\in_array($contactBookId, $addressBookIds)) {
                    $unsubscribed[$contactBookId] = $this->unSubscribeContact($contact['Id'], $contactBookId);
                }
            }

            return $unsubscribed;
		} catch (DotMailerApi\Exception $e) {
			return false;
		}
    }

    /**
     * Ponownie zapisuje kontakt do książki adresowej na podstawie e-maila.
     *
     * @param  string $email
     * @param  int    $addressBookId
     * @param  string $dataFields
     * @return [type]
     */
	public function reSubscribeContact($email, $addressBookId, $dataFields = '', $optInType = 'Single') {

		try {

			$apiContact = new DotMailerApi\DataTypes\ApiContact([
				'Id'		=> -1,
				'Email'		=> $email,
				'OptInType'	=> $optInType,
				'EmailType'	=> 'Html',
				'DataFields' => $dataFields,
			]);

			$reSubscribeContact = new DotMailerApi\DataTypes\ApiContactResubscription([
				'UnsubscribedContact'        => $apiContact,
				'PreferredLocale'            => '',
				'ReturnUrlToUseIfChallenged' => '',
		 	]);

			return \json_decode(
                $this->resources->PostAddressBookContactsResubscribe($addressBookId, $reSubscribeContact),
                true
            );
		} catch (DotMailerApi\Exception $e) {
			return false;
		}
    }

}
