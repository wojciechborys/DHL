<?php
$dh_express_ID = get_the_ID();
if (is_tax()) {
    $dh_express_ID = get_queried_object();
}
?>
<?php if (get_field('prefooter__enable', $dh_express_ID)) :

    $prefooter_bg = (get_field('prefooter_bg', $dh_express_ID) == "") ? get_field('prefooter_bg', 'option') : get_field('prefooter_bg', $dh_express_ID);
    $prefooter_bg_link = $prefooter_bg['url'];

    $button_link = (get_field('prefooter_button', $dh_express_ID) == '') ? get_field('prefooter_button', 'option') : get_field('prefooter_button', $dh_express_ID);
    $prefooter_button_title = $button_link['title'];
    $prefooter_button_link = $button_link['url'];
    $prefooter_button_target = $button_link['target'] ? $button_link['target'] : '_self';

    $title = (get_field('prefooter_title', $dh_express_ID) == '') ? get_field('prefooter_title', 'option') : get_field('prefooter_title', $dh_express_ID);
    $desc = (get_field('prefooter_desc', $dh_express_ID) == '') ? get_field('prefooter_desc', 'option') : get_field('prefooter_desc', $dh_express_ID);

    ?>

    <section class="background_image background_image--footer d-flex align-items-center"
             style="background-image: url('<?php echo $prefooter_bg_link ?>')">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 background_image--layer">
                    <span class="background_image--title font__title--01 font__color--white d-block"><?php echo $title; ?></span>
                    <p class="background_image--subtitle font__subtitle--022 font__color--white">  <?php echo $desc; ?></p>
                    <a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase"
                       href="<?php echo $prefooter_button_link; ?>"
                       target="<?php echo $prefooter_button_target; ?>"><?php echo $prefooter_button_title; ?></a>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
