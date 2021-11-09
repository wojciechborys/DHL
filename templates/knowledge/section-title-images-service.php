<?php
$section_title = get_field('title_title_8__title');
$section_images = get_field('title_title_8__images');
$section_enable = get_field('title_title_8__enable');

?>

<?php if ($section_enable && ($section_title || $section_images)) { ?>
    <section class="section-title-images-service col-md-12 col-lg-10 mx-auto mb-5 pb-5">
        <div class="container pb-lg-4">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10 text-center">
                    <h2 class="font__title--022 font__color--gray text-uppercase d-block mb-4 mb-md-5 pb-md-3"><?php echo $section_title ?></h2>
                    <div class="items-images-title-service">
                        <?php if ($section_images) { for ($i = 0; $i < count($section_images); $i++) : ?>
                        <div class="items-images-title-service__item">
                            <div class="items-images-title-service__image">
                                <img src="<?php echo $section_images[$i]['item_icon']['url']; ?>" alt="<?php echo $section_images[$i]['item_icon']['alt']; ?>"/>
                            </div>
                            <h5 class="font__color--gray font__subtitle--0222"><?php echo $section_images[$i]['item_title']; ?></h5>
                        </div>
                        <?php endfor; } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>