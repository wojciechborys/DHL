<?php

use MintMedia\PolylangT9n\Polylang;

$id = get_the_ID();
if (is_tax()) {
    $id = get_queried_object();
}
?>
<?php if (get_field('newsletter__enable', $id)) :
    $title = get_field('newsletter__title', 'option');
    $text = get_field('newsletter__text', 'option');
    $rules = get_field('newsletter__rules', 'option');
    $background_left = get_field('newsletter__background-color', 'option');
    $background_right = get_field('newsletter__image-right', 'option');
    ?>
    <section class="newsletter_form bg__color--gray-light d-flex align-items-center pt-4 pb-4 pt-sm-0 pb-sm-0" style="background-color: <?php echo $background_left; ?>; background-image: url(<?php echo esc_url($background_right); ?>);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <span class="font__title--022 font__color--gray text-uppercase d-block mb-3 text-center text-sm-left"><?php echo $title; ?></span>
                    <span class="font__subtitle--0222 d-block mb-4 text-center text-sm-left"><?php echo $text; ?></span>
                    <div class="newsletter_thx pb-4 d-none">
                        <span class="d-block font__color--green font__title--06 text-center text-sm-left"><?= Polylang\t9n('Dziękujemy za subskrybcję newslettera.'); ?></span>
                    </div>
                    <div class="newsletter_error pb-4 d-none">
                        <span class="d-block font__color--red font__title--06 text-center text-sm-left"><?= Polylang\t9n('Coś poszło nie tak.'); ?></span>
                    </div>
                    <form id="formNewsletter" action="" class="mt-1">
                        <div class="row">
                            <div class="col-12 col-sm-8 col-lg-7">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="<?= Polylang\t9n('Adres e-mail'); ?>">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 col-lg-5">
                                <div class="form-group">
                                    <button class="btn btn--auto btn--red btn-primary btn--calc d-block d-sm-inline-block"><?= Polylang\t9n('WYŚLIJ'); ?></button>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="rules" class="mt-2 form-check-label newsletter__label newsletter__label--checkbox">
                                    <input id="rules" type="checkbox" name="terms-consent" value="1" class="form-check-input newsletter__input newsletter__input--checkbox" data-newsletter-input="">
                                    <?php echo $rules; ?>
                                </label>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
