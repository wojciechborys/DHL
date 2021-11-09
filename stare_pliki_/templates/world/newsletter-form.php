<?php
use SD\Restricted;

if (!isset($inSidebar)) {
    $inSidebar = false;
}
?>

<div class="row">
    <div class="col newsletter">

        <div class="newsletter__step newsletter__step--1 newsletter__step--current" data-newsletter-step="1">
            <form id="lead-form">
                <input type="hidden" name="related-post" value="<?= (is_single() && !Restricted\hasAccess(get_queried_object_id()) ? get_queried_object_id() : '0'); ?>" />

                <div class="row justify-content-center">
                    <div class="col-12<?php if (!$inSidebar) : ?> col-lg-10 col-xl-9<?php endif; ?>">
                        <h3 class="header header--size2">Wartościowe treści dostarczane do&nbsp;Ciebie</h3>

                        <p class="newsletter__text">Szukasz pomocnych i&nbsp;ciekawych treści z&nbsp;obszaru e-commerce, biznesu, logistyki?<br />
                            Zamów je&nbsp;prosto na&nbsp;e-mail.</p>
                    </div>

                    <div class="col-12">

                        <div class="row justify-content-center newsletter__form-row">
                            <div class="col-12 col-sm-10 <?php if ($inSidebar) : ?>col-md-11 col-lg-9<?php else : ?>col-lg-4 col-xl-3<?php endif; ?>">
                                <input type="text" name="name" class="form-control newsletter__input newsletter__input--text" placeholder="Imię" data-newsletter-input />
                            </div>

                            <div class="col-12 col-sm-10 <?php if ($inSidebar) : ?>col-md-11 col-lg-9<?php else : ?>col-lg-4 col-xl-3<?php endif; ?>">
                                <input type="text" name="email" class="form-control newsletter__input newsletter__input--text newsletter__input--email" placeholder="Adres e-mail" data-newsletter-input />
                            </div>
                        </div>

                        <div class="row justify-content-center newsletter__form-row">
                            <div class="col-12 col-sm-10 <?php if ($inSidebar) : ?>col-md-11 col-lg-9<?php else: ?>col-md-10 col-lg-8 col-xl-6<?php endif; ?>">
                                <label for="newsletterTermsConsent" class="form-check-label newsletter__label newsletter__label--checkbox"><input id="newsletterTermsConsent" type="checkbox" name="terms-consent" value="tak" class="form-check-input newsletter__input newsletter__input--checkbox" data-newsletter-input /> Tak, zapoznałem się z <a href="<?= home_url('regulamin-uslugi-newsletter'); ?>" target="_blank">Regulaminem</a>. Akceptuję jego treść i chcę otrzymywać aktualne informacje i materiały premium.
                                </label>
                            </div>
                        </div>

                        <div class="row justify-content-center newsletter__form-row">
                            <div class="col-12 col-sm-10 <?php if ($inSidebar) : ?>col-md-11 col-lg-9<?php else: ?>col-md-10 col-lg-5 col-xl-3<?php endif; ?>">
                                <button class="btn btn-primary newsletter__btn" data-access-submit>Zamawiam Newsletter</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>

        <div class="newsletter__step newsletter__step--2 newsletter__step--next" data-newsletter-step="2">
            <div class="row justify-content-center">

                <?php
                if ($inSidebar) :
                    ?><div class="col-12">
                    <h3 class="header header--size2">Dziękujemy za rejestrację!</h3>
                </div>

                <div class="col-12">

                    <span class="newsletter__tick"></span>

                </div>

                <div class="col-12">
                    <p class="newsletter__text">Nasze wiadomości wysyłane są z&nbsp;adresu: poland@dhl-news.com. Sprawdź swoją skrzynkę odbiorczą.</p>
                </div><?php

                else :

                    ?><div class="col-12">
                    <h3 class="header header--size2">Dziękujemy za rejestrację!</h3>
                </div>

                <div class="col-12">
                    <span class="newsletter__tick"></span>
                </div>

                <div class="col-12 col-md-10 col-lg-7 col-xl-5">
                    <p class="newsletter__text newsletter__text--tyinfo">Nasze wiadomości wysyłane są z&nbsp;adresu: poland@dhl-news.com.<br />
                        Sprawdź swoją skrzynkę odbiorczą.</p>

                </div><?php
                endif;
                ?>

            </div>
        </div>

    </div>
</div>
