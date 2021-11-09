<?php

namespace SD\SimpleRating;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin {
    
    public function init( ) {
    }

    public function __construct() {
        add_filter( 'admin_init', array($this, 'init') );
    }
}
