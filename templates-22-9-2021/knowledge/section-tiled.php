<?php

$title = get_field('tiled__title');
?>
<section class="blog_category">
    <?php if (get_field('tiled__enable')) : ?>
        <div class="container">
            <h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-5"><?php echo $title; ?></h1>
        </div>
    <?php endif; ?>
    <div class="container">
        <div class="row">
            <?php if (have_rows('tileds__repeater')):
                while (have_rows('tileds__repeater')) :
                    the_row(); ?>
                    <div class="col-12 col-sm-6 col-lg-3">
                        <a class="blog_category--link h-100 d-flex" href="<?php echo esc_url(get_sub_field('link')); ?>">
                            <div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
                                <div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
                                    <img src="<?php echo esc_url((get_sub_field('ikona'))['url']); ?>"
                                         alt="<?php echo (get_sub_field('ikona'))['alt']; ?>">
                                </div>
                                <hr>
                                <div class="blog_category--name" style="flex: 1">
                                    <div class="d-flex flex-column justify-content-between">
                                        <div style="min-height: 110px">
                                            <span class="font__title--06 font__title--06--1 mb-1 mt-4 d-block font__color--red text-uppercase"><?php echo get_sub_field('text_1') ?></span>
                                            <span class="font__title--05 text-uppercase font__color--gray"><?php echo get_sub_field('text_2') ?></span>
                                        </div>
                                        <div class="pt-3">
                                            <span class="font__color--gray font__subtitle--0222" > <?php echo get_sub_field('text_3')?> </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile;
            endif; ?>
        </div>
    </div>
</section>