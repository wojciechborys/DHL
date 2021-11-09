<?php

$image = get_field('cta_background_image');
$title = get_field('cta_title');
$text = get_field('cta_text');
if (get_field('cta_link_other')) :
    $linkOther = get_field('cta_link_other');
    $link = $linkOther['url'];
    $target = $linkOther['target'];
else :
    $link = get_field('cta_link');
    $target = '';
endif;

$buttonText = get_field('cta_button_text');
$cta_enable = get_field('cta_enable');
?>
<?php if ($cta_enable) : ?>
    <section class="container mt-5 px-2">
        <div style="background-image: url(<?php echo esc_url($image['url']); ?>" class="section__cta">
            <div class="col-12 col-lg-6 mx-auto background_image--layer text-center d-flex flex-column align-items-center">
                <h4 class="background_image--title font__title--01 font__color--white d-block"><?php echo $title; ?></h4>
                <p class="background_image--subtitle font__subtitle--022 font__color--white"><?php echo $text; ?></p>
                <?php if ($buttonText != "") : ?>
                    <a href="<?php echo esc_url($link); ?>"
                       class="btn btn--auto btn--red btn-primary btn--calc text-uppercase" target="<?php echo $target; ?>"><?php echo $buttonText; ?></a>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>