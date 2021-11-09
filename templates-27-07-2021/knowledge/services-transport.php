<?php

$title = get_field('services_transport__title');
$text = get_field('services_transport__text');
$id = get_field('services_transport__ID');
?>

<section class="services_table">
    <div class="container">
        <span id="<?php echo $id; ?>" class="font__title--04 font__color--red text-uppercase d-block text-center text-sm-left mb-3"><?php echo $title; ?></span>
        <span class="font__subtitle--16-2 d-block mb-4"><?php echo $text; ?></span>

        <div class="row justify-content-md-center justify-content-lg-start">
            <?php if (have_rows('services_transport__repeat')):
                while (have_rows('services_transport__repeat')) : the_row(); ?>
                    <div class="col-12 col-md-6 col-lg-4 pt-1">
                        <div class="services_table--item">
                            <h4 class="font__title--04 text-center font__color--gray text-uppercase"><?php echo get_sub_field('title') ?></h4>
                            <p class="font__subtitle--0222 mb-4 text-center"><?php echo get_sub_field('text') ?></p>
                            <hr>
                            <?php if (have_rows('list')): ?>
                                <ul class="services_table--list">
                                    <?php while (have_rows('list')) : the_row(); ?>
                                        <li class="services_table--list-item font__subtitle--16-2"><?php echo get_sub_field('text') ?></li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                            <div class="services_table--btn text-center">
                                <?php
                                $button = get_sub_field('button');
                                if ($button):
                                    echo '<a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase" href="'.esc_url($button['url']).'" target="'.$button['target'].'">'.$button['title'].'</a>';
                                endif;
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile;
            endif; ?>

        </div>
    </div>
</section>