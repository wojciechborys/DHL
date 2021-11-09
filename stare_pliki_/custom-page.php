<?php
/**
 * Template Name: Custom Template DHLEXPRESS
 */
?>

<?php
use MintMedia\PolylangT9n\Polylang;
use MintMedia\ShipmentCalc\Helpers;
use MintMedia\Dhl\Templates;
use MintMedia\Dhl\Tags;
use SD\Template\Tags as SdTags;
use Roots\Sage\Assets;


?>

<section class="content-intro">
    <div class="content-intro__background">
        <?php the_post_thumbnail('full'); ?>
        <div class="content-intro__container">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="editor text-left">
                            <?php the_content(); ?>
                        </div>
                        <?php $subtitle = get_field('top_visual', $post)['subtitle'];
                        if ($subtitle): ?>
                            <div class="content-intro__info editor ul-ticks">
                                <?php echo $subtitle; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (get_field('top_visual', $post)['cta_button']['url'] && get_field('top_visual', $post)['cta_button']['label']): ?>
                            <p class="content-intro__btn-wrapper">
                                <a href="<?php echo get_field('top_visual', $post)['cta_button']['url']; ?>" class="btn btn-primary btn--content-intro" data-scroller>
                                    <?php echo get_field('top_visual', $post)['cta_button']['label']; ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="open-account" id="open-account">
    <div class="container">
        <div class="row d-flex justify-content-center mt-5">
            <div class="col-12 col-sm-10 pt-5 pt-xl-0 mt-5 mt-xl-0">
                <h2 class="shipment-options__header mb-1 break-word">
<!--                    --><?php //echo Polylang\t9n('Otwórz konto firmowe'); ?><!-- --><?php //echo Polylang\t9n('w DHL Express!'); ?>
                    <?php the_field('international_shipments_for_companies_title'); ?>
                </h2>
                <div class="content-intro__info text-center mb-0">
                    <?php the_field('international_shipments_for_companies_desc'); ?>
<!--                    <p>--><?php //echo Polylang\t9n('Cieszymy się, że możemy być zaufanym partnerem'); ?><!-- --><?php //echo Polylang\t9n('w zakresie przesyłek międzynarodowych.'); ?><!--</p>-->
                </div>
            </div>
        </div>
        <div class="row d-flex justify-content-center">
            <div class="col-12">
                <?php Templates\contact_form(); ?>
            </div>
        </div>
    </div>
</div>

