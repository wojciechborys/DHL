<?php
namespace SD\Dotmailer\Ajax;

use SD\Dotmailer\Api;
use SD\Restricted;

/**
 * Zbiera dane potrzebne do rejestracji w newsletterze zawarte w zapytaniu.
 *
 * @return array {
 *   Dane użytkownika.
 *
 *   @type string|null $fullname  Imię i nazwisko.
 *   @type string|null $email     E-mail.
 * }
 */
function collectData() {
    $name = \filter_input(INPUT_POST, 'name');
    $email = \filter_input(INPUT_POST, 'email', FILTER_DEFAULT, FILTER_VALIDATE_EMAIL);

    // $electronicConsent = \filter_input(INPUT_POST, 'electronic-information-consent');
    // $electronicConsentStatement = \filter_input(INPUT_POST, 'electronic-information-consent-statement');

    // $processingConsent = \filter_input(INPUT_POST, 'data-processing-consent');
    // $processingConsentStatement = \filter_input(INPUT_POST, 'data-processing-consent-statement');

    $termsConsent = \filter_input(INPUT_POST, 'terms-consent');
    $termsConsentStatement = \filter_input(INPUT_POST, 'terms-consent-statement');

    if (!empty($name)) {
        $name = \trim($name);
    }

    if (!empty($email)) {
        $email = \trim($email);
    }

    $postID = \filter_input(INPUT_POST, 'related-post', FILTER_VALIDATE_INT);

    $data = [
        'name'                    => $name,
        'email'                   => $email,
        // 'electronic-consent'   => $electronicConsentStatement === 'tak' ? true : false,
        // 'processing-consent'   => $processingConsentStatement === 'tak' ? true : false,
        'terms-consent'           => $termsConsent ? true : false,
        'terms-consent-statement' => $termsConsent ? true : false,
        'post-id'                 => $postID,
    ];

    return $data;
}

/**
 * Obsługuje zapytanie ajaksowe związane z zapisaniem użytkownika do newslettera.
 *
 * @return void
 */
function accessSubmission() {
    $data = collectData();

    $name = $data['name'];
    $email = $data['email'];

    if (empty($name) || empty($email)) {
        \wp_send_json_error([
            'message' => 'Podaj prawidłowe imię oraz e-mail.',
        ]);
    }

    if (empty($data['terms-consent'])) {
        \wp_send_json_error([
            'message' => 'Wyrażenie wszystkich zgód jest obowiązkowe.',
        ]);
    }

    // if (Restricted\hasAccess()) {
    //     \wp_send_json_success([
    //         'message' => 'Dziękujemy! Za chwilę nastąpi przekierowanie.',
    //     ]);
    // }

    $apiData = [
        'FULLNAME' => $name,
        'DATA_SOURCE' => $data['post-id'] ? 'SWIAT_LOCK' : 'SWIAT_FORM' // jeśli post-id, to był wysłany z artykułu
    ];

    $post = $data['post-id'] ? get_post($data['post-id']) : null;

    if ($post instanceof \WP_Post) {
        $apiData['ARTICLE_NAME'] = $post->post_title;

        $postCategories = wp_get_post_categories($post->ID, ['fields' => 'id=>slug']);
        $apiData['ARTICLE_CATEGORY'] = \implode(' ', $postCategories);

        $postTags = wp_get_post_tags($post->ID, ['fields' => 'id=>slug']);
        $apiData['ARTICLE_TAG'] = \implode(' ', $postTags);
    }

    $api = new Api();
    $result = $api->addContactToMainAddressBook(
        $email,
        $apiData
    );

    // $result  = ['success' => true];

    if (!$result['success']) {
        \wp_send_json_error([
            'message' => 'Wystąpił błąd. Prosimy spróbować ponownie.',
            'result'  => $result
        ]);
    }

    Restricted\grantAccess();

    \wp_send_json_success([
        'message' => '',
        'result'  => $result
    ]);
}
\add_action('wp_ajax_access_submission', __NAMESPACE__.'\\accessSubmission');
\add_action('wp_ajax_nopriv_access_submission', __NAMESPACE__.'\\accessSubmission');

