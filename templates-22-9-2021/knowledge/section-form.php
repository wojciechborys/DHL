<?php
use MintMedia\PolylangT9n\Polylang;
use Roots\Sage\Assets;
?>

<section class="container form-partner pt-lg-5 pb-lg-5 mb-5">
    <h2 class="font__title--022 font__color--gray text-center text-uppercase d-block mb-3"><?php echo get_field("form__title"); ?></h2>
    <div class="form-partner__text font__subtitle--02 mb-5"><?php echo get_field("form__text"); ?></div>
    <div class="row">
        <div class="col-12 col-lg-8 mx-auto mt-lg-4">
            <div class="contact__form--thanks text-center d-none align-items-stretch justify-content-center">
                <div class="align-self-center">
                    <img class="contact__form--thanks--img"
                         src="<?= esc_url(Assets\asset_path('images/thanks_form.png', 'asset-sources/dhlknowledge/dist')); ?>"
                         alt="">
                    <div class="font__title--02 font__color--gray mt-4 font__lh--53"><?= Polylang\t9n('Dziękujemy'); ?>
                        <br><?= Polylang\t9n('za
                                    wypełnienie formularza'); ?>
                    </div>
                    <div class="font__subtitle--0222 font__color--gray mt-3"><?= Polylang\t9n('W ciągu 1 dnia roboczego skontaktuje się z Tobą przedstawiciel DHL Express'); ?>
                    </div>
                </div>
            </div>
            <form action="" id="partnerForm">
                <div id="ripple-main" class="lds-ripple">
                    <div></div>
                    <div></div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="company"><?= Polylang\t9n('Nazwa firmy'); ?>*</label>
                            <input type="text" class="form-control" id="company" name="company"
                                   placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="street"><?= Polylang\t9n('Ulica i numer budynku'); ?>*</label>
                            <input type="text" class="form-control" id="street" name="street"
                                   placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="post_code"><?= Polylang\t9n('Kod pocztowy'); ?>*</label>
                            <input type="text" class="form-control" name="post_code" id="post_code"
                                   placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="city"><?= Polylang\t9n('Miasto'); ?>
                                *</label>
                            <input type="text" class="form-control" name="city" id="city"
                                   placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block"
                                   for="profil"><?= Polylang\t9n('Profil działalności'); ?></label>
                            <select name="profil" id="profil" class="form-control">
                                <option value="Wybierz"><?= Polylang\t9n('Wybierz'); ?></option>
                                <option value="Handel"><?= Polylang\t9n('Handel'); ?></option>
                                <option value="Usługi"><?= Polylang\t9n('Usługi'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="shopwindow"><?= Polylang\t9n('Witryna widoczna z ulicy'); ?>
                                *</label>
                            <select name="shopwindow" id="shopwindow" class="form-control">
                                <option value=""><?= Polylang\t9n('Wybierz'); ?></option>
                                <option value="TAK"><?= Polylang\t9n('TAK'); ?></option>
                                <option value="NIE"><?= Polylang\t9n('NIE'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="name"><?= Polylang\t9n('Imię i nazwisko'); ?>
                                *</label>
                            <input type="text" class="form-control" name="name" id="name"
                                   placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="phone"><?= Polylang\t9n('Numer telefonu'); ?>
                                *</label>
                            <input type="phone" class="form-control" name="phone" id="phone"
                                   placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label class="d-block" for="email"><?= Polylang\t9n('Adres e-mail'); ?>
                                *</label>
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn--auto btn--red btn-primary btn--calc form-partner-send"><?= Polylang\t9n('WYŚLIJ'); ?>
                        </button>
                    </div>
                </div>
                <div class="contact_error col-lg-12 pl-0 d-none">
                    <span class="d-block font__color--red font__title--06 text-center text-sm-left"><?= Polylang\t9n('Wystąpił błąd, spróbuj ponownie później.'); ?></span>
                </div>
                <div class="font__subtitle--05 mt-4 text-center">
                    <?php echo get_field('from__bottom__text'); ?>
                </div>
            </form>
        </div>
    </div>
</section>
