<?php

?>

<div class="container our-partners text-center mb-5 pb-lg-5">
    <h2 class="popular_questions--title font__title--022 font__color--gray text-center text-uppercase d-block"><?php echo get_field("ourpartners__title"); ?></h2>
    <div class="row justify-content-center align-items-start pt-lg-4">
        <?php if (have_rows('ourpartners__icons')): ?>
            <?php while (have_rows('ourpartners__icons')) : the_row(); ?>
                <div class="our-partners__col px-3 d-flex flex-column align-items-center justify-content-center">
                    <img class="img-fluid our-partners__col__icon" src="<?php echo esc_url(get_sub_field('icon')['url']); ?>"
                         alt="<?php echo esc_attr(get_sub_field('icon')['alt']); ?>">
                    <p class="our-partners__col__text"><?php echo get_sub_field('text'); ?></p>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>
