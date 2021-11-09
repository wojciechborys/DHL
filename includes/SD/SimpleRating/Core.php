<?php

namespace SD\SimpleRating;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Core {
    

    public function likeCounterWidget() {
        
        $postId = \get_the_ID();
        $likes = (int) \get_post_meta($postId, '_all_likes', true);
         
        return '<a href="" data-postid="'.$postId.'" class="love-button" data-toggle="tooltip" title=""><span class="likes">'.$likes.'</span></a>';
        
    }
    
    public function __construct() {
        
//         &filter_var(spr_get_ip(), FILTER_VALIDATE_IP)
        if(\wp_doing_ajax()) {
            $ajax = new Ajax();
        } else {
            \add_action('woocommerce_share', array($this, 'likeCounterWidget'));
        }
        
        
    }
}
