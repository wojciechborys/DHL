<?php
namespace MintMedia\PolylangT9n\Polylang;

define('MM_POLYLANG_ACTIVE', \function_exists('pll_register_string'));

function init () {
    if (MM_POLYLANG_ACTIVE) {
        $t_dir = __DIR__ . DIRECTORY_SEPARATOR . 'translations' . DIRECTORY_SEPARATOR;

        $t_names = ['content-intro', 'contact-form', 'content-calc', 'shipment-options', 'numbers-section', 'files', 'disclaimer', 'footer', 'cookie-consent', 'countries'];

        foreach ($t_names as $t_name) {
            include_once "{$t_dir}{$t_name}.php";
        }
    }
}
\add_action('init', __NAMESPACE__ . '\\init');

function t9n ($string) {
    if (MM_POLYLANG_ACTIVE) {
        return \pll__($string);
    }

    return $string;
}

function t9n_attr ($string) {
    return esc_attr(t9n($string));
}
