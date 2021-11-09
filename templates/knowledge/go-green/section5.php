<?php
$title = get_field('gogreen__section5_title');
$cloud_text = get_field('gogreen__section5_clouds_text');
$cloud_bg = get_field('gogreen__section5_clouds_bg');
?>

<section class="section5">
    <div class="container-gogreen">
        <div class="trigger1"></div>
        <div class="clouds d-flex align-items-center" style="background-image: url('<?php echo $cloud_bg['url']; ?>')">
            <div class="clouds__text">
                <?php echo $cloud_text;?>
                <div class="heading__mark mb-5 mt-3 mb-md-4"></div>
            </div>
            <div class="clouds__cloud-1"></div>
            <div class="clouds__cloud-2"></div>
            <div class="clouds__cloud-3"></div>
            <div class="clouds__cloud-4"></div>
            <div class="clouds__cloud-5"></div>
            <div class="clouds__cloud-6"></div>
        </div>
        <div class="heading pb-4 pb-lg-0 pb-md-0">
            <span class="heading__title font_gogreen--3"><?php echo $title; ?></span>
            <div class="heading__mark mt-3"></div>
        </div>
        <div class="section5__wrapper">
            <div class="row pt-5 mobile">
                <?php
                if (have_rows('gogreen__section5_blocks'));
                while (have_rows('gogreen__section5_blocks')) : the_row();
                    $image = get_sub_field('gogreen__section5_blocks-img');
                    $text = get_sub_field('gogreen__section5_blocks-text'); ?>
                    <div class="benefit col-lg-4 px-4 px-lg-0">
                        <div class="benefit-img pb-3">
                            <img src="<?php echo $image['url']; ?>" alt="">
                        </div>
                        <div class="benefit-text font_gogreen--4"><?php echo $text; ?></div>
                    </div>
                <?php endwhile;
                ?>
            </div>
            <div class="trigger2"></div>
        </div>
</section>