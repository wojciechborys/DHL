<?php
$section_title = get_field('title_text_brands__title');
$section_desc = get_field('title_text_brands__desc');
$section_images = get_field('title_text_brands__images');
$section_enable = get_field('title_text_brands__enable');

?>

<?php if ($section_enable && ($section_title || $section_desc || $section_images)) { ?>
    <section class="section-title-text-brands-service col-md-12 col-lg-10 mx-auto mb-5">
        <div class="container pb-lg-4">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10 text-center">
                    <h2 class="font__title--022 font__color--gray text-uppercase d-block mb-4"><?php echo $section_title ?></h2>
                    <p class="font__subtitle--00022"><?php echo $section_desc ?></p>
                    <div class="brands-service">
                        <?php for ($i = 0; $i < count($section_images); $i++) : ?>
                            <img src="<?php echo $section_images[$i]['url']; ?>" alt="<?php echo $section_images[$i]['alt']; ?>"/>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php } ?>