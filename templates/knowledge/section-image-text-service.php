<?php
$section_img_url = null;
$section_img_alt = null;
$section_classes =  "col-lg-10 text-center";

if (get_field('image_text__picture')) {
    $section_img_url = esc_url(get_field('image_text__picture')['url']);
    $section_img_alt = esc_attr(get_field('image_text__picture')['alt']);
    $section_classes =  "col-12 col-md-7 order-1 order-lg-2";
}

$section_title = get_field('image_text__title');
$section_desc = get_field('image_text__desc');

?>

<section class="section__text-image-service col-md-12 col-lg-10 mx-auto mb-5 pb-5">
    <div class="container pb-lg-4">
        <div class="row align-items-center justify-content-center">
            <?php if ($section_img_url) { ?>
                <div class="col-12 col-md-5 order-2 order-lg-1 d-flex justify-content-center">
                    <img class="img-fluid" src="<?php echo $section_img_url ?>"
                         alt="<?php echo $section_img_alt ?>">
                </div>
            <?php } ?>
            <div class="<?php echo $section_classes ?>">
                <h2 class="font__title--022 font__color--gray text-uppercase d-block mb-4"><?php echo $section_title ?></h2>
                <p class="font__subtitle--00022"><?php echo $section_desc ?></p>
            </div>
        </div>
    </div>
</section>
