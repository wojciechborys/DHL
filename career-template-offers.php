<?php
/**
 * Template Name: Oferty
 */

use SD\Template\Tags;
use Roots\Sage\Assets;

if (have_posts()) : the_post();
?>

<?php
    Tags\introSection();
?>

<section class="offers">
    <div class="offers__container container">
        <div class="offers__row row justify-content-center">
            <div class="col-12 col-md-11 col-lg-9">
                <h1 class="offers__header">Jeżeli chcesz dołączyc do najlepszych, zapoznaj się z aktualnymi ofertami pracy</h1>
            </div>

            <div class="offers__content col-12 col-md-11">
                <img class="img-fluid" src="<?= esc_url(Assets\asset_path('images/offers-placeholder.jpg', 'asset-sources/dhlcareer/dist')) ?>" />
            </div>
        </div>
    </div>
</section>

<?php
endif;
