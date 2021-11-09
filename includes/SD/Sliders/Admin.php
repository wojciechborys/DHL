<?php

namespace SD\Sliders;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Admin {

    
	public function saveCustomFields($post_id, $post) {

		if (!current_user_can('edit_post', $post_id)) {
			return false;
		}

		if ($post->post_type == 'revision') {
			return false;
		}
		
        
        $connectedPostId = \filter_input(INPUT_POST, '_connected_post_id', FILTER_VALIDATE_INT);
		if (!empty($connectedPostId)) {
			update_post_meta($post_id, '_connected_post_id', $connectedPostId);
		}

	}

    
    public function displayMetaBox() {
        global $post;
//		wp_nonce_field('sd-custom-fields', 'sd-custom-fields_wpnonce', false, true);

        $postId = (int) get_post_meta($post->ID, '_connected_post_id', true);

        echo '
		<table class="form-table">
			<tr>
				<th>
					<label>' . __('Powiązany artykuł', 'sd-theme') . '</label>
				</th>
				<td><select name="_connected_post_id">';
        
                $args = array( 'numberposts' => -1);
                $posts = get_posts($args);
                foreach( $posts as $post ) {
                    echo '<option value="'.$post->ID.'" '.($postId === $post->ID ? 'selected="selected"' : '').'>'.$post->post_title.'</option>';
                }

 
                echo '
                    </select>
				</td>
			</tr>
		</table>';
    }

    public function init( ) {
        \add_meta_box('mm-slide-settings', __('Ustawienia slajdu', 'mm'), array($this, 'displayMetaBox'), 'slide', 'normal', 'high');
		\add_action('save_post', array($this, 'saveCustomFields'), 1, 2);
    }

    public function __construct() {
        add_filter( 'admin_init', array($this, 'init') );
    }
}
