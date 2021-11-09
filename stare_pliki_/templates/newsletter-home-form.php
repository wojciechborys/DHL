<?php

use SD\Restricted;
use MintMedia\PolylangT9n\Polylang;

if ( ! isset($inSidebar)) {
    $inSidebar = false;
}
?>

<div class="col newsletter">
    <div class="newsletter__step newsletter__step--1 newsletter__step--current" data-newsletter-step="1">
        <form id="lead-form">
            <input type="hidden" name="related-post"
                   value="<?= (is_single() && ! Restricted\hasAccess(get_queried_object_id()) ? get_queried_object_id() : '0'); ?>"/>

            <div class="row">
                <div class="col-12 p-4">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="header header--size2"><?php echo Polylang\t9n('Zostaw swój adres email, na który otrzymasz informacje o promocjach i pomocne materiały.'); ?></h3>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-8">
                            <input type="text" name="email"
                                   class="form-control newsletter__input newsletter__input--text newsletter__input--email"
                                   placeholder="<?php echo Polylang\t9n('Adres e-mail'); ?>" data-newsletter-input/>
                        </div>
                        <div class="col-4 pl-0 d-flex">
                            <button class="btn btn-primary newsletter__btn" data-access-submit><?php echo Polylang\t9n('Wyślij'); ?></button>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <label for="newsletterTermsConsent"
                                   class="form-check-label newsletter__label newsletter__label--checkbox">
                                <input id="newsletterTermsConsent" type="checkbox" name="terms-consent" value="tak"
                                       class="form-check-input newsletter__input newsletter__input--checkbox"
                                       data-newsletter-input/>
                                <?php
                                    echo sprintf(
                                        '%s <a href="%s" target="_blank">%s</a>. %s.',
                                        Polylang\t9n('Tak, zapoznałem się z'),
                                        home_url('regulamin-uslugi-newsletter'),
                                        Polylang\t9n('Regulaminem'),
                                        Polylang\t9n('Akceptuję jego treść i chcę otrzymywać aktualne informacje i materiały premium')
                                    );
                                ?>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="newsletter__step newsletter__step--2 newsletter__step--next" data-newsletter-step="2">
        <div class="row">
            <div class="col-12 p-4">
                <div class="row">
                    <div class="col-12">
                        <h3 class="header header--size2">Dziękujemy za rejestrację!</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <span class="newsletter__tick"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="newsletter__text newsletter__text--tyinfo">Nasze wiadomości wysyłane są z&nbsp;adresu:
                            poland@dhl-news.com.<br/>
                            Sprawdź swoją skrzynkę odbiorczą.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
