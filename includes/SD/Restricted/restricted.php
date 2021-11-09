<?php
namespace SD\Restricted;

if (!\session_id()) {
    \session_start();
}

/**
 * Nadaje użytkownikowi prawo dostępu do artykułów.
 *
 * @return void
 */
function grantAccess() {
    \setcookie('_restricted_area_access', 'granted', time()+(14 * DAY_IN_SECONDS), '/');
}

/**
 * Sprawdza, czy użytkownik ma prawo dostępu do zastrzeżonych artykułów.
 *
 * @return bool
 */
function hasAccess() {
    $access = isset($_COOKIE['_restricted_area_access']) ? $_COOKIE['_restricted_area_access'] : false;
    return 'granted' === $access;
}

/**
 * Informuje, czy wpis jest zablokowany przed dostępem.
 *
 * @param null|int|WP_Post $post
 * @return bool|null
 */
function isLocked($post = null) {
    $post = \get_post($post);

    if (!$post instanceof \WP_Post) {
        return null;
    }

    return (bool) get_post_meta($post->ID, '_locked', true);
}

/**
 * Informuje, czy użytkownik może obejrzeć wpis.
 *
 * @param null|int|WP_Post $post
 * @return bool|null
 */
function canView($post = null) {
    if (isLocked($post)) {
        return hasAccess();
    }

    return true;
}
