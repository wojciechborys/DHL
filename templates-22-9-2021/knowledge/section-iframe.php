<?php
use MintMedia\PolylangT9n\Polylang;

$url = get_field("iframe__url");

?>
<div class="container">
    <div class="row d-flex justify-content-center">
        <div class="col-12">
            <div id="contact-us-form" class="contact-form container pt-5" data-form-container="contact-us">
                <div class="contact-form__wrapper" data-form-wrapper>
                    <div class="contact-form__embed">
                        <iframe class="contact-form__iframe" id="formularzIon" name="dhl-express-form-iframe"
                                    src="<?php echo esc_url($url); ?>"></iframe>
                    </div>

                    <div class="contact-form__btn-wrapper">
                        <button class="btn btn-secondary btn--wide contact-form__submit"
                                data-submit="<?php if (is_front_page()) : ?>contact<?php else : ?>toggle<?php endif; ?>"><?= Polylang\t9n('Wysyłaj taniej'); ?></button>
                    </div>
                </div>
            </div>
            <div class="iframe-empty-space"></div>
        </div>
    </div>
</div>