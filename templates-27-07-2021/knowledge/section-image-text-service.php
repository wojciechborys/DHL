<?php

?>

<section class="section__text-image-service col-md-12 col-lg-10 mx-auto mb-5 pb-5">
    <div class="container pb-lg-4">
        <div class="row align-items-center justify-content-center">
            <div class="col-12 col-md-5 order-2 order-lg-1 d-flex justify-content-center">
                <img class="img-fluid" src="<?php echo esc_url(get_field('image_text__picture')['url']); ?>"
                     alt="<?php echo esc_attr(get_field('image_text__picture')['alt']); ?>">
            </div>
            <div class="col-12 col-md-7 order-1 order-lg-2">
                <h2 class="font__title--022 font__color--gray text-uppercase d-block mb-4"><?php the_field('image_text__title'); ?></h2>
                <p class="font__subtitle--00022"><?php the_field('image_text__desc'); ?></p>
            </div>
        </div>
    </div>
</section>
