<?php
use MintMedia\PolylangT9n\Polylang;
?>

<div id="contact-us-form" class="contact-form container pt-5" data-form-container="contact-us">
    <div class="contact-form__wrapper" data-form-wrapper>
        <div class="contact-form__embed">
            <?php
            if (defined('MM_POLYLANG_ACTIVE') && MM_POLYLANG_ACTIVE && pll_current_language('slug') === 'en') :
                ?>
                <iframe class="contact-form__iframe" id="formularzIon" name="dhl-express-form-iframe" src="https://shipping.dhl.com.pl/international-shipping-for-business"></iframe>
            <?php
            else :
                ?>
                <iframe class="contact-form__iframe" id="formularzIon" name="dhl-express-form-iframe" src="https://shipping.dhl.com.pl/przesylki-miedzynarodowe-dla-firm-2/"></iframe>
            <?php
            endif;
            ?>

        </div>

        <div class="contact-form__btn-wrapper">
            <button class="btn btn-secondary btn--wide contact-form__submit" data-submit="<?php if (is_front_page()) : ?>contact<?php else : ?>toggle<?php endif; ?>"><?= Polylang\t9n('Wysyłaj taniej'); ?></button>
        </div>
    </div>
</div>
