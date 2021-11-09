<?php
namespace SD\Template\Tags;

use SD\Options\OptionsHelper;
use SD\Restricted;

/**
 * Zwraca pojedynczy tag wpisu.
 *
 * @param null|int|WP_Post $post
 * @return WP_Term|null
 */
function getMainTag($post = null) {
    $post = \get_post($post);

    if (!$post instanceof \WP_Post || 'post' !== $post->post_type) {
        return null;
    }

    $tags = wp_get_post_terms($post->ID, 'post_tag', [
        'order'   => 'DESC',
        'orderby' => 'count',
    ]);

    if (empty($tags) || $tags instanceof \WP_Error) {
        return null;
    }

    return \reset($tags);
}

/**
 * Zwraca podtytuł wpisu.
 *
 * @param null|int|WP_Post $post
 * @return string
 */
function getSubtitle($post = null) {
    if (null === $post) {
        $post = \get_post();
    }

    if ($post instanceof \WP_Post) {
        $postID = $post->ID;
    } else {
        $postID = (int) $post;
    }

    $subtitle = \get_post_meta($postID, '_subtitle', true);

    return (string) $subtitle;
}

/**
 * Zwraca identyfikator obrazu do wyświetlenia na górze wpisu.
 *
 * @param null|int|WP_Post $post
 * @return int|false
 */
function getTopImageID($post = null) {
    if (null === $post) {
        $post = \get_post();
    }

    if ($post instanceof \WP_Post) {
        $postID = $post->ID;
    } else {
        $postID = (int) $post;
    }

    $imageID = \get_post_meta($postID, '_top_image_id', true);

    return $imageID ? (int) $imageID : false;
}

/**
 * Zwraca permalink wpisu
 *
 * @param null|int|WP_Post $post
 * @return string|false
 */
function getPermalink($post = null) {
    $permalink = \get_permalink($post);
    return $permalink ? $permalink : false;
}
/**
 * Zwraca źródło obrazu do wyświetlenia na górze wpisu.
 *
 * @param null|int|WP_Post $post
 * @param string           $size
 * @return string|false
 */
function getTopImageSrc($post = null, $size = 'top-post-image') {
    $imageID = getTopImageID($post);

    if (!$imageID) {
        return false;
    }

    $src = \wp_get_attachment_image_src($imageID, $size);

    if ($src) {
        return $src[0];
    }

    return false;
}

/**
 * Zwraca źródło miniatury wpisu.
 *
 * @param null|int|WP_Post $post
 * @param string           $size
 * @return string|false
 */
function getPostThumbnailSrc($post = null, $size = 'full') {
    $imageID = \get_post_thumbnail_id($post);

    if (!$imageID) {
        return false;
    }

    $src = \wp_get_attachment_image_src($imageID, $size);

    if ($src) {
        return $src[0];
    }

    return false;
}

/**
 * Zwraca źródło miniatury wpisu, uwzględniając obrazek do wyświetlania nad wpisem.
 *
 * @param null|int|WP_Post $post
 * @param string           $size
 * @return string|false
 */
function getFeaturedImageSrc($post = null, $size = 'small-slide') {
    $src = getPostThumbnailSrc($post, $size);

    if ($src) {
        return $src;
    }

    return getTopImageSrc($post, $size);
}

/**
 * Wyświetla treść wpisu lub jego fragment, jeśli użytkownik nie ma dostępu do tekstu.
 *
 * @param WP_Post|int|null $post
 * @return void
 */
function theContent($post = null) {
    $post = \get_post($post);

    if (!$post instanceof \WP_Post) {
        return;
    }

    if (Restricted\canView()) {
        $content = $post->post_content;
        $content = \apply_filters('the_content', $content);
        $content = \str_replace(']]>', ']]&gt;', $content);
    } else {
        $excerpt = \trim($post->post_excerpt);

        if ($excerpt) {
            $content = $excerpt;
        } else {
            $content = \wp_strip_all_tags($post->post_content);
            $content = \strip_shortcodes($content);
            $content = \wp_trim_words($content, 40, '&hellip;');
        }

        $content .= "\n".'<div class="alert alert-secondary"><a href="#lead-form" data-btn-signin=>Zapisz się</a>, aby odblokować dalszą treść artykułu.</div>';
    }

    echo \wpautop($content);
}


/**
 * Wyświetla zawartość sekcji o firmie.
 *
 * @return void
 */
function aboutContent () {

    $pageOnFront = (int) \get_option('page_on_front');

    if (!$pageOnFront) {
        return;
    }

    $content = \get_post_field('post_content', $pageOnFront, $context = 'display');
    $content = formatContent($content);

    echo $content;
}

/**
 * Zwraca informację o tym, czy wpis jest polecany
 *
 * @param null|int|WP_Post $post
 * @return bool|null
 */
function isRecommended($post = null) {
    $post = \get_post($post);

    if (!$post instanceof \WP_Post) {
        return null;
    }

    return (bool) get_post_meta($post->ID, '_recommended', true);
}

/**
 * Wyświetla komunikat o ciasteczkach.
 *
 * @return void
 */
