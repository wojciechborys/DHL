<?php
namespace MintMedia\Theme\CF7;

function add_form_tag () {
    \wpcf7_add_form_tag(
        ['text', 'text*', 'email', 'email*', 'url', 'url*', 'tel', 'tel*'],
        'wpcf7_text_form_tag_handler',
        ['name-attr' => true]
    );
}
\add_action('wpcf7_init', __NAMESPACE__ . '\\add_form_tag');
