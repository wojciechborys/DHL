<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use SD\Template\Tags;
use SD\Options\OptionsHelper;

$optionsHelper = OptionsHelper::getInstance();
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/career/head'); ?>

<body <?php body_class(); ?>>
<!--[if IE]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->

<?php
do_action('get_header');
get_template_part('templates/career/header');
?>

<?php if (is_page('kariera')) : ?>
<div class="main-video-slider">
    <div class="owl-carousel owl-theme">
        <?php
        $loop = new WP_Query(['post_type' => 'wideo', 'posts_per_page' => -1]);

        if ($loop->have_posts()) :
            $count = 0;

            while ($loop->have_posts()): $loop->the_post();
                $slideID = get_the_ID();

                $slideType = get_post_meta($slideID, '_sd_slide_type', true);

                if ('image' === $slideType) {
                    $slideImageId = (int) get_post_meta($slideID, '_sd_slide_image_id', true);
                    $imageSrc = $slideImageId ? wp_get_attachment_image_src($slideImageId, 'full') : false;

                    $src = $imageSrc ? $imageSrc[0] : false;
                } else {
                    $src = trim(get_post_meta($slideID, '_sd_video_source', true));
                }

                if (empty($src)) {
                    continue;
                }
                ?>

                <div class="content-intro__item content-intro__item--<?= ('image' === $slideType ? 'image' : 'video'); ?>">
                    <div class="item-desc">
                        <h2 class="content-intro__header"><?php the_title(); ?></h2>
                        <p class="content-intro__info"><?php the_content(); ?></p>

                        <?php
                        $btnText = get_post_meta($slideID, '_sd_button_text', true);
                        $btnTarget = get_post_meta($slideID, '_sd_button_target', true);

                        if ('url' === $btnTarget) {
                            $btnUrl = get_post_meta($slideID, '_sd_button_url', true);
                            $btnUrl = $btnUrl ? esc_url($btnUrl) : '#';
                        } else {
                            $sectionId = get_post_meta($slideID, '_sd_button_section', true);
//                            $btnUrl = $sectionId ? home_url('/#'.$sectionId) : home_url('/');
                            $btnUrl = $sectionId ? '#'.$sectionId : home_url('/');
                        }

                        if ($btnText) :
                            ?><a href="<?= $btnUrl; ?>" class="btn btn-primary content-intro__btn" data-btn-slider="<?= esc_attr($btnTarget); ?>"><?= $btnText; ?></a><?php
                        endif;
                        ?>
                    </div>

                    <?php
                    if ('image' === $slideType) :

                        ?><div class="content-intro__slide-image-container">
                        <div class="content-intro__slide-image content-intro__slide-image--block" style="background-image:url('<?= esc_url($src); ?>');"></div>
                        <!-- <img src="<?= esc_url($src); ?>" class="img-fluid content-intro__slide-image" alt="<?= esc_attr(get_the_title()); ?>" /> -->
                        </div><?php

                    else :

                        $ytUrl = add_query_arg([
                            'feature' => 'oembed',
                            'enablejsapi' => '1',
                            'color' => 'white',
                            'controls' => '0',
                            'rel' => '0',
                            'showinfo' => '0',
                            // 'autoplay' => '1',
                            'loop' => '1',
                            // 'playlist' => get_post_meta(get_the_ID(), '_sd_video_source', true),
                            'mute' => '1',
                        ], 'https://www.youtube.com/embed/'.esc_attr($src));

                        ?><div class="content-intro__video-bg-container">
                        <div class="content-intro__video-bg-block">
                            <iframe src="<?= esc_url($ytUrl); ?>" frameborder="0" allowfullscreen data-yt-video></iframe>
                        </div>
                        </div><?php

                    endif;
                    ?>
                </div>
                <?php
                ++$count;
            endwhile;
        endif;

        wp_reset_postdata();
        ?>

    </div>
</div>
<?php endif; ?>


<div class="page-wrapper">

    <main class="wrap" role="document">
        <!-- <script type='text/javascript' src='http://skk.erecruiter.pl/Code.ashx?cfg=c011181169be4b8bb5c801f194741683'></script> -->
        <?php include Wrapper\template_path(); ?>

        <?php
        if(!is_tax('offercategory')) {
            Tags\prizesSection();
        }
        ?>

        <section id="contact-us" class="contact-form">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="contact-form__wrapper col-12 col-sm-11 col-md-9 col-lg-7 col-xl-6">
                        <h2 class="contact-form__header"><?= $optionsHelper->get('form::section_title'); ?></h2>
                        <?php //Tags\contactForm(); ?>

                        <div class="contact-form__morph-wrapper">
                            <a href="<?= esc_url($optionsHelper->get('form::url')); ?>" target="_blank" class="btn btn-primary contact-form__btn--morph"><?= $optionsHelper->get('form::btn_text'); ?></a>
                        </div>

                    </div>
                </div>
            </div>
        </section>

    </main><!-- /.wrap -->

</div>
<?php
do_action('get_footer');
get_template_part('templates/career/footer');
?>

<?php
wp_footer();
?>
</body>
</html>
