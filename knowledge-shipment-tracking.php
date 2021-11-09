<?php

/**
 * Template name: Page Shipment Tracking
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
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

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/knowledge/header-new'); ?>
    <div class="slider_search--static">
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
                                            class="d-block btn btn--red btn--auto btn-primary btn--calc text-uppercase"><?= Polylang\t9n('Sprawdź'); ?></button>
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
    </div>
    <?php get_template_part('templates/knowledge/section-image-text'); ?>
    <?php get_template_part('templates/knowledge/section-custom-posts'); ?>
    <?php get_template_part('templates/knowledge/section-steps'); ?>
    <?php get_template_part('templates/knowledge/section-news'); ?>
    <?php get_template_part('templates/knowledge/prefooter'); ?>

<?php endwhile; ?>