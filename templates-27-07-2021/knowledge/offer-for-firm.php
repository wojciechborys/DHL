<?php

if (get_field('cta_link_other_kopia')) :
    $linkOther = get_field('cta_link_other');
    $link = $link = $linkOther['url'];
    $target = $linkOther['target'];

else :
    $link = get_field('cta_link_kopia');
    $target = '';
endif;
$cta_enable = get_field('cta_enable_kopia');
$buttonText = get_field('cta_button_text_kopia');
?>

<?php if ($cta_enable) : ?>
    <section>
        <div class="col-12 col-lg-6 mx-auto background_image--layer text-center d-flex flex-column align-items-center">
            <a href=href="<?php echo esc_url($link); ?>"
               class="btn btn--auto btn--red btn-primary btn--calc text-uppercase"
               style="margin-bottom: 40px"
               target="<?php echo $target; ?>">
                <?php echo $buttonText; ?>
            </a>
        </div>
    </section>
<?php endif; ?>