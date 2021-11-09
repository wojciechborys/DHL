<?php
namespace SD\Template\Gallery;

/**
 * Modyfikuje domyślne ustawienia galerii.
 *
 * @param  array   $settings Ustawienia.
 * @param  WP_Post $post     Obiekt wpisu.
 * @return array
 */
function themeGalleryDefaults($settings, $post) {
    if (empty($settings['galleryDefaults'])) {
        $settings['galleryDefaults'] = [];
    }

    $settings['galleryDefaults'] = \array_merge($settings['galleryDefaults'], [
        'columns' => 2,
        'link'    => 'file',
        'size'    => 'gallery-image',
    ]);

    return $settings;
}
\add_filter('media_view_settings', __NAMESPACE__ . '\\themeGalleryDefaults', 10, 2);

/**
 * Modyfikuje wynik działania shortcode'u galerii.
 *
 * @param  string $output   Wynik wcześniejszego działania.
 * @param  array  $atts     Atrybuty shortcode'u.
 * @param  int    $instance Numer instancji galerii.
 * @return string
 */
function postGallery($output, $atts, $instance) {
    if (!empty($output)) {
        return $output;
    }

    $gallery = '';

    $args = [
        'post_status'    => 'inherit',
        'post_type'      => 'attachment',
        'post_mime_type' => 'image',
        'order'          => empty($atts['order']) ? 'ASC' : $atts['order'],
        'orderby'        => empty($atts['orderby']) ? 'menu_order ID' : $atts['orderby']
    ];

    if (!empty($atts['include'])) {
        $args['include'] = $atts['include'];

        $attachments = \get_posts($args);
    } else {
        $post = \get_post();

        $args['post_parent'] = $post instanceof \WP_Post ? $post->ID : 0;

        if (!empty($atts['exclude'])) {
            $args['exclude'] = $atts['exclude'];
        }

        $attachments = \get_children($args);
    }

    if (empty($attachments)) {
        return $output;
    }

    $columns = empty($atts['columns']) ? 2 : (int) $atts['columns'];

    foreach ($attachments as $attachment) {
        $gallery .= postGalleryItemHtml($attachment, $atts['size'], $columns, [
            'class' => 'img-fluid'
        ]);
    }

    if (!empty($gallery)) {
        $wrapperClass = \is_single() ? 'single-post-gallery' : 'post-gallery';
        $output = '<div class="row '.$wrapperClass.'">'.$gallery.'</div>';
    }

	return $output;
}
\add_filter('post_gallery', __NAMESPACE__ . '\\postGallery', 5, 3);

/**
 * Tworzy kod HTML pojedynczego elementu galerii.
 *
 * @param  int|WP_Post  $attachment      Identyfikator obrazu
 * @param  string       $size            Rozmiar obrazu w galerii.
 * @param  int          $columns         Liczba kolumn w galerii.
 * @param  string|array $columns         Liczba kolumn w galerii.
 * @param  string|array $attachment_atts Atrybuty obrazu.
 * @return string
 */
function postGalleryItemHtml($attachment, $size, $columns, array $attachment_atts = []) {
    $html = '';

    $columns = (int) $columns;

    if ($columns === 5 || ($columns >= 7 && $columns < 12)) {
        $col = 2;
    } elseif ($columns > 12) {
        $col = 1;
    } elseif ($columns < 1) {
        $col = 12;
    } else {
        $col = 12 / $columns;
    }

    if (!$attachment instanceof \WP_Post) {
        $attachment = \get_post($attachment);
    }

    if (!$attachment instanceof \WP_post) {
        return '';
    }

    $image = wp_get_attachment_image($attachment->ID, $size, false, $attachment_atts);

    if ($image) {
        $block = \is_single() ? 'single-post-gallery' : 'post-gallery';

        $src = wp_get_attachment_image_src($attachment->ID, 'full');

        $image = '<a href="'.\esc_url($src[0]).'" class="'.$block.'__link">'.$image.'</a>';

        $html = '<div class="col-12 col-md-6 col-lg-'.$col.' '.$block.'__item">'.
                    '<div class="'.$block.'__inner">'.
                        $image.
                    '</div>'.
                '</div>';
    }

    return $html;
}
