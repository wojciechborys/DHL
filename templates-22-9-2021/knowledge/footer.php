<?php

use Roots\Sage\Assets;

$stringOffert = "Oferta dla firm";
$stringCall = 'Zadzwoń';

if (pll_current_language() === 'pl') {
    $stringOffert = "Oferta dla firm";
    $stringCall = 'Zadzwoń';
} elseif (pll_current_language() === 'en') {
    $stringOffert = "Offert";
    $stringCall = 'Call';
}


?>
<footer id="callCTA" class="mm-main-footer__container">
    <div class="container">
        <div class="row">
            <?php
            $theme_locations = get_nav_menu_locations();

            $menu_obj = get_term($theme_locations['footer_nav_new_first'], 'nav_menu');

            $menu_name = $menu_obj->name;

            $nav = wp_get_nav_menu_object($menu_name);
            $nav2 = wp_get_nav_menu_items($nav->term_id);
            $i = 0;
            foreach ($nav2

            as $item) { ?>
            <?php if ($item->menu_item_parent === "0") { ?>
            <?php if ($i != 0) { ?>
            </ul>
        </div>
        <?php } ?>
        <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-sm-4 mb-lg-0">
            <a class="font__color--red text-uppercase nav-toggle"
               href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
            <ul class="footer__menu nav-items">
                <?php } else { ?>
                    <li class="footer__menu--item"><a class="footer__menu--link font__subtitle--3 font__color--gray"
                                                      href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                    </li>
                <?php }
                $i++;
                }
                ?>
            </ul>
        </div>
        <div class="col-12 col-sm-6 col-md-12 col-lg-3 mt-4 mt-sm-0 mobile--footer">
            <span class="d-block font__title--4 font__color--red text-uppercase mb-2 mb-lg-0 mb-xl-2 el__mtm--3"><?php echo get_field('footer_first_title', $nav); ?></span>
            <?php
            $phone = get_field('footer_first_phone', $nav);
            if ($phone): ?>
                <span class="d-block font__title--033 font__color--gray mb-2 mb-lg-0 mb-xl-2">
                            <?php echo $phone['number']; ?>
                        </span>
                <span class="d-block font__title--2222 font__color--gray_light"><?php echo $phone['desc']; ?></span>
            <?php endif; ?>
            <?php $message = get_field('footer_first_send_message', $nav); ?>
            <hr>
            <a class="link--send-form font__color--gray to_form margin--footer"
               href="/kontakt/#contactForm"><?php echo $message['title']; ?></a>
            <a class="link--to-offer font__color--gray to_form"
               href="https://dhlexpress.pl/zostan-klientem">Oferta dla Firm</a>

        </div>
    </div>
    </div>

    <?php
    $theme_locations = get_nav_menu_locations();

    $menu_obj = get_term($theme_locations['footer_nav_new_second'], 'nav_menu');

    $menu_name = $menu_obj->name;

    $nav = wp_get_nav_menu_object($menu_name);
    ?>
    <div class="mm-main-footer bg__color--gray3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-3 col-lg-4 text-center text-sm-left mb-3 mt-1 mt-sm-3 mt-md-0 mb-sm-2">
                    <img style="max-width: 156px;" src="<?php echo (get_field('footer_logo', $nav))['url']; ?>"
                         alt="<?php echo (get_field('footer_logo', $nav))['alt']; ?>">
                </div>
                <div class="col-12 col-sm-12 col-md-9 col-lg-8 text-center text-sm-right inline-footer-menu">
                    <a href="#" id="" class="inline-footer-menu--item d-block d-sm-inline-block font_subtitle--2222 font_color--gray ot-sdk-show-settings">Cookie Settings</a>
                    <?php $nav2 = wp_get_nav_menu_items($nav->term_id);
                    // var_dump($nav2);
                    foreach ($nav2 as $item) { ?>
                        <a href="<?php echo $item->url; ?>"
                           class="inline-footer-menu--item d-block d-sm-inline-block font__subtitle--2222 font__color--gray"><?php echo $item->title ?></a>
                    <?php } ?>
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

    <div class="mobileShow">


        <div class="buttons-item2">
            <a href="https://dhlexpress.pl/zostan-klientem-1/" class="send-sms"><?php echo $stringOffert; ?></a>
        </div>


        <div class="buttons-item1">
            <a href="tel:+48426345100" class="call-us --footer"><?php echo $stringCall; ?></a>
        </div>



    </div>
    <?php // SD\Template\Tags\cookieConsentWorld(); ?>

</footer>
