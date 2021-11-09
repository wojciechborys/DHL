<?php

namespace Roots\Sage\Setup;

use Roots\Sage\Assets;
use MintMedia\ShipmentCalc\Helpers;
use MintMedia\PolylangT9n\Polylang;
use MintMedia\Dhl\Experiments;

/**
 * Theme assets
 */
function assets()
{
    # css
    \wp_enqueue_style(
        'mm/css',
        Assets\asset_path('styles/main.css', 'asset-sources/dhlexpress/dist'),
        false,
        null
    );

    # js
    \wp_enqueue_script('mm/js', Assets\asset_path('scripts/main.js', 'asset-sources/dhlexpress/dist'), ['jquery'],
        null,
        true
    );

    \wp_enqueue_script('contact/js', Assets\asset_path('/main.js', 'asset-sources/dhl-new/dist'), ['jquery'],
        null,
        true
    );

    wp_enqueue_script('jquery-mask-plugin', Assets\asset_path('scripts/jquery-mask-plugin.js', 'asset-sources/dhlexpress/dist'), ['jquery'], null, true);

    $options = Helpers\OptionsHelper::get_instance();

    \wp_localize_script('mm/js', 'MmConfig', [
        'ajax_url' => \admin_url('admin-ajax.php'),
        'home_url' => \home_url('/'),
        'isFrontPage' => is_front_page(),
    ]);

    \wp_localize_script('contact/js', 'contactUs', [
        'ajax_url' => \admin_url('admin-ajax.php'),
        'home_url' => \home_url('/'),
        'isFrontPage' => is_front_page(),
    ]);


    if (\is_front_page()) {
        \wp_enqueue_script(
            'mm/js/front',
            Assets\asset_path('scripts/front.js', 'asset-sources/dhlexpress/dist'),
            ['mm/js', 'jquery-ui-autocomplete'],
            null,
            true
        );
        $info = \sprintf(
            Polylang\t9n('Odwiedź <a href="%1$s" target="_blank" onclick="ga(\'send\', \'event\', \'MyDHL+\', \'MyDHL+\', \'MyDHL+\');">MyDHL+</a> w celu wyceny przesyłki.'),
            \esc_url(Polylang\t9n('https://mydhl.express.dhl/pl/pl/home.html#/createNewShipmentTab'))
        );
        $link = \sprintf(
            Polylang\t9n('<a href="%1$s" target="_blank" onclick="ga(\'send\', \'event\', \'MyDHL+\', \'MyDHL+\', \'MyDHL+\');">MyDHL+</a>'),
            \esc_url(Polylang\t9n('https://mydhl.express.dhl/pl/pl/home.html#/createNewShipmentTab'))
        );
        \wp_localize_script('mm/js/front', 'DhlFrontConfig', [
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
}

\add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);

/**
 * Add <body> classes
 */
function body_class($classes)
{
    // Add page slug if it doesn't exist
    if (is_single() || is_page() && !is_front_page()) {
        if (!in_array(basename(get_permalink()), $classes)) {
            $classes[] = basename(get_permalink());
        }
    }

    $classes[] = 'doc-body';

    if (function_exists('pll_current_language')) {
        $lang = \strtolower(\pll_current_language());
        $classes[] = "doc-body--lang-{$lang}";
    }

    return $classes;
}

add_filter('body_class', __NAMESPACE__ . '\\body_class');
