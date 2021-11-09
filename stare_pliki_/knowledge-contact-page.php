<?php

/**
 * Template name: [Baza wiedzy] Kontakt
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>
<?php


?>

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/knowledge/header-new'); ?>
    <section class="">
        <div class="container">
            <div class="row">
                <div class="col-lg-5">
                    <div class="shortcuts">
                        <?php
                        if (have_rows('contact__form--accordeon')): while (have_rows('contact__form--accordeon')) :
                            the_row();
                            ?>
                            <span class="shortcuts--title d-block font__title--03 font__color--gray"><?php echo get_sub_field('accordeon__title') ?></span>
                            <div class="accordion contact" id="contactAccordion">
                                <?php
                                if (have_rows('acordeon')):
                                    $i = 1;
                                    while (have_rows('acordeon')) :
                                        the_row();

                                        ?>
                                        <div class="card">
                                            <div class="card-header bg__color--gray-light"
                                                 id="heading<?php echo $i; ?>">
                                                <h2 class="mb-0">
                                                    <button class="card-header--btn btn btn-link d-block font__title--04 font__color--gray2 collapsed"
                                                            type="button" data-toggle="collapse"
                                                            data-target="#collapse<?php echo $i; ?>"
                                                            aria-expanded="false"
                                                            aria-controls="collapse<?php echo $i; ?>">
                                                          <span class="card-header--imgContainer d-flex align-items-stretch justify-content-center">
                                                            <img class="card-header--img align-self-center"
                                                                 src="<?php echo (get_sub_field('ico'))['url']; ?>"
                                                                 alt="<?php echo (get_sub_field('ico'))['alt']; ?>">
                                                          </span>
                                                        <?php echo get_sub_field('title'); ?>
                                                    </button>
                                                </h2>
                                            </div>
                                            <div id="collapse<?php echo $i; ?>" class="collapse bg__color--gray-light"
                                                 aria-labelledby="heading<?php echo $i; ?>"
                                                 data-parent="#contactAccordion">
                                                <div class="card-body font__subtitle--16">
                                                    <?php echo get_sub_field('desc'); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                        $i++;
                                    endwhile;
                                endif; ?>
                            </div>
                        <?php endwhile;
                        endif;
                        ?>
                    </div>
                </div>
                <?php
                $contact_form = get_field('contact__form--form', get_the_ID());
                ?>
                <div id="contactF" class="col-lg-7 contact__form">
                    <div class="pl-lg-5 ml-lg-4 contact__form--border">
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
                        <span class="contact__form--title font__title--03 d-block font__color--gray"><?php echo $contact_form['form__title']; ?></span>
                        <form action="" id="contact-new">
                            <div id="ripple-main" class="lds-ripple">
                                <div></div>
                                <div></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="d-block" for="name"><?= Polylang\t9n('Imię'); ?>*</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="d-block" for="surname"><?= Polylang\t9n('Nazwisko'); ?>*</label>
                                        <input type="text" class="form-control" id="surname" name="surname"
                                               placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="d-block" for="email">Email*</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                               placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="d-block" for="phone"><?= Polylang\t9n('Numer telefonu'); ?>
                                            *</label>
                                        <input type="text" class="form-control" name="phone" id="phone"
                                               placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="d-block"
                                               for="subject_recipient"><?= Polylang\t9n('Temat zgłoszenia'); ?></label>
                                        <select name="subject_recipient" id="subject_recipient" class="form-control">
                                            <option value="Wybierz temat"><?= Polylang\t9n('Wybierz temat'); ?></option>
                                            <?php
                                            foreach ($contact_form['form__subject_recipient'] as $single):
                                                ?>
                                                <option value="<?php echo $single['temat']; ?>"
                                                        data-display-additional-input="<?php echo ($single['tracking-number-display']) ? 1 : 0; ?>"
                                                        data-recipment="<?php echo $single['recipient']; ?>"><?php echo $single['temat']; ?></option>
                                                <?php
                                            endforeach;
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12 recipment-container d-none">
                                    <div class="form-group">
                                        <label class="d-block" for="recipment-email">Email</label>
                                        <input type="text" class="form-control" name="recipment-email"
                                               id="recipment-email" placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12 tracking-number-container d-none">
                                    <div class="form-group">
                                        <label class="d-block"
                                               for="tracking_number"><?= Polylang\t9n('Numer przesyłki'); ?></label>
                                        <input type="text" class="form-control" name="tracking-number"
                                               id="tracking-number"
                                               placeholder="<?= Polylang\t9n('Wpisz'); ?>">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="d-block" for="message"><?= Polylang\t9n('Wiadomość'); ?></label>
                                        <textarea name="message" id="message" class="form-control" rows="5"
                                                  placeholder="<?= Polylang\t9n('Wpisz'); ?>"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="d-block" for="file_contact">
                                            <?= Polylang\t9n('Załącz plik (maksymalny rozmiar pliku 8MB)'); ?>
                                        </label>
                                        <div class="error--file font__color--red">
                                        </div>
                                        <input type="file" id="file_contact" name="file_contact"
                                               class="input input--text" accept="image/png, image/jpeg, .pdf, .doc">
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-1 text-center text-md-right">
                                    <button class="btn btn--auto btn--red btn-primary btn--calc form-new-send"><?= Polylang\t9n('WYŚLIJ'); ?>
                                    </button>
                                </div>
                            </div>
                            <div class="contact_error col-lg-12 pl-0 d-none">
                                <span class="d-block font__color--red font__title--06 text-center text-sm-left"><?= Polylang\t9n('Wystąpił błąd, spróbuj ponownie później.'); ?></span>
                            </div>
                            <div class="font__subtitle--05 mt-4 text-justify">   <?php
                                echo $contact_form['clause'];
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="call_us">
        <div class="container pt-4">
            <hr>
            <span class="call_us--title font__title--02 font__color--gray text-center d-block"><?php echo get_field('call-to-us-title', get_the_ID()); ?></span>
            <div class="row">
                <?php
                if (have_rows('call-to-us')):
                    while (have_rows('call-to-us')) : the_row();
                        $group = get_sub_field('group-of-contacts'); ?>
                        <div class="col-lg-6">
                            <div class="call_us--item el__corner el__shadow el__border mb-4 mb-lg-0">
                                <div class="row">
                                    <div class="col-md-4 text-center">
                                        <img src="<?php echo $group['ico']['url']; ?>"
                                             alt="<?php echo $group['ico']['alt']; ?>">
                                    </div>
                                    <div class="col-md-8 text-center text-md-left">
                                        <span class="font__title--05 font__color--red d-block mb-2 mt-3 mt-md-0"><?php echo $group['title']; ?></span>
                                        <?php $i = 0;
                                        foreach ($group['aditional'] as $single): ?>
                                            <?php
                                            $class = "font__subtitle--03";
                                            if ($i === 0) {
                                                $class = "font__subtitle--011 mb-1";
                                            } else if ($i === 1) {
                                                $class = "font__subtitle--0222";
                                            }
                                            ?>
                                            <span class="d-block <?php echo $class; ?>"><?php echo strip_tags($single['text']); ?></span>
                                            <?php $i++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>
    <section class="hotline_diagram">
        <div class="container">
            <div class="bg__color--light-gray text-center">
                <span class="hotline_diagram--title text-center font__title--05 font__color--red d-block"><?php echo get_field('schema__title', get_the_ID()); ?></span>
                <div class="d-flex align-content-center justify-content-center flex-wrap">
                    <?php

                    // check if the repeater field has rows of data
                    $x = 1;
                    if (have_rows('schema__uitems')):

                        // loop through the rows of data
                        while (have_rows('schema__uitems')) : the_row();

                            ?>
                            <div class="hotline_diagram--item w-20">
                                <div class="hotline_diagram--item_counter font__color--yellow d-inline-block mx-auto font__subtitle--011"><?php echo $x; ?></div>
                                <span class="font__subtitle--02 d-block"> <?php echo get_sub_field('title'); ?></span>
                                <span class="font__subtitle--03"><?php echo get_sub_field('desc'); ?></span>
                            </div>
                            <?php
                            $x++;
                        endwhile;
                    endif;

                    ?>
                </div>
            </div>
        </div>
    </section>
    <section class="contact__box">
        <div class="container">
            <div class="row">
                <?php

                if (have_rows('contact_boxes')):

                    while (have_rows('contact_boxes')) : the_row();
                        $site = get_sub_field('site');
                        $ico = get_sub_field('ico');
                        ?>
                        <div class="col-md-4 ">
                            <a href="<?php echo $site['url']; ?>"
                               target="<?php echo $site['target'] ? $site['target'] : '_self' ?>"
                               class="contact__box--tile el__corner el__shadow el__border text-center d-block mb-4 mb-md-0">
                                <img class="contact__box--img" src="<?php echo $ico['url']; ?>"
                                     alt="<?php echo $ico['alt']; ?>">
                                <span class="font__title--05 font__color--red d-block pl-5 pl-md-0 pr-5 pr-md-0"><?php the_sub_field('title'); ?></span>
                            </a>
                        </div>
                        <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>
    <?php get_template_part('templates/knowledge/prefooter'); ?>
    <?php // get_template_part('templates/page', 'header'); ?>
    <?php // get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>