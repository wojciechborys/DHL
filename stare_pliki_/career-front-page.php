<?php

/**
 * Template name: [Kariera] Główna
 */

use SD\Template\Tags;
use Roots\Sage\Assets;
use SD\Options\OptionsHelper;

if (have_posts()) : the_post();

    $optionsHelper = OptionsHelper::getInstance();
    ?>

    <div class="main-slider videos" id="videos">

        <div class="container main-slider__carousel">
            <div class="row">
                <div class="col">

                    <div class="owl-carousel owl-theme" data-owl-carousel="videos-carousel" data-loop="0" data-nav="0" data-center="1" data-stage-padding="20">

                        <?php
                        $videos = $optionsHelper->get('videos::videos');

                        foreach ($videos as $key => $video) :
                            ?>
                            <div class="videos__embed-col">
                                <div class="videos__video-placeholder-container" data-placeholder-container>
                                    <a href="#videoModal<?= $key; ?>" class="videos__play-video" data-btn="play" data-toggle="modal" data-play="#video<?= $key; ?>">odtwórz</a>
                                    <img class="img-fluid videos__video-placeholder" src="<?= esc_url(Tags\videoThumbnailSrc($key)); ?>" data-placeholder />
                                </div>
                                <h2 class="videos__video-title"><?= $video['title']; ?></h2>
                                <div class="videos__video-info"><?= Tags\formatContent($video['desc']); ?></div>
                            </div>
                        <?php
                        endforeach;
                        ?>

                    </div>

                </div>

            </div>
        </div>

        <?php
        foreach ($videos as $key => $video) :
            ?>
            <div class="videos__modal modal fade" tabindex="-1" role="dialog" id="videoModal<?= $key; ?>">
                <div class="videos__dialog modal-dialog modal-lg" role="document">
                    <div class="videos__modal-content modal-content">
                        <button type="button" class="videos__modal-close close" data-dismiss="modal" aria-label="Zamknij">
                            <span aria-hidden="true">&times;</span>
                        </button>

                        <div class="videos__modal-body modal-body">
                            <?= Tags\videoIframe($key); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        endforeach;
        ?>

    </div>

    <section class="fp-custom-content" id="custom-content">
        <div class="container fp-custom-content__container">
            <div class="row">
                <div class="col-12 fp-custom-content__content">
                    <?php
                    $customContentTtile = Tags\customContentTitle(false);

                    if ($customContentTtile) :
                        ?><h1 class="fp-custom-content__title"><?= Tags\customContentTitle(); ?></h1><?php
                    endif;
                    ?>

                    <?php Tags\customContent(); ?>
                </div>

                <?php
                $btnUrl = $optionsHelper->get('custom_content::button_url');
                $btnText = $optionsHelper->get('custom_content::button_text');

                if ($btnUrl && $btnText) :

                    ?><div class="col-12 fp-custom-content__more">
                    <a href="<?= $btnUrl; ?>" class="btn btn-primary fp-custom-content__btn"><?= $btnText; ?></a>
                    </div><?php

                endif;
                ?>
            </div>
        </div>
    </section>

    <?php
    $offersArgs = [
        'posts_per_page' => -1,
        'post_type' => 'offer',
    ];
    ?>

    <section id="positions" class="positions-section">

        <?php
        $termSlug = $optionsHelper->get('offers::offers1_slug');

        if ($termSlug) :

            $offersArgs['tax_query'] = [
                [
                    'taxonomy' => 'offercategory',
                    'field'    => 'slug',
                    'terms'    => $termSlug,
                ]
            ];

            $offers = get_posts($offersArgs);

            ?><section class="employment-offers employment-offers--terminals">
            <div class="employment-offers__container container">
                <div class="employment-offers__row row">

                    <div class="employment-offers__content col-12 col-md-7 col-lg-6 order-2">
                        <div class="row justify-content-end">
                            <div class="employment-offers__offers-intro col-12 col-xl-10">
                                <h1 class="employment-offers__title"><?= $optionsHelper->get('offers::offers1_title'); ?></h1>
                                <p class="employment-offers__info"><?= wptexturize($optionsHelper->get('offers::offers1_text')); ?></p>
                            </div>

                            <div class="positions-offers col-12 col-xl-10">
                                <!--<h2 class="positions-offers__title">Oferty pracy</h2>-->

                                <?php
                                if (empty($offers)) {
                                    echo '<p class="positions-offers__info">Brak aktualnie ofert</p>';
                                } else {
                                    echo '<a href="'.esc_url(get_term_link($termSlug, 'offercategory')).'" class="positions-offers__btn-more btn btn-primary">Sprawdź aktualne oferty pracy</a>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <div class="employment-offers__media col-12 col-md-5 col-lg-6 order-1">

                        <?php
                        $video1 = $optionsHelper->get('offers::offers1_videoid');

                        if ($video1) :
                            ?><div class="employment-offers__media-container--video-wrapper">
                            <div class="employment-offers__media-container employment-offers__media-container--video">
                                <iframe class="employment-offers__medium employment-offers__medium--video video-fluid" src="https://www.youtube.com/embed/<?php echo $video1; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                            </div><?php
                        endif;
                        ?>

                    </div>

                </div>
            </div>
            </section><?php
        endif;
        ?>

        <?php
        $termSlug = $optionsHelper->get('offers::offers2_slug');

        if ($termSlug) :

            $offersArgs['tax_query'] = [
                [
                    'taxonomy' => 'offercategory',
                    'field'    => 'slug',
                    'terms'    => $termSlug,
                ]
            ];

            $offers = get_posts($offersArgs);

            ?><section class="employment-offers employment-offers--specialists">
            <div class="employment-offers__container container">
                <div class="employment-offers__row row">

                    <div class="employment-offers__content col-12 col-md-7 col-lg-6 order-2 order-md-1">
                        <div class="row justify-content-end">
                            <div class="employment-offers__offers-intro col-12 col-xl-10">
                                <h1 class="employment-offers__title"><?= $optionsHelper->get('offers::offers2_title'); ?></h1>
                                <p class="employment-offers__info"><?= wptexturize($optionsHelper->get('offers::offers2_text')); ?></p>
                            </div>

                            <div class="positions-offers col-12 col-xl-10">
                                <!--<h2 class="positions-offers__title">Oferty pracy</h2>-->

                                <?php
                                if (empty($offers)) {
                                    echo '<p class="positions-offers__info">Brak aktualnie ofert</p>';
                                } else {
                                    echo '<a href="'.esc_url(get_term_link($termSlug, 'offercategory')).'" class="positions-offers__btn-more btn btn-primary">Sprawdź aktualne oferty pracy</a>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <div class="employment-offers__media col-12 col-md-5 col-lg-6 order-1 order-md-2">

                        <?php
                        $video2 = $optionsHelper->get('offers::offers2_videoid');

                        if ($video2) :
                            ?><div class="employment-offers__media-container--video-wrapper">
                            <div class="employment-offers__media-container employment-offers__media-container--video">
                                <iframe class="employment-offers__medium employment-offers__medium--video video-fluid" src="https://www.youtube.com/embed/<?php echo $video2; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                            </div><?php
                        endif;
                        ?>

                    </div>

                </div>
            </div>
            </section><?php
        endif;
        ?>

        <?php
        $termSlug = $optionsHelper->get('offers::offers3_slug');

        if ($termSlug) :

            $offersArgs['tax_query'] = [
                [
                    'taxonomy' => 'offercategory',
                    'field'    => 'slug',
                    'terms'    => $termSlug,
                ]
            ];

            $offers = get_posts($offersArgs);

            ?><section class="employment-offers employment-offers--managers">
            <div class="employment-offers__container container">
                <div class="employment-offers__row row">

                    <div class="employment-offers__content col-12 col-md-7 col-lg-6 order-2">
                        <div class="row justify-content-end">
                            <div class="employment-offers__offers-intro col-12 col-xl-10">
                                <h1 class="employment-offers__title"><?= $optionsHelper->get('offers::offers3_title'); ?></h1>
                                <p class="employment-offers__info"><?= wptexturize($optionsHelper->get('offers::offers3_text')); ?></p>
                            </div>

                            <div class="positions-offers col-12 col-xl-10">
                                <!--<h2 class="positions-offers__title">Oferty pracy</h2>-->

                                <?php
                                if (empty($offers)) {
                                    echo '<p class="positions-offers__info">Brak aktualnie ofert</p>';
                                } else {
                                    echo '<a href="'.esc_url(get_term_link($termSlug, 'offercategory')).'" class="positions-offers__btn-more btn btn-primary">Sprawdź aktualne oferty pracy</a>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>

                    <div class="employment-offers__media col-12 col-md-5 col-lg-6 order-1">

                        <?php
                        $video3 = $optionsHelper->get('offers::offers3_videoid');

                        if ($video3) :
                            ?><div class="employment-offers__media-container--video-wrapper">
                            <div class="employment-offers__media-container employment-offers__media-container--video">
                                <iframe class="employment-offers__medium employment-offers__medium--video video-fluid" src="https://www.youtube.com/embed/<?php echo $video3; ?>?rel=0&amp;controls=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                            </div><?php
                        endif;
                        ?>

                    </div>

                </div>
            </div>
            </section><?php
        endif;
        ?>

    </section>

    <?php
    $query = new WP_Query([
        'post_type'      => 'post',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'category_name' => 'posty-kariera',
        'meta_query'     => [
            'relation' => 'OR',
            [
                'key'     => '_sd_hide_on_front',
                'value'   => 'on',
                'compare' => '!='
            ],
            [
                'key'     => '_sd_hide_on_front',
                'compare' => 'NOT EXISTS'
            ],
        ]
    ]);

    if ($query->have_posts()) :
        ?><section class="discover-dhl" id="discover">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <h1 class="discover-dhl__title"><?= $optionsHelper->get('front_discover::title'); ?></h1>
                    <p class="discover-dhl__text"><?= $optionsHelper->get('front_discover::text'); ?></p>
                </div>

            </div>
        </div>

        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="discover-dhl__carousel owl-carousel owl-theme" data-nav="1" data-owl-carousel="discover-articles">

                        <?php
                        while ($query->have_posts()) : $query->the_post();
                            ?><div class="discover-dhl__carousel-item owl-slide">
                            <article class="discover-dhl__article">
                                <a href="<?php the_permalink(); ?>" class="discover-dhl__article-link">
                                    <?php
                                    $thumbnailID = get_post_meta(get_the_ID(), '_sd_recommendations_image_id', true);

                                    if (!$thumbnailID) {
                                        $thumbnailID = get_post_thumbnail_id(get_the_ID());
                                    }

                                    if ($thumbnailID) :
                                        ?><img src="<?= esc_url(wp_get_attachment_image_url($thumbnailID, 'fp-slider-article')); ?>" alt="<?= esc_attr(get_the_title()) ?>" class="img-fluid discover-dhl__article-figure" /><?php
                                    endif;
                                    ?>

                                    <?php
                                    $terms = get_the_terms(get_the_ID(), 'category');

                                    if ($terms && $terms[0]->name !== 'posty kariera') :
                                        ?><small class="tag"><?php echo $terms[0]->name; ?></small><?php
                                    elseif (count($terms) > 1):
                                        ?><small class="tag"><?php echo $terms[1]->name; ?></small><?php
                                    endif;
                                    ?>

                                    <div class="discover-dhl__article-content">
                                        <h3 class="discover-dhl__article-header"><?php the_title(); ?></h3>
                                        <div class="discover-dhl__article-excerpt"><?php Tags\theExcerpt(null, '&hellip;', 16); ?></div>
                                    </div>
                                </a>
                            </article>
                            </div><?php
                        endwhile;

                        wp_reset_postdata();
                        ?>

                    </div>
                </div>

            </div>
        </div>
        </section><?php
    endif;

endif;
