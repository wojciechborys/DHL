<?php

use Roots\Sage\Assets;
use MintMedia\PolylangT9n\Polylang;

$dh_express_ID = get_the_ID();
if (is_tax()) {
    $dh_express_ID = get_queried_object();
}

$image_bg = (get_field('header__image', $dh_express_ID) == "") ? get_field('header__image', 'option') : get_field('header__image', $dh_express_ID);
$image_bg_link = $image_bg['url'];

$title = (get_field('header__title', $dh_express_ID) == '') ? get_field('header__title', 'option') : get_field('header__title', $dh_express_ID);
$desc = (get_field('header__desc', $dh_express_ID) == '') ? get_field('header__desc', 'option') : get_field('header__desc', $dh_express_ID);
$button = get_field('header__button', $dh_express_ID);
$enable_header = get_field('enable__header', $dh_express_ID);

$color_text = '';
if( get_field('header__font_color', $dh_express_ID) != "") {
    $color_text = 'style="color: '.get_field('header__font_color', $dh_express_ID).';"';
}
$header_top_enable = get_field("header_top_enable", 'options');
?>
<?php if ($enable_header) : ?>
    <section class="background_image background_image--header <?php echo $header_top_enable ? 'background_image--header-margin' : ''; ?> d-flex align-items-center "
             style="background-image:url('<?php echo $image_bg_link; ?>');">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7 col-xl-7">
                    <h1 class="background_image--title d-block font__title--01 font__color--gray mb-2" <?php echo $color_text; ?>>
                        <?php echo $title; ?>
                    </h1>
                    <p class="font__color--dark-gray font__subtitle--022" <?php echo $color_text; ?>><?php echo $desc; ?></p>
                    <?php
                    if ($button):
                        echo '<a href="' . esc_url($button['url']) . '" target="' . $button['target'] . '" class="btn btn--auto btn--red btn-primary btn--calc text-uppercase mt-lg-4">' . $button['title'] . '</a>';
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>
<?php else : ?>
    <div class="header_clearfix pb-5 mb-sm-1"></div>
<?php endif; ?>
