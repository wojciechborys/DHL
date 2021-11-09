<?php
namespace MintMedia\Dhl\Ajax;

function contact_mailed () {
    $html = \MintMedia\Dhl\Templates\contact_form_thanks();
    \wp_send_json_success(['html' => $html]);
}
add_action('wp_ajax_contact-mailed', __NAMESPACE__ . '\\contact_mailed');
add_action('wp_ajax_nopriv_contact-mailed', __NAMESPACE__ . '\\contact_mailed');
