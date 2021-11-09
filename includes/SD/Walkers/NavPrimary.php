<?php
namespace SD\Walkers;

class NavPrimary extends \Walker_Nav_Menu {

    protected $didForm;
    protected $didSignin;

    /**
     * Konstruktor.
     */
    public function __construct() {
        $this->didForm = $this->didSignin = false;

        \add_filter('wp_nav_menu_items', [$this, 'append_search_form']);
        \add_filter('wp_nav_menu_items', [$this, 'append_signin']);
    }

    /**
     * Kopia metody Walker_Nav_Menu::start_el() z kilkoma usprawnieniami.
     *
     * @since 3.0.0
     * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
     *
     * @see Walker::start_el()
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param WP_Post  $item   Menu item data object.
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     * @param int      $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0) {
    	if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
    		$t = '';
    		$n = '';
    	} else {
    		$t = "\t";
    		$n = "\n";
    	}

    	$indent = $depth ? \str_repeat($t, $depth) : '';

    	$classes = empty($item->classes) ? [] : (array) $item->classes;
    	$classes[] = 'menu-item-' . $item->ID;
    	$classes[] = 'nav-primary__item';

        if (\in_array('current-menu-item', $classes)) {
            $classes[] = 'nav-primary__item--current';
        }

    	/**
    	 * Filters the arguments for a single nav menu item.
    	 *
    	 * @since 4.4.0
    	 *
    	 * @param stdClass $args  An object of wp_nav_menu() arguments.
    	 * @param WP_Post  $item  Menu item data object.
    	 * @param int      $depth Depth of menu item. Used for padding.
    	 */
    	$args = \apply_filters('nav_menu_item_args', $args, $item, $depth);

    	/**
    	 * Filters the CSS class(es) applied to a menu item's list item element.
    	 *
    	 * @since 3.0.0
    	 * @since 4.1.0 The `$depth` parameter was added.
    	 *
    	 * @param array    $classes The CSS classes that are applied to the menu item's `<li>` element.
    	 * @param WP_Post  $item    The current menu item.
    	 * @param stdClass $args    An object of wp_nav_menu() arguments.
    	 * @param int      $depth   Depth of menu item. Used for padding.
    	 */
    	$class_names = \join(' ', \apply_filters('nav_menu_css_class', \array_filter($classes), $item, $args, $depth));
    	$class_names = $class_names ? ' class="' . \esc_attr($class_names) . '"' : '';

    	/**
    	 * Filters the ID applied to a menu item's list item element.
    	 *
    	 * @since 3.0.1
    	 * @since 4.1.0 The `$depth` parameter was added.
    	 *
    	 * @param string   $menu_id The ID that is applied to the menu item's `<li>` element.
    	 * @param WP_Post  $item    The current menu item.
    	 * @param stdClass $args    An object of wp_nav_menu() arguments.
    	 * @param int      $depth   Depth of menu item. Used for padding.
    	 */
    	$id = \apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
    	$id = $id ? ' id="' . \esc_attr($id) . '"' : '';

    	$output .= $indent . '<li' . $id . $class_names .'>';

    	$atts = [];
    	$atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
    	$atts['target'] = !empty($item->target)     ? $item->target     : '';
        $atts['rel']    = !empty($item->xfn)        ? $item->xfn        : '';
    	$atts['href']   = !empty($item->url)        ? $item->url        : '';
        $atts['class']  = 'nav-primary__link';

		/**
    	 * Filters the HTML attributes applied to a menu item's anchor element.
    	 *
		 * @since 3.6.0
	     * @since 4.1.0 The `$depth` parameter was added.
		 *
    	 * @param array $atts {
	     *     The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
		 *
		 *     @type string $title  Title attribute.
		 *     @type string $target Target attribute.
		 *     @type string $rel    The rel attribute.
		 *     @type string $href   The href attribute.
		 * }
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$atts = \apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

		$attributes = '';

		foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr;
                $value = 'href' === $attr ? \esc_url($value) : \esc_attr($value);
                $attributes .= '="' . $value . '"';
			} elseif (empty($value) && 0 === \strpos($attr, 'data-')) {
                $attributes .= ' ' . $attr;
            }
		}

		/** This filter is documented in wp-includes/post-template.php */
		$title = \apply_filters('the_title', $item->title, $item->ID);

		/**
		 * Filters a menu item's title.
		 *
		 * @since 4.4.0
		 *
		 * @param string   $title The menu item's title.
		 * @param WP_Post  $item  The current menu item.
		 * @param stdClass $args  An object of wp_nav_menu() arguments.
		 * @param int      $depth Depth of menu item. Used for padding.
		 */
		$title = \apply_filters('nav_menu_item_title', $title, $item, $args, $depth);

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . $title . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $args->after;

		/**
		 * Filters a menu item's starting output.
		 *
		 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
		 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
		 * no filter for modifying the opening and closing `<li>` for a menu item.
		 *
		 * @since 3.0.0
		 *
		 * @param string   $item_output The menu item's starting HTML output.
		 * @param WP_Post  $item        Menu item data object.
		 * @param int      $depth       Depth of menu item. Used for padding.
		 * @param stdClass $args        An object of wp_nav_menu() arguments.
		 */
		$output .= \apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
	}

	/**
	 * Dodaje formularz wyszukiwania do menu.
	 *
	 * @param string $items HTML z elementami menu.
	 * @return string
	 */
	public function append_search_form($items) {
        if ($this->didForm) {
            return $items;
        }

        $this->didForm = true;

        return $items."\n".'<li class="nav-primary__item nav-primary__item--search" data-search-trigger>'."\n".
        '<a href="#nav-primary-search-form" class="nav-primary__link">Szukaj</a>'."\n".
        '<div class="nav-primary__form" id="nav-primary-search-form" data-search-form>'."\n".
        '<form class="form-inline" action="'.home_url().'">'."\n".
        '<input name="s" class="form-control-plaintext nav-primary__search-input" type="search" placeholder="Szukaj" aria-label="Szukaj">'."\n".
        '<button type="submit" class="nav-primary__search-btn">Szukaj</button>'."\n".
        '</form>'."\n".
        '</div>'."\n".
        '</li>';
	}

	/**
	 * Dodaje przycisk "Zapisz się" do menu.
	 *
	 * @param string $items HTML z elementami menu.
	 * @return string
	 */
	public function append_signin($items) {
        if ($this->didSignin) {
            return $items;
        }

        $this->didSignin = true;

        $url = is_search() ? \esc_url(\home_url('/')) : '';

        return $items."\n".'<li class="nav-primary__item nav-primary__item--signin">'."\n".
        '<a href="'.$url.'#lead-form" class="btn btn-primary nav-primary__signin-btn" data-btn-signin>Zapisz się</a>'."\n".
        '</li>';
	}

}
