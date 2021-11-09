<?php
use Roots\Sage\Assets;
use SD\Options\OptionsHelper;

$optionsHelper = OptionsHelper::getInstance();
?>
<div class="banner" data-banner>
    <header class="banner__header">
        <div class="container banner__container">

            <nav class="navbar navbar-expand-lg navbar-dark banner__navbar career">
                <a class="brand banner__brand order-1" href="<?= esc_url(home_url('/')); ?>">
                    <img class="brand banner__brand-image banner__brand-image--xs" src="<?= esc_url(Assets\asset_path('images/logo.png', 'asset-sources/dhlcareer/dist')); ?>" alt="DHL Express" />
                    <img class="brand banner__brand-image banner__brand-image--md-up" src="<?= esc_url(Assets\asset_path('images/logo-large.png', 'asset-sources/dhlcareer/dist')); ?>" alt="DHL Express" />
                </a>

                <?php
            if (has_nav_menu('career_primary_navigation')) :
                $navID = esc_attr(uniqid('nav-'));
                ?><button class="navbar-toggler nav-primary__toggler order-3 order-lg-2" type="button" data-noscroll data-toggle="collapse" data-target="#<?= $navID; ?>" aria-controls="<?= $navID; ?>" aria-expanded="false" aria-label="Przełącz nawigację">
                    <span class="navbar-toggler-icon nav-primary__toggler_icon"></span>
                </button>

                <div class="collapse navbar-collapse nav-primary banner__navbar-collapse order-4 order-lg-3 justify-content-end" id="<?= $navID; ?>">

                    <?php
                    $itemsWrap = '<ul id="%1$s" class="%2$s">%3$s';
                    $menuLogo = $optionsHelper->get('general::header_logo', false);

                    if ($menuLogo) {
                        $menuLogoId = $optionsHelper->get('general::header_logo_id', false);
                        $menuLogoSrc = $menuLogoId ? wp_get_attachment_image_url($menuLogoId, 'full') : $menuLogo;
                        // $itemsWrap .= '<li class="nav-link navbar__nav-link navbar__nav-link--logo"><img class="img-fluid" src="'.$menuLogoSrc.'" /></li>';
                        $itemsWrap .= '<li class="menu-item nav-item nav-item-logo"><img class="img-fluid" src="'.$menuLogoSrc.'" /></li>';
                    }

                    $itemsWrap .= '</ul>';

                    wp_nav_menu([
                        'container'      => false,
                        'theme_location' => 'career_primary_navigation',
                        'menu_class'     => 'banner__list navbar-nav',
                        'walker'         => new SD\Walkers\B4NavWalker(),
                        'link_before'    => '<span class="nav-primary__link-text">',
                        'link_after'     => '</span>',
                    ]);
                    ?>

                </div><?php
            endif;
                ?>

                <?php

            $headerLogo = $optionsHelper->get('general::header_logo', false);

            if ($headerLogo) :
                $headerLogoId = $optionsHelper->get('general::header_logo_id', false);
                $headerLogoSrc = $headerLogoId ? wp_get_attachment_image_url($headerLogoId, 'full') : $headerLogo;

                ?><div class="banner__header-logo-wrapper order-2 order-lg-4">
                    <div class="banner__header-logo">
                        <img src="<?= esc_url($headerLogoSrc); ?>" class="img-fluid" />
                    </div>
                </div><?php
            endif;
            ?>

            </nav>
        </div>
    </header>
</div>
