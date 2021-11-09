<?php

use Roots\Sage\Assets;
use MintMedia\PolylangT9n\Polylang;

?>

<div class="container mb-5 mt-5 pb-lg-5 px-3 px-lg-0">
    <div class="row">
        <div class="col-12 city px-lg-5 py-5">
            <div class="city__top d-flex align-items-center justify-content-center justify-content-lg-between ">
                <div class="city__top__left">
                    <img class="img-fluid" src="<?php echo esc_url(get_field('city__image__left')['url']); ?>"
                         alt="<?php echo esc_attr(get_field('city__image__left')['alt']); ?>">
                </div>
                <div class="text-center px-3 mx-lg-5 px-lg-5">
                    <h4 class="city__title"><?php echo get_field('city__title'); ?></h4>
                    <div data-text-more="<?php echo get_field('city__link'); ?>"
                         data-text-less="<?= Polylang\t9n('ZWIŃ'); ?>"
                         class="city__link btn btn-link font__title--06 text-uppercase font__color--red js-click-city">
                        <span><?php echo get_field('city__link'); ?></span>
                        <img src="<?= esc_url(Assets\asset_path('images/acc_arrow_top_b.png', 'asset-sources/dhlknowledge/dist')); ?>">
                    </div>
                </div>
                <div class="city__top__right">
                    <img class="img-fluid" src="<?php echo esc_url(get_field('city__image__right')['url']); ?>"
                         alt="<?php echo esc_attr(get_field('city__image__right')['alt']); ?>">
                </div>
            </div>
            <div class="city__bottom">
                <?php if (have_rows('service_point_city', 'option')): ?>
                    <div class="city__bottom__container mt-5 pt-4 d-flex justify-content-between px-4">
                        <?php while (have_rows('service_point_city', 'option')) : the_row(); ?>
                            <div class="city__bottom__col px-3 text-left">
                                <?php if (have_rows('city')): ?>
                                    <?php while (have_rows('city')) : the_row(); ?>
                                        <?php if (get_sub_field('link') != ""): ?>
                                            <a class="d-block city__bottom__text"
                                               href="<?php echo esc_attr(get_sub_field('link')); ?>"
                                               title="<?php echo esc_attr(get_sub_field('name')); ?>""><?php echo get_sub_field('name') ?></a>
                                        <?php else: ?>
                                            <span class="d-block city__bottom__text"><?php echo get_sub_field('name') ?></span>
                                        <?php endif; ?>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</div>
