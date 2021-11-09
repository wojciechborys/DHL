<?php
header('Access-Control-Allow-Origin: *');

define('DHLECM_ROOT', __DIR__);
define('DHL_THEME_DIR', __DIR__ . DIRECTORY_SEPARATOR);

/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */

$sage_includes = [
    'includes/CMB2/init.php',  // CMB2
    'includes/SD/load.php',    // SD
    'includes/SD/Dotmailer/dotmailer.php', // obsługa API dotmailera
    'includes/SD/Restricted/restricted.php', // obsługa API dotmailera
    'includes/SD/Options/load.php', // strona opcji ogólnych.
    'includes/autoload.php', // autoloader SD
    'includes/SD/Admin/load.php', // panele administracyjne
    'includes/SD/Template/load.php', // powiązane z wpisami /template tags/
    'lib/assets.php',    // Scripts and stylesheets
    'lib/extras.php',    // Custom functions
    'lib/common-setup.php',     // Theme setup
    'lib/titles.php',    // Page titles
    'lib/wrapper.php',   // Theme wrapper class
    'lib/customizer.php', // Theme customizer
];
foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);

require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Dhl' . DIRECTORY_SEPARATOR . 'Templates.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Dhl' . DIRECTORY_SEPARATOR . 'Tags.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Dhl' . DIRECTORY_SEPARATOR . 'Experiments.php';

if (defined('DOING_AJAX') && DOING_AJAX) {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Dhl' . DIRECTORY_SEPARATOR . 'Ajax.php';
}

require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'PolylangT9n' . DIRECTORY_SEPARATOR . 'Polylang.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'register_rest_route.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'contact.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'knowledge-filter-posts.php';

/**
 * Inicjalizuje motyw.
 *
 * @return void
 */
function dhl_init()
{
    add_image_size('fp-article', 560, 310, true);
    add_image_size('full-article', 970, 480, true);
    add_image_size('half-article', 475, 236, true);

    add_post_type_support('post', 'excerpt');
}

add_action('init', 'dhl_init');

/**
 * Dodaje nazwy rozmiarów obrazów.
 *
 * @return array
 */
function dhl_image_size_names($sizes)
{
    $sizes['full-article'] = 'Pełna szerokość artykułu';
    $sizes['half-article'] = 'Połowa szerokości artykułu';

    return $sizes;
}

add_filter('image_size_names_choose', 'dhl_image_size_names');

/**
 * Modyfikuje string dodawany na końcu wycinka treści wpisu.
 *
 * @return string
 */
function dhl_excerpt_more($more)
{
    return '&hellip;';
}

add_filter('excerpt_more', 'dhl_excerpt_more', 21);

/**
 * Zmienia długość wycinka treści.
 *
 * @param  int $length
 * @return int
 */
function dhl_excerpt_length($length)
{
    return 20;
}

add_filter('excerpt_length', 'dhl_excerpt_length', 999);

/**
 * Dodaje klasy HTML do edytora TinyMCE.
 *
 * @param  array $init_array
 * @return array
 */
function dhl_tiny_mce_classes($init_array)
{
    global $post;

    if ($post instanceof WP_Post && 'post' === $post->post_type) {
        if (array_key_exists('body_class', $init_array)) {
            $init_array['body_class'] .= ' single-article__content';
        } else {
            $init_array['body_class'] = 'single-article__content';
        }
    }

    return $init_array;
}

add_filter('tiny_mce_before_init', 'dhl_tiny_mce_classes');

if (function_exists('acf_add_options_page')) {

    acf_add_options_page('Ustawienia kalkulatora');
    acf_add_options_page('Ustawienia [Baza wiedzy]');
}

/**
 * Modyfikuje ścieżkę okruszków.
 *
 * @param  array $crumbs
 * @return array
 */
function dhl_wpseo_breadcrumb_links($crumbs)
{
    $last = end($crumbs);

    if (isset($last['id']) && is_single($last['id'])) {
        array_splice($crumbs, 1, 0, [
            [
                'text' => 'Artykuły',
                'url' => home_url('/')
            ]
        ]);
    }

    return $crumbs;
}

// add_filter('wpseo_breadcrumb_links', 'dhl_wpseo_breadcrumb_links');


function dhlNoReadMoreLink($more)
{
    if (is_home()) {
        return '';
    }

    return $more;
}

// add_filter('excerpt_more', 'dhlNoReadMoreLink');

/**
 * Show Polylang Languages with Custom Markup
 * @param  string $class Add custom class to the languages container
 * @return string
 */
