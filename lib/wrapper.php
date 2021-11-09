<?php

namespace Roots\Sage\Wrapper;

/**
 * Theme wrapper
 *
 * @link https://roots.io/sage/docs/theme-wrapper/
 * @link http://scribu.net/wordpress/theme-wrappers.html
 */

function template_path()
{
    return SageWrapping::$main_template;
}

function world_sidebar_path()
{
    return new SageWrapping('templates/world/sidebar.php');
}

class SageWrapping
{
    const DEFAULT_THEME = 'default';
    const WORLD_THEME = 'world';
    const CAREER_THEME = 'career';
    const KNOWLEDGE_THEME = 'knowledge';
    const REUSABLE_THEME = 'reusable';
    const PRESSRELEASE_THEME = 'pressrelease';

    private static $sage_assets_includes = [
        'default' => 'lib/setup.php',     // Theme setup
        'world' => 'lib/world-setup.php',     // todo Theme setup
        'career' => 'lib/career-setup.php',     // todo Theme setup
        'knowledge' => 'lib/knowledge-setup.php',     // todo Theme setup
        'pressrelease' => 'lib/pressrelease-setup.php',     // todo Theme setup
        'reusable' => 'lib/reusable-setup.php',     // todo Theme setup
    ];

    // Stores the full path to the main template file
    public static $main_template;

    // Basename of template file
    public $slug;

    // Array of templates
    public $templates;

    // Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
    public static $base;

    public function __construct($template = 'base.php')
    {
        // edit here, if we have no base template loaded, load it in traditional way (eg. sidebar & stuff)
        // otherwise process assets first
        if (strpos($template, 'base') !== 0) {
            $this->loadTemplate($template);
        } else {
            if (strpos(self::$base, self::WORLD_THEME) !== false || self::$base === 'tag' || self::$base === 'search') {
                $this->loadWrapper($template, self::WORLD_THEME);
            } elseif (strpos(self::$base, self::CAREER_THEME) !== false || self::$base === 'taxonomy-offercategory') {
                $this->loadWrapper($template, self::CAREER_THEME);
            } elseif (strpos(self::$base, self::KNOWLEDGE_THEME) !== false || self::$base === 'contact') {
                $this->loadWrapper($template, self::KNOWLEDGE_THEME);
            }
            elseif (strpos(self::$base, self::REUSABLE_THEME) !== false) {
                $this->loadWrapper($template, self::REUSABLE_THEME);
            }
            elseif (strpos(self::$base, self::PRESSRELEASE_THEME) !== false) {
                $this->loadWrapper($template, self::PRESSRELEASE_THEME);
            }
            else {
                $this->loadWrapper($template);
            }
        }
    }

    private function loadWrapper($template, $themeKey = self::DEFAULT_THEME)
    {
        $file = self::$sage_assets_includes[$themeKey];
        if (!$filepath = locate_template($file)) {
            trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
        }

        require_once $filepath;

        unset($file, $filepath);

        $this->loadTemplate($template, $themeKey);
    }

    private function loadTemplate($template, $themeKey = self::DEFAULT_THEME)
    {
        $this->slug = basename($template, '.php');
        $this->templates = [$template];
//        var_dump($this->slug);
//        var_dump($this->templates);
//        var_dump(self::$base);
//        die;
        if (self::$base) {
            $str = substr($template, 0, -4);
            array_unshift($this->templates, sprintf($str.'-%s.php', self::$base));
            if ($themeKey !== self::DEFAULT_THEME) {
                end($this->templates);
                $key = key($this->templates);
                reset($this->templates);
                $this->templates[$key] = sprintf('base-%s.php', $themeKey);
            }
//            var_dump($this->templates);
//            die;
        }
    }

    public function __toString()
    {
        $this->templates = apply_filters('sage/wrap_'.$this->slug, $this->templates);
        return locate_template($this->templates);
    }

    public static function wrap($main)
    {
        // Check for other filters returning null
        if ( ! is_string($main)) {
            return $main;
        }

        self::$main_template = $main;
        self::$base          = basename(self::$main_template, '.php');

        if (self::$base === 'index') {
            self::$base = false;
        }
        return new SageWrapping();
    }
}

add_filter('template_include', [__NAMESPACE__.'\\SageWrapping', 'wrap'], 109);
