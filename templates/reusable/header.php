<?php

use Roots\Sage\Assets;
use MintMedia\PolylangT9n\Polylang;

$header_navigation = get_field('lp_headerr_navigation', get_the_ID())['navigation'];
$header_banner = get_field('lp_header', get_the_ID());

?>
<?php

$header_top_enable = get_field("header_top_enable", 'options');

?>
<div id="header-top" class="reusable__header-top"
     style="background-image: url('<?php echo $header_banner['background_img'] ?>')">
    <?php if ($header_top_enable) :

        $background_header = get_field("header_top_background_color", 'options');
        $header_link = get_field("header_top_link", 'options');

        ?>
        <div class="header-up" style="background-color: <?php echo esc_attr($background_header); ?>;">
            <div class="container">
                <?php if ($header_link) : ?>
                    <a class="header-up__link" href="<?php echo esc_url($header_link['url']); ?>" title="<?php echo esc_attr($header_link['title']); ?>"
                       target="<?php echo esc_attr($header_link['target']); ?>">
                        <?php echo $header_link['title']; ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <header class="banner__header <?php echo $header_top_enable ? 'header_top_enable js-header' : ''; ?>">
        <div class="container banner__container">
            <div class="banner__bar" data-banner-bar>
                <div class="hamburger js-hamburger">
                </div>
                <a class="brand banner__brand" href="<?= esc_url(home_url('/')); ?>">
                    <img class="brand banner__brand-image brand banner__brand-image--xs"
                         src="<?= esc_url(Assets\asset_path('images/logo.png', 'asset-sources/dhlexpress/dist')); ?>"
                         alt="DHL Express"/>
                    <img class="brand banner__brand-image brand banner__brand-image--md-up"
                         src="<?= esc_url(Assets\asset_path('images/logo-large.png', 'asset-sources/dhlexpress/dist')); ?>"
                         alt="DHL Express"/>
                </a>
                <ul id="dhl-menu-<?php echo $post->post_name; ?>" class="mm-nav">
                    <?php
                    foreach ($header_navigation as $nav_item) :
                        ?>
                        <li class="nav-item navbar__nav-item">
                            <a href="<?php echo $nav_item['link']['url']; ?>" class="nav-link navbar__nav-link"
                               data-nav-link="">
                                <span class="nav-primary__link-text"><?php echo $nav_item['link']['title']; ?></span>
                            </a>
                        </li>
                    <?php
                    endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </header>
    <div class="container reusable__header-top__banner" id="<?php echo str_replace(' ', '-', $header_banner['id']); ?>">
        <div class="row">
            <div class="col-12 col-lg-6">
                <h6 class="font__subtitle--022 text-uppercase mb-1 mb-lg-4"><?php echo $header_banner['subtitle'] ?></h6>
                <h1 class="font__title--01 text-uppercase pb-3 pb-lg-5 mb-1 mb-lg-4"><?php echo $header_banner['title'] ?></h1>
                <div class="reusable__header-top__desc">
                    <?php echo $header_banner['desc'] ?>
                </div>
            </div>
            <div class="col-12 col-lg-6 d-flex justify-content-center justify-content-lg-end">
                <div class="form-box">
                    <iframe id="reusableIframe" class="form-box__iframe w-100"
                            src="<?php echo $header_banner['link_to_form']; ?>"
                            frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>


