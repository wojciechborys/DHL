<?php

?>

<section class="article article--page">
    <div class="container">
        <div class="row align-items-center align-items-lg-start">
            <div class="col-12 col-md-6 order-2 order-lg-1">
                <img class="img-fluid" src="<?php echo esc_url(get_field('image_text__picture')['url']); ?>"
                     alt="<?php echo esc_attr(get_field('image_text__picture')['alt']); ?>">
            </div>
            <div class="col-12 col-md-6 order-1 order-lg-2">
                <h2><?php the_field('image_text__title'); ?></h2>
                <?php the_field('image_text__desc'); ?>
            </div>
        </div>
    </div>
</section>
