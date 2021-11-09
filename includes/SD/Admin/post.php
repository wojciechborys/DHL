<?php
namespace SD\Admin\Post;

use Roots\Sage\Assets;
use SD\Template\Tags;
use SD\Restricted;

/**
 * Dodaje skrypty i style do panelu edycji wpisu.
 *
 * @return void
 */
function assets() {
    $screen = \get_current_screen();

    if ($screen && $screen->base === 'post' && $screen->post_type === 'post') {
        \wp_enqueue_script(
            'js/admin/post',
            Assets\asset_path('scripts/admin-post.js', 'asset-sources/dhlworld/dist'),
            ['jquery'],
            '1.0.0',
            true
        );

        \wp_enqueue_style(
            'css/admin/post',
            Assets\asset_path('styles/admin-post.css', 'asset-sources/dhlworld/dist'),
            [],
            '1.0.0',
            'all'
        );
    }
}
\add_action( 'admin_enqueue_scripts', __NAMESPACE__.'\\assets');

/**
 * Dodaje pole do wpisywania podtytułu wpisu.
 *
 * @param \WP_Post $post
 */
function subtitleInput($post) {
    if ('post' === $post->post_type) :
        $subtitle = Tags\getSubtitle($post);
        ?><input name="_subtitle" value="<?= esc_attr($subtitle); ?>" type="text" style="width:100%; padding:8px; display:block;" placeholder="Podtytuł wpisu" /><?php
    endif;
}
\add_action('edit_form_before_permalink', __NAMESPACE__.'\\subtitleInput');

/**
 * Zapisuje podtytuł.
 *
 * @param  int     $postID
 * @param  \WP_Post $post
 * @return void
 */
function saveSubtitle($postID, $post) {
    $subtitle = \filter_input(INPUT_POST, '_subtitle');

    if (null !== $subtitle) {
        \update_post_meta($postID, '_subtitle', (string) $subtitle);
    }
}
\add_action('save_post', __NAMESPACE__.'\\saveSubtitle', 10, 2);

/**
 * Dodaje metaboksy wpisu.
 *
 * @return void
 */
function metaBoxes() {
    \add_meta_box(
        'locked-status-box',
        'Ograniczenie dostępu',
        __NAMESPACE__.'\\lockedOptions',
        ['post'],
        'advanced',
        'high'
    );

    \add_meta_box(
        'top-image-box',
        'Górny obraz wyróżniony',
        __NAMESPACE__.'\\topImageBox',
        ['post'],
        'side',
        'low'
    );

    \add_meta_box(
        'recommended-status-box',
        'Rekomendacja',
        __NAMESPACE__.'\\recommendedOptions',
        ['post'],
        'advanced',
        'high'
    );
}
\add_action('admin_init', __NAMESPACE__.'\\metaBoxes');

/**
 * Dodaje pole do blokowania wpisu.
 *
 * @param \WP_Post $post
 */
function lockedOptions($post) {
    $locked = Restricted\isLocked($post);
    ?><table class="form-table">
        <tr>
            <th scope="row">
                <label for="post-locked-control">Zabezpiecz wpis</label>
            </th>

            <td>
                <select name="_post_locked" id="post-locked-control">
                    <option value="0"<?php \selected(false, $locked); ?>>Nie</option>
                    <option value="1"<?php \selected(true, $locked); ?>>Tak</option>
                </select>
            </td>
        </tr>
    </table><?php
}

/**
 * Zapisuje podtytuł.
 *
 * @param  int     $postID
 * @param  \WP_Post $post
 * @return void
 */
function saveLocked($postID, $post) {
    $locked = \filter_input(INPUT_POST, '_post_locked');

    if (null !== $locked) {
        if ($locked) {
            \update_post_meta($postID, '_locked', '1');
        } else {
            \delete_post_meta($postID, '_locked');
        }
    }
}
\add_action('save_post', __NAMESPACE__.'\\saveLocked', 10, 2);

/**
 * Dodaje pole do blokowania wpisu.
 *
 * @param \WP_Post $post
 */