function rarus_polylang_languages($class = '')
{
    if (!function_exists('pll_the_languages')) return;
    // Gets the pll_the_languages() raw code
    $languages = pll_the_languages(array(
        'display_names_as' => 'slug',
        'hide_if_no_translation' => 1,
        'raw' => true
    ));
    $output = '';
    // Checks if the $languages is not empty
    if (!empty($languages)) {
        // Creates the $output variable with languages container
        $output = '<div class="languages' . ($class ? ' ' . $class : '') . '">';
        // Runs the loop through all languages
        foreach ($languages as $language) {
            // Variables containing language data
            $id = $language['id'];
            $slug = $language['slug'];
            $url = $language['url'];
            $current = $language['current_lang'] ? ' languages__item--current' : '';
            $no_translation = $language['no_translation'];
            // Checks if the page has translation in this language
            if (!$no_translation) {
                // Check if it's current language
                if ($current) {
                    // Output the language in a <span> tag so it's not clickable
                    $output .= "<span class=\"languages__item$current\">$slug</span>";
                } else {
                    // Output the language in an anchor tag
                    $output .= "<a href=\"$url\" class=\"languages__item$current\">$slug</a>";
                }
            }
        }
        $output .= '</div>';
    }
    return $output;
}

new SD\Offers\Front();


//data list register to cf7

add_action('wpcf7_init', 'custom_add_form_tag_datalist');

function custom_add_form_tag_datalist()
{
    wpcf7_add_form_tag('datalist', 'custom_datalist_form_tag_handler', array('name-attr' => true));
}

function custom_datalist_form_tag_handler($tag)
{
    $atts = array(
        'type' => 'text',
        'name' => $tag->name,
        'list' => $tag->name . '-options',
    );

    $input = sprintf(
        '<input placeholder="Wpisz" %s />',
        wpcf7_format_atts($atts));

    $datalist = '';

    foreach ($tag->values as $val) {
        $datalist .= sprintf('<option>%s</option>', esc_html($val));
    }

    $datalist = sprintf(
        '<datalist id="%1$s">%2$s</datalist>',
        $tag->name . '-options',
        $datalist);

    return $input . $datalist;
}

//add attachment to response

add_action('wpcf7_before_send_mail', 'my_dynamic_attachments');
function my_dynamic_attachments($cf7)
{
    //check if it is the registration form
    if ($cf7->id == 1773) {
        // get the dropdown menu value and the corresponding file
        $filename = get_course_details_filepath($cf7->form['place']);
        $cf7->uploaded_files = array('directory' => $filename);
    }
}

/*
function mailtrap($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host = 'smtp.mailtrap.io';
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 2525;
    $phpmailer->Username = '7c74570f444a72';
    $phpmailer->Password = '51575f578bfdb9';

   // $phpmailer->Password = '51575f578bfd';
}

add_action('phpmailer_init', 'mailtrap'); */

function return_get_template_part($slug, $name=null) {

    ob_start();
    get_template_part($slug, $name);
    $content = ob_get_contents();
    ob_end_clean();

    return $content;
}

function filter_knowledge_by_taxonomies( $post_type, $which ) {

    // Apply this only on a specific post type
    if ( 'knowledge' !== $post_type )
        return;

    // A list of taxonomy slugs to filter by
    $taxonomies = array( 'knowledge_category' );

    foreach ( $taxonomies as $taxonomy_slug ) {

        // Retrieve taxonomy data
        $taxonomy_obj = get_taxonomy( $taxonomy_slug );
        $taxonomy_name = $taxonomy_obj->labels->name;

        // Retrieve taxonomy terms
        $terms = get_terms( $taxonomy_slug );

        // Display filter HTML
        echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
        echo '<option value="">' . sprintf( esc_html__( 'Show All %s', 'text_domain' ), $taxonomy_name ) . '</option>';
        foreach ( $terms as $term ) {
            printf(
                '<option value="%1$s" %2$s>%3$s (%4$s)</option>',
                $term->slug,
                ( ( isset( $_GET[$taxonomy_slug] ) && ( $_GET[$taxonomy_slug] == $term->slug ) ) ? ' selected="selected"' : '' ),
                $term->name,
                $term->count
            );
        }
        echo '</select>';
    }

}
add_action( 'restrict_manage_posts', 'filter_knowledge_by_taxonomies' , 10, 2);

