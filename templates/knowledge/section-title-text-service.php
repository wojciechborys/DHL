<?php
$section1_title = get_field('title_text__title');
$section1_desc = get_field('title_text__desc');
$section1_enable = get_field('title_text__enable');

?>

<?php if ($section1_enable && ($section1_title || $section1_desc)) { ?>
    <section class="section__text-image-service col-md-12 col-lg-10 mx-auto mb-5 pb-5">
        <div class="container pb-lg-4">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-10 text-center">
                    <h2 class="font__title--022 font__color--gray text-uppercase d-block mb-4"><?php echo $section1_title ?></h2>
                    <p class="font__subtitle--00022"><?php echo $section1_desc ?></p>
                </div>
            </div>
        </div>
    </section>
<?php } ?>