<?php
namespace SD\Contact\Mailing;

use SD\Options\OptionsHelper;

/**
 * Zwraca konfigurację mailingu.
 *
 * @return array
 */
function getSettings() {
    return [
        'from'     => OptionsHelper::get('form::email_from'),
        'fromname' => OptionsHelper::get('form::email_fromname'),
    ];
}

/**
 * Wysyła e-maila.
 *
 * @param string|WP_User $user
 * @param string         $subject
 * @param string         $content
 * @param string|false   $from
 * @param string|false   $fromname
 * @param bool           $use_template
 * @param array|false    $replyTo    Ustawienia nagłówka replyTo. Tablica powinna zawierać email oraz imię i nazwisko array('a@example.com', 'Roman A.')
 * @param array          $importers
 * @return array {
 *     @type bool   $success
 *     @type string $message
 *     @type int    $code
 * }
 */
function sendMail ( $user, $subject, $content, $from = false, $fromname = false, $use_template = true, $replyTo = false, array $importers = [] ) {

    global $phpmailer;

    if (!$phpmailer instanceof \PHPMailer) {
        require_once ABSPATH.WPINC.'/class-phpmailer.php';
        require_once ABSPATH.WPINC.'/class-smtp.php';

        $phpmailer = new \PHPMailer( true );
    }

    $tmpl_path = \get_template_directory() . '/mailing/template.html';
    $tmpl_exists = $use_template ? \file_exists( $tmpl_path ) : false;

    $email_settings = getSettings();

    try {
    	$phpmailer->setLanguage( 'pl' );
    	$phpmailer->CharSet = 'UTF-8';

    	$phpmailer->From = $from ? $from : $email_settings['from'];
    	$phpmailer->FromName = $fromname ? $fromname : $email_settings['fromname'];

        $phpmailer->Subject = $subject;

        if(!empty($replyTo) && \is_array($replyTo)) {

            if (\count($replyTo) === 2) {
                $phpmailer->AddReplyTo($replyTo[0], $replyTo[1]);
            } else {
                $phpmailer->AddReplyTo($replyTo[0]);
            }

        }

        if ($user instanceof \WP_User) {
    	    $phpmailer->addAddress($user->user_email);
        } else {
            $phpmailer->addAddress($user);
        }

        if ($tmpl_exists) {
            $phpmailer->isHTML(true);
            $html = \file_get_contents($tmpl_path);
        } else {
            $html = $content;
        }

        $html = \str_replace('%CONTENT%', $content, $html);
        $html = replacePlaceholders($html);

        $phpmailer->Body = $html;

        foreach ($importers as $importer) {
            if (!$importer instanceof \SD\File\Importer\Importer || !$importer->has_succeeded()) {
                continue;
            }

            $phpmailer->AddAttachment($importer->get_path(), $importer->get_name());
        }

    	$phpmailer->Send();
    } catch (\Exception $ex) {
        $phpmailer->ClearAllRecipients();

        return [
            'success' => false,
            'message' => $ex->getMessage(),
            'code'    => $ex->getCode()
        ];
    }

    $phpmailer->ClearAllRecipients();

    return [
        'success' => true,
        'message' => '',
        'code'    => 0
    ];
}

/**
 * Zamienia placeholdery w treści.
 *
 * @param  string $html
 * @return string
 */
function replacePlaceholders ( $html ) {
    // $email_settings = get_settings();
    //
    // $html = \str_replace( '%MAILING_TMPL_PATH%', \get_template_directory() . '/mailing/', $html );
    //
    // $html = \str_replace( '%HOME_URL%', \esc_url( \home_url('/') ), $html );
    // $html = \str_replace( '%MAIL_TMPL_URL%', \esc_url( \get_stylesheet_directory_uri() . '/mailing/' ), $html );
    // $html = \str_replace( '%TERMS_URL%', \esc_url( \mm_get_terms_url() ), $html );
    //
    // $html = \str_replace( '%CONTACT_MAIL%', $email_settings['contact_mail'], $html );
    // $html = \str_replace( '%GREETING%', $email_settings['greeting'], $html );
    // $html = \str_replace( '%SIGNATURE%', $email_settings['signature'], $html );

    return $html;
}
