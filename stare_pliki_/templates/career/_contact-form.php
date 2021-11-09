<?php
use SD\Options\OptionsHelper;

$optionsHelper = OptionsHelper::getInstance();
?>

<div class="contact-form__morph-wrapper" data-morph="wrapper">
    <a href="#contact-form" class="btn btn-primary contact-form__btn--morph" data-morph="button" data-contact-button><?= $optionsHelper->get('form::button_text'); ?></a>

    <div class="text-left contact-form__morph-content" data-morph="content">
        <div class="contact-form__morpher">
            <div class="contact-form__morph-close">
                <a class="contact-form__morph-close-btn" href="#" role="presentation" data-morph="close" data-noscroll>Zamknij</a>
            </div>

            <div id="contact-form" class="contact-form__form-wrapper" data-contact-form="form">

                <form id="contactform-form" action="<?php echo esc_url( get_permalink() ); ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="send-contact-mail" />
                    <div class="contact-form__form-container">

                        <div class="contact-form__main-row row justify-content-center">
                            <div class="contact-form__content col-12">

                                <h3 class="contact-form__form-header"><?= $optionsHelper->get('form::form_header'); ?></h3>

                                <div class="contact-form__row row justify-content-center">
                                    <label for="contactform_name" class="col-12 col-sm-10 col-lg-6 form-group contact-form__label contact-form__label--text contact-form__label--name">Imię
                                        <input name="name" id="contactform_name" class="form-control contact-form__input contact-form__input--text contact-form__input--textual contact-form__input--name" type="text" />
                                    </label>

                                    <label for="contactform_surname" class="col-12 col-sm-10 col-lg-6 form-group contact-form__label contact-form__label--text contact-form__label--surname">Nazwisko
                                        <input name="surname" id="contactform_surname" class="form-control contact-form__input contact-form__input--text contact-form__input--textual contact-form__input--surname" type="text" />
                                    </label>
                                </div>

                                <div class="contact-form__row row justify-content-center">
                                    <label for="contactform_phone" class="col-12 col-sm-10 col-lg-6 form-group contact-form__label contact-form__label--text contact-form__label--phone">Nr telefonu
                                        <input name="phone_no" id="contactform_phone" class="form-control contact-form__input contact-form__input--text contact-form__input--textual contact-form__input--hone" type="text" />
                                    </label>

                                    <label for="contactform_localization" class="col-12 col-sm-10 col-lg-6 form-group contact-form__label contact-form__label--text contact-form__label--localization">Lokalizacja
                                        <input name="localization" id="contactform_localization" class="form-control contact-form__input contact-form__input--text contact-form__input--textual contact-form__input--localization" type="text" />
                                    </label>
                                </div>

                                <div class="contact-form__row row justify-content-center">
                                    <div class="contact-form__input-group contact-form__input-group--file input-group col-12">
                                        <label class="contact-form__input-group-btn contact-form__input-group-btn--file input-group-btn">
                                            <span class="btn btn-primary">
                                                Dodaj plik <input type="file" name="document" accept="application/pdf,application/msword,image/jpeg" hidden />
                                            </span>
                                        </label>
                                        <input type="text" class="contact-form__input contact-form__input--text contact-form__input--textual contact-form__input--readonly contact-form__input--filename form-control" readonly>
                                    </div>
                                </div>

                                <div class="contact-form__row row justify-content-center">
                                    <div class="col-12 col-sm-10 col-lg-12 form-group">
                                        <div class="form-check">
                                            <?php
                                            $consentText = $optionsHelper->get('form::consent_text');
                                            ?>
                                            <input name="processing_consent" id="processing_consent" class="contact-form__input contact-form__input--checkbox contact-form__input--consent form-check-input" type="checkbox" value="<?= esc_attr($consentText); ?>" />
                                            <label for="processing_consent" class="contact-form__label contact-form__label--checkbox contact-form__label--consent form-check-label"><?= $consentText; ?></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="contact-form__row row justify-content-center">
                                    <div class="col-12 contact-form__btn-wrapper">
                                        <button type="submit" class="btn btn-secondary contact-form__btn contact-form__btn--submit contact-form__btn--confirm" data-submit="contact">Wyślij</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="contact-form__row row justify-content-center justify-content-center">
                        <div class="col-12 col-sm-10 col-md-8 col-lg-6 alert-message alert-message--reminder alert-message--no-message" data-form-message="wrapper">
                            <div class="alert-message__content" role="alert" data-form-message="message"></div>
                        </div>
                    </div>
                </form>

            </div>

            <div id="contactform-thanks" class="contact-form__thanks-wrapper contact-form__thanks-wrapper--hidden" data-contact-form="thankyou">
                <div class="contact-form__thanks">
                    <p class="contact-form__thanks-content"><?= $optionsHelper->get('form::thankyou_text'); ?></p>
                    <p class="contact-form__btn-wrapper">
                        <a href="#" class="btn btn-secondary contact-form__btn contact-form__btn--thanks contact-form__btn--confirm" data-thanks-confirm>OK</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>