function topImageBox($post) {
    $imageID = Tags\getTopImageID($post);
    $imageSrc = $imageID ? \wp_get_attachment_image_src($imageID, 'top-post-image') : false;

    ?><div class="ap-top-image" data-image-box>
        <input name="_top_image_id" value="<?= $imageID; ?>" type="hidden" data-image-id />
        <div class="ap-image-preview" data-image-preview>
            <?php
            if ($imageSrc) :
                ?><img src="<?= esc_url($imageSrc[0]); ?>" class="ap-image" data-choose-image /><?php
            endif;
            ?>
        </div>

        <div class="ap-button-wrapper">
            <button class="button button-secondary ap-button" type="button" data-choose-image>Wybierz obraz</button>
            <button class="button button-secondary ap-button <?php if (!$imageID) : ?> hidden<?php endif; ?>" type="button" data-remove-image>Usuń obraz</button>
        </div>
    </div><?php
}


/**
 * Dodaje pole do oznaczania wpisu jako polecony
 *
 * @param WP_Post $post
 */
function recommendedOptions($post) {
    $recommended = Tags\isRecommended($post);
    ?><table class="form-table">
        <tr>
            <th scope="row">
                <label for="post-recommended-control">Wpis polecany</label>
            </th>

            <td>
                <select name="_post_recommended" id="post-recommended-control">
                    <option value="0"<?php \selected(false, $recommended); ?>>Nie</option>
                    <option value="1"<?php \selected(true, $recommended); ?>>Tak</option>
                </select>
            </td>
        </tr>
    </table><?php
}

/**
 * Zapisuje czy post jest polecany
 *
 * @param  int     $postID
 * @param  WP_Post $post
 * @return void
 */
function saveRecommended($postID, $post) {
    $recommended = \filter_input(INPUT_POST, '_post_recommended');

    if (null !== $recommended) {
        if ($recommended) {
            \add_post_meta($postID, '_recommended', '1');
        } else {
            \delete_post_meta($postID, '_recommended');
        }
    }
}
\add_action('save_post', __NAMESPACE__.'\\saveRecommended', 10, 2);

/**
 * Zapisuje górny obraz.
 *
 * @param  int     $postID
 * @param  \WP_Post $post
 * @return void
 */
function saveTopImageID($postID, $post) {
    $imageID = \filter_input(INPUT_POST, '_top_image_id', FILTER_VALIDATE_INT);

    if (null !== $imageID) {
        if ($imageID) {
            \update_post_meta($postID, '_top_image_id', $imageID);
        } else {
            \delete_post_meta($postID, '_top_image_id');
        }
    }
}
\add_action('save_post', __NAMESPACE__.'\\saveTopImageID', 10, 2);


/**
 * Metaboks ustawień wpisu.
 */
function metaBox() {

    $cmb = \new_cmb2_box([
        'id'            => 'post_settings',
        'title'         => 'Ustawienia wpisu',
        'object_types'  => ['post'], // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true, // Show field names on the left
    ]);

    # możliwe ukrycie
    $cmb->add_field([
        'name'             => 'Ukryj na głównej',
        'desc'             => 'Określ, czy wpis ma wyświetlać sie na stronie głównej w sekcji &quot;Polecane&quot;.',
        'id'               => '_sd_hide_on_front',
        'type'             => 'radio',
        'show_option_none' => false,
        'options'          => [
            'on'  => 'Ukryj',
            'off' => 'Wyświetl',
        ],
        'default'          => 'off',
    ]);

    # obrazy
    $cmb->add_field([
        'name'         => 'Obraz na listę',
        'desc'         => 'Obraz do sekcji &quot;Polecane&quot; na stronie głównej.',
        'id'           => '_sd_recommendations_image',
        'type'         => 'file',
        'text'         => [
            'add_upload_file_text' => 'Dodaj plik',
        ],
        'query_args' => [
            'type' => [
                'image/jpeg',
                'image/png',
            ],
        ],
        'preview_size' => 'small',
    ]);

}
\add_action('cmb2_admin_init',  __NAMESPACE__ . '\\metaBox');