<?php
$title = get_field('gogreen__section3_title');
$subtitle = get_field('gogreen__section3_subtitle');
$parallax_image = get_field('gogreen__section3_photo');
?>
<section class="section3">
    <div class="container-gogreen">
        <div class="jarallax ">
            <img class="jarallax-img" src="<?php echo $parallax_image['url']; ?>">
        </div>
        <div class="heading pb-4">
            <span class="heading__title font_gogreen--3"><?php echo $title; ?></span>
            <div class="heading__mark mb-5 mt-3 mb-md-4"></div>
            <span class="heading__subtitle font_gogreen--4"><?php echo $subtitle; ?></span>
        </div>
        <div class="section3__wrapper">
            <div class="row pt-5 mobile">
                <?php
                if (have_rows('gogreen__section3_blocks'));
                while (have_rows('gogreen__section3_blocks')) : the_row();
                    $image = get_sub_field('gogreen__section3_blocks-img');
                    $text = get_sub_field('gogreen__section3_blocks-text'); ?>
                    <div class="benefit col-lg-4">
                        <div class="benefit-img pb-3">
                            <img src="<?php echo $image['url']; ?>" alt="">
                        </div>
                        <div class="benefit-text font_gogreen--4"><?php echo $text; ?></div>
                    </div>
                <?php endwhile;
                ?>
            </div>
        </div>
    </div>
</section>