function cookieConsentWorld () {
    include \get_stylesheet_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'world'.DIRECTORY_SEPARATOR.'_cookie-consent.php';
}

/**
 * Formatuje tekst do wyświetlenia (przepuszcza przez filtry powiązane z
 * funkcją the_content()).
 *
 * @param string $content
 * @param bool   $wpautop
 * @return string
 */
function formatContent($content, $wpautop = true) {

    $content = \apply_filters('the_content', $content);
    $content = \str_replace(']]>', ']]&gt;', $content);

    if ($wpautop) {
        $content = \wpautop($content);
    }

    return $content;
}

/**
 * Wyświetla tytuł własnej zawartości na stronie głównej.
 *
 * @param bool $echo
 * @return void
 */
function customContentTitle($echo = true) {
    $title = OptionsHelper::option('custom_content::title');

    if (!$echo) {
        return $title;
    }

    echo $title;
}


/**
 * Wyświetla własną zawartość na stronie głównej.
 *
 * @param bool $echo
 * @return void
 */
function customContent($echo = true) {

    $content = OptionsHelper::option('custom_content::content');
    $content = \apply_filters('the_content', $content);
    $content = \str_replace(']]>', ']]&gt;', $content);

    if (!$echo) {
        return $content;
    }

    echo $content;
}

/**
 * Wstawia formularz newslettera.
 *
 * @param bool $inSidebar
 * @return void
 */
function newsletterForm($inSidebar = false) {
    require DHLECM_ROOT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'world'.DIRECTORY_SEPARATOR.'newsletter-form.php';
}

/**
 * Wstawia formularz newslettera.
 *
 * @param bool $inSidebar
 * @return void
 */
function newsletterHomeForm($inSidebar = false) {
    require DHLECM_ROOT.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'newsletter-home-form.php';
}

/**
 * Zwraca kod HTML iFrame'a z wideo.
 *
 * @param int $which
 * @return string
 */
function videoIframe($which) {

    $videos = OptionsHelper::option("videos::videos");

    if (!isset($videos[$which]) || !\is_array($videos[$which])) {
        return '';
    }

    $url = isset($videos[$which]['url']) ? $videos[$which]['url'] : false;

    if (!$url) {
        return '';
    }

    $result = \wp_oembed_get($url);

    if ($result === $url) {
        return '';
    }

    $result = \str_replace('<iframe', '<iframe id="video'.$which.'" data-yt-video', $result);

    return $result;
}

/**
 * Zwraca źródło miniatury wideo.
 *
 * @param int $which
 * @return string
 */
function videoThumbnailSrc ($which) {

    $videos = OptionsHelper::option("videos::videos");

    if (!isset($videos[$which]) || !\is_array($videos[$which])) {
        return '';
    }

    $value = !empty($videos[$which]['image_id']) ? (int) $videos[$which]['image_id'] : false;
    $src = false;

    if ($value) {
        $src = \wp_get_attachment_image_src($value, 'video-thumbnail');
        $src = $src ? $src[0] : false;
    }

    if ($src) {
        return $src;
    }

    $value = !empty($videos[$which]['image']) ? $videos[$which]['image'] : '';
    return $value;
}

/**
 * Wyświetla zajawkę.
 *
 * @param WP_Post|int|null $post
 * @param string           $more
 * @param int              $words
 * @return string
 */
function theExcerpt($post = null, $more = '&hellip;', $words = 20) {

    $post = get_post($post);

    if (!$post instanceof \WP_Post) {
        return '';
    }

    $content = \wp_strip_all_tags($post->post_content);
    $content = \strip_shortcodes($content);
    echo \wp_trim_words($content, $words, $more);
}

/**
 * Wyświetla powiązane artykuły.
 *
 * @return void
 */
function relatedArticles () {

    global $post;

    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
    ];

    if (\is_single()) {
        $args['post__not_in'] = [\get_queried_object_id()];
    }

    $query = new \WP_Query($args);

    if ($query->have_posts()) :

        include \get_stylesheet_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'career'.DIRECTORY_SEPARATOR.'_related-articles.php';

        \wp_reset_postdata();

    endif;
}

/**
 * Wyświetla powiązane artykuły.
 *
 * @return void
 */
function relatedArticlesCareer () {

    global $post;

    $args = [
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'category__not_in' => [1, 31],
        'posts_per_page' => 3,
    ];

    if (\is_single()) {
        $args['post__not_in'] = [\get_queried_object_id()];
    }

    $query = new \WP_Query($args);

    if ($query->have_posts()) :

        include \get_stylesheet_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'career'.DIRECTORY_SEPARATOR.'_related-articles.php';

        \wp_reset_postdata();

    endif;
}


/**
 * Wyświetla sekcję intro.
 *
 * @return void
 */
function introSection () {

    if (\is_archive('offercategory')) {
        return;
    }

    include \get_stylesheet_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'career'.DIRECTORY_SEPARATOR.'_intro.php';
}


/**
 * Wyświetla sekcję z nagrodami.
 *
 * @return void
 */
function prizesSection () {
    include \get_stylesheet_directory().DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'career'.DIRECTORY_SEPARATOR.'_prizes.php';
}