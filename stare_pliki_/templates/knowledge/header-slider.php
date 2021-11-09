<?php

use MintMedia\PolylangT9n\Polylang;

$trackingUrl = '';
$readdressUrl = '';
if (pll_current_language() === 'pl') {
    $trackingUrl = 'https://www.logistics.dhl/pl-pl/home/tracking.html';
    $readdressUrl = 'https://delivery.dhl.com/prg/jsp/index.xhtml?ctrycode=PL';
} elseif (pll_current_language() === 'en') {
    $trackingUrl = 'https://www.logistics.dhl/global-en/home/tracking.html';
    $readdressUrl = 'https://delivery.dhl.com/prg/jsp/index.xhtml?ctrycode=EN';
}

?>
<?php if (have_rows('header__slider')): ?>
    <section class="slider">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php $i = 0;
                while (have_rows('header__slider')) : the_row(); ?>
                    <?php if ($i == 0) { ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>"
                            class="active"></li>
                    <?php } else { ?>
                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>"></li>
                    <?php } ?>
                    <?php $i++;
                endwhile; ?>
            </ol>
            <div class="carousel-inner">
                <?php $i = 0 ; while (have_rows('header__slider')) : the_row(); ?>
                   <?php
                    $color_text = '';
                    if( get_sub_field('header__color_text') != "") {
                    $color_text = 'style="color: '.get_sub_field('header__color_text').';"';
                    }
                    ?>
                    <div class="carousel-item <?=( $i == 0 ) ? 'active' : ''; ?>">
                        <img class="d-block w-100"
                             src="<?= esc_url((get_sub_field("header__background"))['url']); ?>"
                             alt="First slide">

                        <div class="carousel-caption text-left ">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-lg-7 col-xl-6 pb-5 pb-md-1">
                                        <span class="background_image--title d-block font__title--01 font__color--gray" <?php echo $color_text; ?>><?php echo get_sub_field('header__title') ?></span>
                                        <p class="font__color--dark-gray font__subtitle--022 pb-2 pb-md-4" <?php echo $color_text; ?>><?php echo get_sub_field('header__text') ?></p>
                                        <?php
                                        $button = get_sub_field('header__button');
                                        if (($button['title']) && ($button['url'] != '#')):
                                            echo '<a href="' . esc_url($button['url']) . '" target="' . $button['target'] . '" class="btn btn--auto btn--red btn-primary btn--calc text-uppercase">' . $button['title'] . '</a>';
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php $i++; endwhile; ?>
            </div>
            <a class="d-none carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="d-none carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-xl-10 mx-auto">
                    <div class="slider_search">

                            <form method="GET" action="<?php echo $trackingUrl; ?>" target="_blank">
                                <div class="row no-gutters">
                                    <div class="col-12 col-lg-8 col-xl-9">
                                        <input type="text" name="tracking-id" class="form-control tracking_nr"
                                               name="email" placeholder="<?php echo Polylang\t9n('Wpisz numer przesyłki'); ?>"/>
                                        <input type="hidden" name="submit" value="1"/>

                                    </div>
                                    <div class="col-12 col-lg-4 col-xl-3 mt-1 mt-lg-0 pl-lg-0  mt-lg-0 text-center">
                                        <button type="submit" role="button"
                                                class="d-block btn btn--yellow-slider btn--auto btn-primary btn--calc text-uppercase"><?= Polylang\t9n('Sprawdź '); ?><?php // pll_e('Intro: button');  ?></button>
                                        <!--a rel="nofollow" target="_blank" title="Zarządzaj dostawą przesyłki"
                                           href="<?php echo $readdressUrl; ?>" class="d-none d-lg-inline-block btn btn--check text-uppercase"><?= Polylang\t9n('ZARZĄDZEJ DORĘCZENIEM'); ?></a-->

                                        <a rel="nofollow" target="_blank" title="Zarządzaj dostawą przesyłki"
                                           href="<?php echo $readdressUrl; ?>"
                                           class="font__color--gray font__subtitle--03 mt-2 mt-md-1 d-inline-block el__w100"
                                           title="<?php echo Polylang\t9n('Zarządzaj dostawą przesyłki'); ?>">
                                            <?php echo Polylang\t9n('Zarządzaj dostawą przesyłki'); ?>
                                        </a>
                                    </div>
                                </div>
                            </form>

                    </div>
                </div>
            </div>
        </div>

    </section>
<?php endif; ?>