use Roots\Sage\Assets;
function paginator( $first_page_url ){

    // the function works only with $wp_query that's why we must use query_posts() instead of WP_Query()
    global $wp_query;

    // remove the trailing slash if necessary
    $first_page_url = untrailingslashit( $first_page_url );


    // it is time to separate our URL from search query
    $first_page_url_exploded = array(); // set it to empty array
    $first_page_url_exploded = explode("/?", $first_page_url);
    // by default a search query is empty
    $search_query = '';
    // if the second array element exists
    if( isset( $first_page_url_exploded[1] ) ) {
        $search_query = "/?" . $first_page_url_exploded[1];
        $first_page_url = $first_page_url_exploded[0];
    }

    // get parameters from $wp_query object
    // how much posts to display per page (DO NOT SET CUSTOM VALUE HERE!!!)
    $posts_per_page = (int) $wp_query->query_vars['posts_per_page'];
    // current page
    $current_page = (int) $wp_query->query_vars['paged'];
    // the overall amount of pages
    $max_page = $wp_query->max_num_pages;

    // we don't have to display pagination or load more button in this case
    if( $max_page <= 1 ) return;

    // set the current page to 1 if not exists
    if( empty( $current_page ) || $current_page == 0) $current_page = 1;

    // you can play with this parameter - how much links to display in pagination
    $links_in_the_middle = 4;
    $links_in_the_middle_minus_1 = $links_in_the_middle-1;

    // the code below is required to display the pagination properly for large amount of pages
    // I mean 1 ... 10, 12, 13 .. 100
    // $first_link_in_the_middle is 10
    // $last_link_in_the_middle is 13
    $first_link_in_the_middle = $current_page - floor( $links_in_the_middle_minus_1/2 );
    $last_link_in_the_middle = $current_page + ceil( $links_in_the_middle_minus_1/2 );

    // some calculations with $first_link_in_the_middle and $last_link_in_the_middle
    if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;
    if( ( $last_link_in_the_middle - $first_link_in_the_middle ) != $links_in_the_middle_minus_1 ) { $last_link_in_the_middle = $first_link_in_the_middle + $links_in_the_middle_minus_1; }
    if( $last_link_in_the_middle > $max_page ) { $first_link_in_the_middle = $max_page - $links_in_the_middle_minus_1; $last_link_in_the_middle = (int) $max_page; }
    if( $first_link_in_the_middle <= 0 ) $first_link_in_the_middle = 1;

    // begin to generate HTML of the pagination
    $pagination = '<nav aria-label="Page navigation" style="width: 100%;"><ul class="pagination justify-content-center">';

    // when to display "..." and the first page before it
    if ($first_link_in_the_middle >= 3 && $links_in_the_middle < $max_page) {
        $pagination.= '<li class="page-item"><a href="'. $first_page_url . $search_query . '" class="page-numbers page-link">1</a></li>';

        if( $first_link_in_the_middle != 2 )
            $pagination .= '<li class="page-item"><span class="page-numbers page-link extend">...</span></li>';

    }

    // arrow left (previous page)
    if ($current_page != 1)
        $pagination.= '<li class="page-item"><a href="'. $first_page_url . '/page/' . ($current_page-1) . $search_query . '" class="prev page-link page-numbers" aria-label="Previous">' . ' <span aria-hidden="true">
			        	<img class="page-image" src="'. esc_url(Assets\asset_path('images/paginate_arrow.png', 'asset-sources/dhlknowledge/dist')).'" alt="<">
			        </span>' . '</a></li>';


    // loop page links in the middle between "..." and "..."
    for($i = $first_link_in_the_middle; $i <= $last_link_in_the_middle; $i++) {
        if($i == $current_page) {
            $pagination.= '<li class="page-item"><span class="page-numbers page-link current active">'.$i.'</span></li>';
        } else {
            $pagination .= '<li class="page-item"><a href="'. $first_page_url . '/page/' . $i . $search_query .'" class="page-numbers page-link">'.$i.'</a></li>';
        }
    }

    // arrow right (next page)
    if ($current_page != $last_link_in_the_middle )
        $pagination.= '<li class="page-item"><a href="'. $first_page_url . '/page/' . ($current_page+1) . $search_query .'" class="next page-link page-numbers" aria-label="Next">' . ' <span aria-hidden="true">
			        	<img class="page-image el__rotate" src="'. esc_url(Assets\asset_path('images/paginate_arrow.png', 'asset-sources/dhlknowledge/dist')) .'" alt="" />
			        </span>' . '</a></li>';


    // when to display "..." and the last page after it
    if ( $last_link_in_the_middle < $max_page ) {

        if( $last_link_in_the_middle != ($max_page-1) )
            $pagination .= '<li class="page-item"><span class="page-numbers page-link extend">...</span></li>';

        $pagination .= '<li class="page-item"><a href="'. $first_page_url . '/page/' . $max_page . $search_query .'" class="page-link page-numbers">'. $max_page .'</a></li>';
    }

    // end HTML
    $pagination.= "</ul></nav>\n";




    // replace first page before printing it
    return str_replace(array("/page/1?", "/page/1\""), array("?", "\""), $pagination);
}



function get_posts_by_tax( $tax = array(), $search = "", $offset = 0 ) {
    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'post_type' => 'knowledge',
        'tax_query' => array(
            array(
                'taxonomy' => 'knowledge_category',
                'field' => 'term_id',
                'terms' => $tax,
            ),
        ),
        'offset' => $offset,
        'orderby' => 'date',
        'order' => 'DESC',
        's' => $search
    );
    $posts = new WP_Query($args);
    return $posts;
}

add_filter( 'wp_mail', function( $mailArray ) {
    global $phpmailer;
    if ( ! ( $phpmailer instanceof PHPMailer ) ) {
        require_once ABSPATH . WPINC . '/class-phpmailer.php';
        require_once ABSPATH . WPINC . '/class-smtp.php';
        $phpmailer = new PHPMailer( true );
    }
    $phpmailer::$validator = 'php';

    return $mailArray;
} );