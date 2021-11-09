<?php
namespace SD\Dotmailer;

use SD\Newsletter;

include_once get_template_directory().'/includes/RestClient/autoload.php'; // klient REST dla Api dotmailera
include_once get_template_directory().'/includes/Dotmailer/Api/autoload.php'; // API dotmailera

include_once __DIR__.DIRECTORY_SEPARATOR.'options.php';
include_once __DIR__.DIRECTORY_SEPARATOR.'ajax.php';

// add_action('init', function(){
    // $connector = new Connect('apiuser-45e8f696940c@apiconnector.com', 'qwerty123');
    // var_dump($connector->addContactToAddressBook(
    //     'msrodek+1@mintmedia.pl',
    //     1849018,
    //     [
    //         [
    //             'Key'   => 'FULLNAME',
    //             'Value' => 'Mateusz Źrebiec'
    //         ]
    //     ]
    // ));

    // $user = $connector->getContactByEmail('msrodek+1@mintmedia.pl');
    // var_dump($user);
    //
    // var_dump($connector->addContactToAddressBook($user['Id'], 1849018));

    // $connector->addContactToAddressBook(
    //     'mateusz.zrebiec@softdeco.pl',
    //     1849018,
    //     [
    //         'Name' => 'Mateusz Źrebiec'
    //     ]
    // );
// });
