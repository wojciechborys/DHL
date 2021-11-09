<?php
namespace SD\Offers;

class Front {

    /**
     * Konstruktor.
     */
    public function __construct() {
        \add_action('init', array($this, 'init'));
        \add_action('pre_get_posts', array($this, 'excludeOutdated'));
    }

    public function init() {

        $labels = array(
            'name' => __('Oferty', 'mm-theme'),
            'singular_name' => __('Oferta', 'mm-theme'),
            'add_new' => __('Dodaj ofertę', 'mm-theme'),
            'all_items' => __('Wszystkie oferty', 'mm-theme'),
            'add_new_item' => __('Dodaj slide', 'mm-theme'),
            'edit_item' => __('Edytuj ofertę', 'mm-theme'),
            'new_item' => __('Nowa oferta', 'mm-theme'),
            'view_item' => __('Zobacz ofertę', 'mm-theme'),
            'search_item' => __('Szukaj oferty', 'mm-theme'),
            'not_found' => __('Nie znaleziono ofert', 'mm-theme'),
            'not_found_in_trash' => __('Brak ofert w koszu', 'mm-theme'),
            'parent_item_colon' => __('Parent Item', 'mm-theme')
        );
        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => false,
            'publicly_queryable' => false,
            'query_var' => false,
            'rewrite' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                //            'excerpt',
                //            'thumbnail',
                'revisions',
            ),
            'menu_position' => 5,
            'exclude_from_search' => false
        );
        register_post_type('offer', $args);

        $labels_countries = array(
            'name' => __('Lotniska', 'dhl'),
            'singular_name' => __('Lotniska', 'dhl'),
            'add_new' => __('Dodaj lotnisko', 'dhl'),
            'all_items' => __('Wszystkie Lotniska', 'dhl'),
            'add_new_item' => __('Dodaj lotnisko', 'dhl'),
            'edit_item' => __('Edytuj lotnisko', 'dhl'),
            'new_item' => __('Nowe lotnisko', 'dhl'),
            'view_item' => __('Zobacz lotnisko', 'dhl'),
            'search_item' => __('Szukaj Lotniska', 'dhl'),
            'not_found' => __('Nie znaleziono latnisk', 'dhl'),
            'not_found_in_trash' => __('Brak państw w koszu', 'dhl'),
            'parent_item_colon' => __('Parent Item', 'dhl')
        );
        $args_countries = array(
            'labels' => $labels_countries,
            'public' => true,
            'has_archive' => false,
            'publicly_queryable' => false,
            'query_var' => false,
            'rewrite' => false,
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                //            'excerpt',
                //            'thumbnail',
                'revisions',
            ),
            'menu_position' => 6,
            'exclude_from_search' => false
        );
        register_post_type('airports', $args_countries);

        $args = array(
            'label'        => __( 'Kategorie', 'mm-theme' ),
            'public'       => true,
            'rewrite'      => false,
            'hierarchical' => true
        );
        register_taxonomy( 'offercategory', 'offer', $args );



        $labels_knowledge = array(
            'name' => __('Baza wiedzy', 'dhl'),
            'singular_name' => __('Baza wiedzy', 'dhl'),
            'add_new' => __('Dodaj Bazę wiedzy', 'dhl'),
            'all_items' => __('Wszystkie posty', 'dhl'),
            'add_new_item' => __('Dodaj Bazę wiedzy', 'dhl'),
            'edit_item' => __('Edytuj Bazę wiedzy', 'dhl'),
            'new_item' => __('Nowa Baza wiedzy', 'dhl'),
            'view_item' => __('Zobacz Bazę wiedzy', 'dhl'),
            'search_item' => __('Szukaj Bazę wiedzy', 'dhl'),
            'not_found' => __('Nie znaleziono Bazy wiedzy', 'dhl'),
            'parent_item_colon' => __('Parent Item', 'dhl')
        );

        $args_knowledge = array(
            'labels' => $labels_knowledge,
            'public' => true,
            'has_archive' => false,
            'query_var' => false,
            'rewrite' => array('slug' => __('baza-wiedzy'), 'with_front' => false),
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'excerpt',
                'thumbnail',
                'page-attributes',
                'revisions',
            ),
            'menu_position' => 7,
            'exclude_from_search' => false
        );
        register_post_type('knowledge', $args_knowledge);


        $args = array(
            'label'        => __( 'Kategorie', 'mm-theme' ),
            'public'       => true,
            'hierarchical' => true,
            'rewrite' => array('slug' => __('bazawiedzy'), 'with_front' => true),
            'show_ui' => true,
            'has_archive' => true,
            'show_admin_column' => true,
            'query_var'         => true,
        );
        register_taxonomy( 'knowledge_category', 'knowledge', $args );


        $labels_press_release = array(
            'name' => __('Informacje prasowe', 'dhl'),
            'singular_name' => __('Informacja prasowa', 'dhl'),
            'add_new' => __('Dodaj Informację prasową', 'dhl'),
            'all_items' => __('Wszystkie posty', 'dhl'),
            'add_new_item' => __('Dodaj Informację prasową', 'dhl'),
            'edit_item' => __('Edytuj Informację prasową', 'dhl'),
            'new_item' => __('Nowa Informacja prasowa', 'dhl'),
            'view_item' => __('Zobacz Informację prasową', 'dhl'),
            'search_item' => __('Szukaj Informację prasową', 'dhl'),
            'not_found' => __('Nie znaleziono Informacji prasowej', 'dhl'),
            'parent_item_colon' => __('Parent Item', 'dhl')
        );

        $args_press_release = array(
            'labels' => $labels_press_release,
            'public' => true,
            'has_archive' => false,
            'query_var' => false,
            'rewrite' => array('slug' => __('press-release'), 'with_front' => false),
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'excerpt',
                'thumbnail',
                'page-attributes',
                'revisions',
            ),
            'menu_position' => 8,
            'exclude_from_search' => false
        );
        register_post_type('pressrelease', $args_press_release);

        $labels_media = array(
            'name' => __('Media o nas', 'dhl'),
            'singular_name' => __('Media o nas', 'dhl'),
            'add_new' => __('Dodaj post', 'dhl'),
            'all_items' => __('Wszystkie posty', 'dhl'),
            'add_new_item' => __('Dodaj post', 'dhl'),
            'edit_item' => __('Edytuj post', 'dhl'),
            'new_item' => __('Nowy post', 'dhl'),
            'view_item' => __('Zobacz Media o nas', 'dhl'),
            'search_item' => __('Szukaj', 'dhl'),
            'not_found' => __('Nie znaleziono', 'dhl'),
            'parent_item_colon' => __('Parent Item', 'dhl')
        );

        $args_media = array(
            'labels' => $labels_media,
            'public' => true,
            'has_archive' => false,
            'query_var' => false,
            'rewrite' => array('slug' => __('media-about-us'), 'with_front' => false),
            'capability_type' => 'post',
            'hierarchical' => false,
            'supports' => array(
                'title',
                'editor',
                'custom-fields',
                'excerpt',
                'thumbnail',
                'page-attributes',
                'revisions',
            ),
            'menu_position' => 7,
            'exclude_from_search' => false
        );
        register_post_type('mediaabout', $args_media);

    }

    public function excludeOutdated($query) {
        if (!is_admin() && $query->post_type === 'offer') {
            $metaQuery = [
                'relation' => 'OR',
                [
                    'key'     => '_sd_erecruiter_expiry_date',
                    'value'   => \current_time('Y-m-d'),
                    'compare' => '>',
                    'type'    => 'DATE',
                ],
                [
                    'key'     => '_sd_erecruiter_expiry_date',
                    'compare' => 'NOT EXISTS',
                ],
            ];

            $query->set('meta_query', $metaQuery);
        }
    }

}
