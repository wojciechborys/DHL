<?php

add_action('wp_ajax_contact_form', 'contact_form'); //
add_action('wp_ajax_nopriv_contact_form', 'contact_form');

function contact_form()
{
    $data = esc_sql(maybe_unserialize($_POST));
    $return_data = [];
    $return_error = [];
    // $body_email = "";
    if (!$data) {
        wp_send_json_error("cant read post data");
    } else {
        foreach ($data as $key => $single_field) {
            if ($key !== 'tracking-number' && ($single_field === NULL || $single_field === '')) {
                $return_error[$key] = 'error in this field';
            } else {
                $return_data[$key] = $single_field;
                // $body_email .= $key.": ".$single_field."<br/>";
            }
        }
        if ($return_error) {
            wp_send_json_error($return_error);
        } else {
//            wp_send_json_success('evrything its ok');

            if ($_FILES['file_contact']['name'] != "") {
                $allowed = array('png', 'jpg', 'jpeg,', 'JPEG', 'pdf', 'PDF', 'doc', 'docx');
                $filename = $_FILES['file_contact']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);
                if (!in_array($ext, $allowed)) {
                    wp_send_json_error("Couldn't send this message");
                }
                require_once(ABSPATH . 'wp-admin/includes/image.php');
                require_once(ABSPATH . 'wp-admin/includes/file.php');
                require_once(ABSPATH . 'wp-admin/includes/media.php');

                $uploadedfile = $_FILES['file_contact'];
                $upload_overrides = array(
                    'test_form' => false
                );
                $movefile = wp_handle_upload($uploadedfile, $upload_overrides);

                if ($movefile && !isset($movefile['error'])) {


                    $to = $return_data['recipment-email'];

                    $subject = 'Wiadomość z formularza dhlexpress.pl';
                    if ($return_data['tracking-number']) {

                        $body = "Temat: " . $return_data['subject_recipient'] . "<br/>Imie i nazwisko: " . $return_data['name'] . " " . $return_data['surname'] . " <br/> Email: " . $return_data['email'] . " <br/> Numer telefonu: " . $return_data['phone'] . " <br/> Numer przesylki:" . $return_data['tracking-number'] . "<br/>";

                    } else {
                        $body = "Temat: " . $return_data['subject_recipient'] . "<br/>Imie i nazwisko: " . $return_data['name'] . " " . $return_data['surname'] . " <br/> Email: " . $return_data['email'] . " <br/> Numer telefonu: " . $return_data['phone'] . "<br/>";
                    }
                    if ($return_data['message']) {
                        $body .= "Wiadomość:" . $return_data['message'];
                    }
                    $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Formularz <kontakt@dhlexpress.pl>', 'Reply-To: <' . $to . '>');

                    $send_mail = wp_mail($to, $subject, $body, $headers, $movefile);
                    unlink($movefile['file']);
                    if ($send_mail) {
                        wp_send_json_success("Sended your message");
                    } else {
                        debug_wpmail($send_mail);
                        wp_send_json_error("Couldn't send this message");
                    }

                } else {
                    wp_send_json_error("Couldn't send this message");
                }
            }

            $to = $return_data['recipment-email'];


            $subject = 'Wiadomość z formularza dhlexpress.pl';
            if ($return_data['tracking-number']) {

                $body = "Temat: " . $return_data['subject_recipient'] . "<br/>Imie i nazwisko: " . $return_data['name'] . " " . $return_data['surname'] . " <br/> Email: " . $return_data['email'] . " <br/> Numer telefonu: " . $return_data['phone'] . " <br/> Numer przesylki:" . $return_data['tracking-number'] . "<br/>";

            } else {
                $body = "Temat: " . $return_data['subject_recipient'] . "<br/>Imie i nazwisko: " . $return_data['name'] . " " . $return_data['surname'] . " <br/> Email: " . $return_data['email'] . " <br/> Numer telefonu: " . $return_data['phone'] . "<br/>";
            }
            if ($return_data['message']) {
                $body .= "Wiadomość:" . $return_data['message'];
            }

            $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Formularz <kontakt@dhlexpress.pl>', 'Reply-To: <' . $to . '>');
            //$headers = array('Content-Type: text/html; charset=UTF-8');


            if (!function_exists('debug_wpmail')) :
                function debug_wpmail($result = false)
                {
                    if ($result)
                        return;
                    global $ts_mail_errors, $phpmailer;
                    if (!isset($ts_mail_errors))
                        $ts_mail_errors = array();
                    if (isset($phpmailer))
                        $ts_mail_errors[] = $phpmailer->ErrorInfo;
                    print_r('<pre>');
                    print_r($ts_mail_errors);
                    print_r('</pre>');
                }
            endif;
            $send_mail = wp_mail($to, $subject, $body, $headers);
            //  wp_send_json_success($send_mail);
            if ($send_mail) {
                // var_dump($send_mail);
                wp_send_json_success("Sended your message");
            } else {
                debug_wpmail($send_mail);
                wp_send_json_error("Couldn't send this message");
            }
        }
    }
}


add_action('wp_ajax_partner_form', 'partner_form'); //
add_action('wp_ajax_nopriv_partner_form', 'partner_form');

function partner_form()
{
    $data = esc_sql(maybe_unserialize($_POST));
    $return_data = [];
    $return_error = [];
    // $body_email = "";
    if (!$data) {
        wp_send_json_error("cant read post data");
    } else {
        foreach ($data as $key => $single_field) {
            if ($key !== 'profil' && ($single_field === NULL || $single_field === '')) {
                $return_error[$key] = 'error in this field';
            } else {
                $return_data[$key] = $single_field;
            }
        }
        if ($return_error) {
            wp_send_json_error($return_error);
        } else {
//            wp_send_json_success('evrything its ok');


            $to = get_field('our_partners_email', 'option');

            $subject = 'Wiadomość z formularza partner dhlexpress.pl';
            if ($return_data['profil']) {
                $body = "Nazwa firmy: " . $return_data['company'] .
                    "<br/>Ulica i numer budynku: " . $return_data['street'] .
                    "<br/>Kod pocztowy: " . $return_data['post_code'] .
                    "<br/>Miasto: " . $return_data['city'] .
                    "<br/>Witryna widoczna z ulicy: " . $return_data['shopwindow'] .
                    "<br/>Imię i nazwisko: " . $return_data['name'] .
                    " <br/> Email: " . $return_data['email'] .
                    " <br/> Numer telefonu: " . $return_data['phone'] .
                    " <br/> Profil działalności:" . $return_data['profil'] . "<br/>";

            } else {
                $body = "Nazwa firmy: " . $return_data['company'] .
                    "<br/>Ulica i numer budynku: " . $return_data['street'] .
                    "<br/>Kod pocztowy: " . $return_data['post_code'] .
                    "<br/>Miasto: " . $return_data['city'] .
                    "<br/>Witryna widoczna z ulicy: " . $return_data['shopwindow'] .
                    "<br/>Imię i nazwisko: " . $return_data['name'] .
                    " <br/> Email: " . $return_data['email'] .
                    "<br/> Numer telefonu: " . $return_data['phone'] . "<br/>";
            }
            $headers = array('Content-Type: text/html; charset=UTF-8', 'From: Formularz <kontakt@dhlexpress.pl>', 'Reply-To: <' . $to . '>');

            $send_mail = wp_mail($to, $subject, $body, $headers);
            if ($send_mail) {
                wp_send_json_success("Sended your message");
            } else {
                debug_wpmail($send_mail);
                wp_send_json_error("Couldn't send this message");
            }
        }
    }
}