/**
 * Obsługuje zapytanie ajaksowe związane z zapisaniem użytkownika do newslettera na stronie glownej.
 *
 * @return void
 */
function accessSubmissionHomepage() {
    $bookID = '50094123';
    $data = collectData();

    $email = $data['email'];

    if (empty($email)) {
        \wp_send_json_error([
            'message' => 'Podaj prawidłowy e-mail.',
        ]);
    }

    if (empty($data['terms-consent'])) {
        \wp_send_json_error([
            'message' => 'Wyrażenie wszystkich zgód jest obowiązkowe.',
        ]);
    }

    // if (Restricted\hasAccess()) {
    //     \wp_send_json_success([
    //         'message' => 'Dziękujemy! Za chwilę nastąpi przekierowanie.',
    //     ]);
    // }

    $apiData = [
        'FULLNAME' => $email,
        'DATA_SOURCE' => $data['post-id'] ? 'HOME_LOCK' : 'HOME_FORM' // jeśli post-id, to był wysłany z artykułu
    ];

    $post = $data['post-id'] ? get_post($data['post-id']) : null;

    if ($post instanceof \WP_Post) {
        $apiData['ARTICLE_NAME'] = $post->post_title;

        $postCategories = wp_get_post_categories($post->ID, ['fields' => 'id=>slug']);
        $apiData['ARTICLE_CATEGORY'] = \implode(' ', $postCategories);

        $postTags = wp_get_post_tags($post->ID, ['fields' => 'id=>slug']);
        $apiData['ARTICLE_TAG'] = \implode(' ', $postTags);
    }

    $api = new Api();
    $result = $api->addContactToMainAddressBook(
        $email,
        $apiData,
        $bookID,
        Api::DOUBLE
    );

    // $result  = ['success' => true];

    if (!$result['success']) {
        \wp_send_json_error([
            'message' => 'Wystąpił błąd. Prosimy spróbować ponownie.',
            'result'  => $result
        ]);
    }

    Restricted\grantAccess();

    \wp_send_json_success([
        'message' => '',
        'result'  => $result
    ]);
}
\add_action('wp_ajax_access_submission_homepage', __NAMESPACE__.'\\accessSubmissionHomepage');
\add_action('wp_ajax_nopriv_access_submission_homepage', __NAMESPACE__.'\\accessSubmissionHomepage');


function access_submission_knowledge() {

    $bookID = '50094123';
    $data = collectData();

    $email = $data['email'];

    if (empty($email)) {
        \wp_send_json_error([
            'message' => 'Podaj prawidłowy e-mail.',
        ]);
    }

    if (empty($data['terms-consent'])) {
        \wp_send_json_error([
            'message' => 'Wyrażenie wszystkich zgód jest obowiązkowe.',
        ]);
    }

    // if (Restricted\hasAccess()) {
    //     \wp_send_json_success([
    //         'message' => 'Dziękujemy! Za chwilę nastąpi przekierowanie.',
    //     ]);
    // }

    $apiData = [
        'FULLNAME' => $email,
        'DATA_SOURCE' =>  'KNOWLEDGE'
    ];

    $api = new Api();
    $result = $api->addContactToMainAddressBook(
        $email,
        $apiData,
        $bookID,
        Api::DOUBLE
    );

    // $result  = ['success' => true];

    if (!$result['success']) {
        \wp_send_json_error([
            'message' => 'Wystąpił błąd. Prosimy spróbować ponownie.',
            'result'  => $result
        ]);
    }

    Restricted\grantAccess();

    \wp_send_json_success([
        'message' => '',
        'result'  => $result
    ]);
}
\add_action('wp_ajax_access_submission_knowledge', __NAMESPACE__.'\\access_submission_knowledge');
\add_action('wp_ajax_nopriv_access_submission_knowledge', __NAMESPACE__.'\\access_submission_knowledge');