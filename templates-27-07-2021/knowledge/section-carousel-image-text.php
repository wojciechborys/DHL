<?php

?>
<?php if (have_rows('create_account__carousel')): ?>
    <section class="blog_category slider_image_text_container">
        <div class="container">
            <div class="row">
                <div class="slider slider-box col-12">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="row carousel-inner">
                            <?php $i = 0 ; while (have_rows('create_account__carousel')) : the_row(); ?>
                                <div class="carousel-item <?=( $i == 0 ) ? 'active' : ''; ?>">
                                    <div class="text-center text-md-left  col-12 col-md-3">
                                        <img class="carousel-img img-fluid" src="<?php echo esc_url((get_sub_field('image'))['url']); ?>"
                                             alt="<?php echo (get_sub_field('image'))['alt']; ?>">
                                    </div>
                                    <div class="text-center text-md-left col-12 offset-md-1 col-md-8">
                                        <span class="homeinfo--title d-block font__title--05 font__color--red text-center text-md-left d-block "><?php echo get_sub_field('title') ?></span>
                                        <span class="font__subtitle--0222 homeinfo--subtitle"><?php echo get_sub_field('description') ?></span>
                                    </div>
                                </div>
                                <?php $i++; endwhile; ?>
                            <ol class="carousel-indicators">
                                <?php $i = 0;
                                while (have_rows('create_account__carousel')) : the_row(); ?>
                                    <?php if ($i == 0) { ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>"
                                            class="active"></li>
                                    <?php } else { ?>
                                        <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo $i; ?>"></li>
                                    <?php } ?>
                                    <?php $i++;
                                endwhile; ?>
                            </ol>
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
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>