<?php

namespace Roots\Sage\Titles;

/**
 * Page titles
 */
function title() {
  if (is_home()) {
    if (get_option('page_for_posts', true)) {
      return get_the_title(get_option('page_for_posts', true));
    } else {
      return 'Ostatnie wpisy';
    }
  } elseif (is_archive()) {
    return get_the_archive_title();
  } elseif (is_search()) {
    return sprintf('Wyniki wyszukiwania dla frazy %s', get_search_query());
  } elseif (is_404()) {
    return '404';
  } else {
    return get_the_title();
  }
}


/// WORLD

/**
 * Page titles
 */
function title_world() {
    if (is_home()) {
        if (get_option('page_for_posts', true)) {
            return get_the_title(get_option('page_for_posts', true));
        } else {
            return 'Ostatnio dodane wpisy';
        }
    } elseif (is_archive()) {
        return get_the_archive_title();
    } elseif (is_search()) {
        return sprintf('Wyniki wyszukiwania dla frazy <span class="page-header__emphasis">%s</span>', get_search_query());
    } elseif (is_404()) {
        return '404 - nie znaleziono';
    } else {
        return get_the_title();
    }
}

/**
 * Zwraca klasy tytułu strony.
 *
 * @return string
 */
function header_class() {
    $classes = ['page-header'];

    if (is_archive()) {
        $classes[] = 'page-header--archive';
    } elseif (is_search()) {
        $classes[] = 'page-header--search';
    } elseif (is_404()) {
        $classes[] = 'page-header--404';
    } else {
        $classes[] = 'page-header--page';
    }

    return \implode(' ', $classes);
}

/// WORLD end