<?php

use Roots\Sage\Assets;
use MintMedia\PolylangT9n\Polylang;

?>
<?php

$header_top_enable = false;

?>

<header class="banner__header <?php echo $header_top_enable ? 'header_top_enable js-header' : ''; ?> d-flex align-items-center" style="background-color: #f8c500; position: static">
    <div class="container-gogreen banner__container menu-gogreen">
        <div class="banner__bar px-4 px-lg-0" data-banner-bar>

            <div class="hamburger js-hamburger">
            </div>
            <a class="brand banner__brand w-auto" href="<?= esc_url(home_url('/')); ?>">
                <img class="brand banner__brand-image brand banner__brand-image--xs" src="<?= esc_url(Assets\asset_path('images/logo-gogreen-mobile.png', 'asset-sources/dhlexpress/dist')); ?>" alt="DHL Express" />
                <img class="brand banner__brand-image brand banner__brand-image--md-up" src="<?= esc_url(Assets\asset_path('images/logo-gogreen.png', 'asset-sources/dhlexpress/dist')); ?>" alt="DHL Express" />
            </a>
            <?php
            wp_nav_menu([
                'container' => false,
                'theme_location' => 'main_navigation',
                'menu_class' => 'banner__list navbar-nav ml-0 mr-auto',
                'walker' => new SD\Walkers\B4NavWalker(),
                'link_before' => '<span class="nav-primary__link-text">',
                'link_after' => '</span>',
            ]);
            ?>

            <?php
            $mydhlUrl = '';
            if (pll_current_language() === 'pl') {
                $mydhlUrl = 'https://mydhl.express.dhl/pl/pl/home.html';
            } elseif (pll_current_language() === 'en') {
                $mydhlUrl = 'https://mydhl.express.dhl/pl/en/home.html';
            } ?>
            <a href="<?php echo $mydhlUrl; ?>" target="_blank" class="btn btn--auto btn-primary btn--calc ml-3 mr-3 order-3 navbar-gogreen-dhlplus--xs" title="MyDHL+">MyDHL+</a>

            <div class="contact-form__btn-wrapper">
                <button class="btn btn-secondary btn--wide contact-form__submit" data-submit="<?php if (is_front_page()) : ?>contact<?php else : ?>toggle<?php endif; ?>"><?= Polylang\t9n('Wysyłaj taniej'); ?></button>
            </div>
        </div>
    </div>
</header>
</div>