<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use Roots\Sage\Setup;
use MintMedia\ShipmentCalc\Helpers;
use MintMedia\PolylangT9n\Polylang;
use MintMedia\Dhl\Experiments;


/**
 * Theme assets
 */
function assets() {
    global $wp_query;
    wp_enqueue_style('sage/css', Assets\asset_path('main.css', 'asset-sources/dhlknowledge/dist'), false, null);

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    $ajax_url = \admin_url( 'admin-ajax.php' );

    wp_enqueue_script('sage/js', Assets\asset_path('main.js', 'asset-sources/dhlknowledge/dist'), ['jquery'], null, true);
    wp_localize_script('sage/js', 'dhlConfig', ['ajaxUrl' => \admin_url('admin-ajax.php')]);
    wp_localize_script('sage/js', 'contactUs', [
        'ajax_url' => \admin_url('admin-ajax.php'),
        'home_url' => \home_url('/'),
        'isFrontPage' => is_front_page(),
    ]);
    wp_localize_script( 'sage/js', 'sd_config', array(
        'ajax_url' => $ajax_url,
        'first_page' => get_pagenum_link(1),
        'query_vars' => json_encode( $wp_query->query ),
        'posts' => json_encode( $wp_query->query_vars ), // everything about your loop is here
        'current_page' => get_query_var( 'paged' ) ? get_query_var('paged') : 1,
        'max_page' => $wp_query->max_num_pages,
        'newsletter_error_default'  => Polylang\t9n('Coś poszło nie tak.'),
        'newsletter_error_email' => Polylang\t9n('Niepoprawny adres email.'),
        'newsletter_error_terms'  => Polylang\t9n('Zgoda jest wymagana.')
    ));


  /* \wp_localize_script('sage/js', 'MmConfig', [
        'ajax_url' => \admin_url('admin-ajax.php'),
        'home_url' => \home_url('/'),
        'isFrontPage' => is_front_page(),
    ]);

    \wp_enqueue_script(
        'sage/js',
        Assets\asset_path('scripts/front.js', 'asset-sources/dhlexpress/dist'),
        ['mm/js', 'jquery-ui-autocomplete'],
        null,
        true
    );*/

    $options = Helpers\OptionsHelper::get_instance();

    $info = \sprintf(
        Polylang\t9n('Odwiedź <a href="%1$s" target="_blank" onclick="ga(\'send\', \'event\', \'MyDHL+\', \'MyDHL+\', \'MyDHL+\');">MyDHL+</a> w celu wyceny przesyłki.'),
        \esc_url(Polylang\t9n('https://mydhl.express.dhl/pl/pl/home.html#/createNewShipmentTab'))
    );
    $link = \sprintf(
        Polylang\t9n('<a href="%1$s" target="_blank" onclick="ga(\'send\', \'event\', \'MyDHL+\', \'MyDHL+\', \'MyDHL+\');">MyDHL+</a>'),
        \esc_url(Polylang\t9n('https://mydhl.express.dhl/pl/pl/home.html#/createNewShipmentTab'))
    );

    wp_localize_script('sage/js', 'DhlFrontConfig', [
            'calcValidation' => [
                'country' => [
                    'invalid' => Polylang\t9n('Podana wartość nie istnieje.'),
                    'empty' => Polylang\t9n('Wybierz kraj docelowy.')
                ],
                'weight' => [
                    'over' => \sprintf(
                        Polylang\t9n('Cięższą przesyłkę wyceń w ') . "{$link}",
                        $options->get_hidden('max_weight'),
                        $link
                    ),
                    'below' => \sprintf(
                        Polylang\t9n('Waga nie może być mniejsza niż %1$s kg.'),
                        $options->get_hidden('min_weight')
                    ),
                ],
                'length' => [
                    'over' => \sprintf(
                        Polylang\t9n('Większa przesyłkę wyceń w ') . "{$link}",
                        $options->get_hidden('max_length'),
                        $info
                    ),
                    'below' => \sprintf(
                        Polylang\t9n('Długość nie może być mniejsza niż %1$s cm.'),
                        $options->get_hidden('min_length')
                    ),
                ],
                'height' => [
                    'over' => \sprintf(
                        Polylang\t9n('Wysokość nie może być większa niż %1$s cm.') . " {$info}",
                        $options->get_hidden('max_height'),
                        $info
                    ),
                    'below' => \sprintf(
                        Polylang\t9n('Wysokość nie może być mniejsza niż %1$s cm.'),
                        $options->get_hidden('min_height')
                    ),
                ],
                'width' => [
                    'over' => \sprintf(
                        Polylang\t9n('Szerokość nie może być większa niż %1$s cm.') . " {$info}",
                        $options->get_hidden('max_width'),
                        $info
                    ),
                    'below' => \sprintf(
                        Polylang\t9n('Szerokość nie może być mniejsza niż %1$s cm.'),
                        $options->get_hidden('min_width')
                    ),
                ]
            ]
        ]);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);