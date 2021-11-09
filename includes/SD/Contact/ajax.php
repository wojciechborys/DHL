<?php
namespace SD\Contact\Ajax;

use SD\Contact\Mailing;
use SD\File\Importer;
use SD\Options\OptionsHelper;;

/**
 * Wysyła maila z formularza kontaktowego.
 *
 * @return void
 */
function sendContactMail() {

    $config = [
        'name' => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_FLAG_ENCODE_AMP,
        ],
        'surname' => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_FLAG_ENCODE_AMP,
        ],
        'phone_no' => [
            'filter' => FILTER_VALIDATE_REGEXP,
            'options' => ['regexp' => '/^(?:\(?\+?48)?(?:[-\.\(\)\s]*(\d)){9}\)?$/']
        ],
        'localization' => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_FLAG_ENCODE_AMP,
        ],
        'processing_consent' => [
            'filter' => FILTER_SANITIZE_STRING,
            'flags' => FILTER_FLAG_ENCODE_AMP,
        ],
    ];

    $input = \filter_input_array(INPUT_POST, $config, true);

    $invalid = $data = [];

    foreach ($input as $field => $val) {
        if (!$val) {
            $invalid[] = $field;
            continue;
        }

        $val = \trim($val);

        if (0 === \strlen($val)) {
            $invalid[] = $field;
            continue;
        }

        $data[$field] = \sanitize_text_field($val);
    }

    # plik
    $fileKey = 'document';

    if (!isset($_FILES[$fileKey])) {
        $invalid[] = $fileKey;
    } else {
        $fileImporter = new Importer\Uploaded($fileKey);

        try {
            $fileImporter->execute();

            $fileType = $fileImporter->get_file_type();

            if (!\in_array($fileType, ['application/pdf', 'image/jpeg', 'application/msword'])) {
                $invalid = $fileKey;
            }
        } catch (\Exception $ex) {
            $invalid = $fileKey;
        }
    }

    if (\count($invalid) > 0) {
        \wp_send_json_error([
            'message' => 'Wystąpił błąd. Prosimy o prawidłowe uzupełnienie wszystkich pól.',
            'invalid' => $invalid,
            'code'    => 1
        ]);
    }

    $attachments = [$fileImporter];

    $emailSubject = OptionsHelper::get('form::email_subject');
    $contactEmail = OptionsHelper::get('form::email_address');

    if (!$contactEmail) {
        $contactEmail = \get_option('admin_email');
    }

    if (!$contactEmail) {
        \wp_send_json_error([
            'message' => 'Wystąpił błąd, prosimy spróbować później.',
            'invalid' => [],
            'code'    => 2
        ]);
    }

    $senderName = 'Formularz kontaktowy';
    $senderEmail = 'no-reply@kariera.dhlexpress.com';

    $homeUrl = \home_url('/');

    $emailContent = <<<EMAIL_CONTENT
Prośba o kontakt wysłana z formularza na stronie {$homeUrl}.

Imię i nazwisko: {$data['name']} {$data['surname']}
Nr telefonu: {$data['phone_no']}
Lokalizacja: {$data['localization']}
Zgoda: {$data['processing_consent']}

---
Wiadomość została wysłana z formularza kontaktowego na stronie {$homeUrl}.
EMAIL_CONTENT;

    $status = Mailing\sendMail(
        $contactEmail,
        $emailSubject,
        $emailContent,
        $senderEmail,
        $senderName,
        false,
        false,
        $attachments
    );

    if (!$status['success']) {
        \wp_send_json_error([
            'message' => 'Wysyłanie wiadomości nie powiodło się.',
            'code'    => 3
        ]);
    }

    \wp_send_json_success([
        'message' => 'Twoja wiadomość została wysłana.',
        'code'    => 0
    ]);
}
\add_action('wp_ajax_send-contact-mail', __NAMESPACE__.'\\sendContactMail');
\add_action('wp_ajax_nopriv_send-contact-mail', __NAMESPACE__.'\\sendContactMail');
