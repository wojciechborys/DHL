<?php

use Roots\Sage\Assets;

do_action('get_footer');
?>
<footer id="callCTA" class="mm-main-footer__container">
    <?php
    $theme_locations = get_nav_menu_locations();

    $menu_obj = get_term($theme_locations['footer_nav_new_second'], 'nav_menu');

    $menu_name = $menu_obj->name;

    $nav_links = get_sub_field('links');
    ?>
    <div class="mm-main-footer bg__color--gray3 mt-0 py-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-4 text-center text-sm-left my-0">
                    <img style="max-width: 156px;" src="<?php echo get_sub_field('footer_logo')['url']; ?>"
                         alt="<?php echo get_sub_field('footer_logo')['alt']; ?>">
                </div>
                <div class="col-12 col-sm-12 col-md-9 col-lg-8 text-center text-sm-right inline-footer-menu">
                    <!--                    --><?php //$nav2 = wp_get_nav_menu_items($nav->term_id);
                    if ($nav_links) {
                        foreach ($nav_links as $item) { ?>
                            <a href="<?php echo $item['link']['url']; ?>"
                               class="inline-footer-menu--item d-block d-sm-inline-block font__subtitle--2222 font__color--gray"><?php echo $item['link']['title'] ?></a>
                        <?php }
                    } ?>
                    <a href="https://pl.linkedin.com/company/dhlexpresspoland" target="_blank" rel="nofollow"
                       class="inline-footer-menu--item d-block d-sm-inline-block font__subtitle--2222"><img
                                class="inline-footer-menu--img"
                                src="<?= esc_url(Assets\asset_path('images/ico_in.png', 'asset-sources/dhlknowledge/dist')); ?>"
                                alt="in"></a>
                </div>
            </div>
        </div>
    </div>
    <?php

    $popup_enable = get_field("popup_enable", 'options');

    ?>
    <?php if ($popup_enable) :

        $popup_text = get_field("popup_text", 'options');
        $popup_button = get_field("popup_button", 'options');
        $popup_icon = get_field("popup_icon", 'options');
        $popup_cache = get_field("popup_cache_id", 'options');
        ?>
        <div id="footerPopup" class="footer__overlay" data-cookie="<?php echo esc_attr($popup_cache); ?>">
            <div class="footer__popup">
                <span class="footer__popup__close js-footer-popup-close"></span>
                <div class="footer__popup__image">
                    <?php if ($popup_icon): ?>
                        <img src="<?php echo esc_url($popup_icon['url']); ?>"
                             alt="<?php echo esc_url($popup_icon['alt']); ?>">
                    <?php endif; ?>
                </div>
                <div class="footer__popup__content">
                    <?php echo $popup_text; ?>
                    <?php if ($popup_button): ?>
                        <a id="footerLink" class="footer__popup__link js-popup-link"
                           href="<?php echo esc_url($popup_button['url']); ?>"
                           title="<?php echo esc_attr($popup_button['title']); ?>"
                           target="<?php echo esc_attr($popup_button['target']); ?>">
                            <?php echo $popup_button['title']; ?>
                        </a>
                    <?php endif; ?>
                </div>

            </div>
        </div>

    <?php endif; ?>
    <?php // SD\Template\Tags\cookieConsentWorld(); ?>

</footer>