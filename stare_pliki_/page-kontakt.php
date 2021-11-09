<?php
/**
 * Template name: KONTAKT
 */

do_action('get_header');
get_template_part('templates/dhl_express_new/header-new');
?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <?php
            if (have_rows('contact__form--accordeon')): while (have_rows('contact__form--accordeon')) : the_row();
                ?>
                <h4><?php echo get_sub_field('accordeon__title') ?></h4>
                <?php
                if (have_rows('acordeon')): while (have_rows('acordeon')) : the_row();

                    ?>
                    <div class="">
                        <img src="<?php echo (get_sub_field('ico'))['url']; ?>"
                             alt="<?php echo (get_sub_field('ico'))['alt']; ?>">
                        <h5>
                            <?php echo get_sub_field('title'); ?>
                        </h5>
                        <p>
                            <?php echo get_sub_field('desc'); ?>
                        </p>
                    </div>
                <?php
                endwhile; endif;

            endwhile; endif;
            ?>
        </div>
        <div class="col-6">
            <?php
            $contact_form = get_field('contact__form--form', get_the_ID());
            ?>
            <h4>
                <?php
                echo $contact_form['form__title'];
                ?>
            </h4>
            <form id="contact-new" class="row">
                <div class="col-6">
                    <label for="name">Imię</label>
                    <input type="text" placeholder="Wpisz imię" id="surname" name="name">
                </div>
                <div class="col-6">
                    <label for="surname">Nazwisko</label>
                    <input type="text" id="surname" name="surname" placeholder="wpisz">
                </div>
                <div class="col-12">
                    <label for="email">E-mail*</label>
                    <input type="email" name="email" id="email" placeholder="wpisz">
                </div>
                <div class="col-12">
                    <label for="phone">Numer telefonu</label>
                    <input type="text" name="phone" id="phone" placeholder="wpisz">
                </div>

                <div class="col-12">
                    <label for="subject">Temat zgłoszenia</label>
                    <select name="subject_recipient" id="subject_recipient">
                        <option value="Wybierz temat">Wybierz temat</option>
                        <?php
                        foreach ($contact_form['form__subject_recipient'] as $single):
                            ?>
                            <option value="Wybierz temat"
                                    data-display-additional-input="<?php echo ($single['tracking-number-display']) ? 1 : 0; ?>"
                                    data-recipment="<?php echo $single['recipient']; ?>"><?php echo $single['temat']; ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="col-12 recipment-container d-none">
                    <input type="email" name="recipment-email" id="recipment-email" placeholder="wpisz">
                </div>
                <div class="col-12 tracking-number-container d-none">
                    <label for="tracking-number">Numer przesylki</label>
                    <input type="text" name="tracking-number" id="tracking-number" placeholder="wpisz">
                </div>
                <div class="col-12">
                    <label for="message">Wiadomość</label>
                    <input type="text" name="message" id="message" placeholder="wpisz">
                </div>
                <div class="col-12">
                    <a class="form-new-send">wyślij</a>
                </div>
                <div class="col-12">
                    <?php
                    echo $contact_form['clause'];
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="container call-to-us">
    <div class="row justify-content-center">
        <div class="col-12">
            <h3><?php echo get_field('call-to-us-title', get_the_ID()); ?></h3>
        </div>
        <?php
        if (have_rows('call-to-us')):
            while (have_rows('call-to-us')) : the_row();
                ?>
                <div class="col-12 col-md-6">
                    <?php
                    $group = get_sub_field('group-of-contacts'); ?>
                    <img src="<?php echo $group['ico']['url']; ?>" alt="<?php echo $group['ico']['alt']; ?>">
                    <div class="">
                        <h4><?php echo $group['title']; ?></h4>
                        <ul>
                            <?php foreach ($group['aditional'] as $single): ?>
                                <li>
                                    <?php echo $single['text'] ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            <?php
            endwhile;
        endif;
        ?>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <h4>
                <?php echo get_field('call-to-us-title', get_the_ID()); ?>
            </h4>
        </div>
        <?php

        // check if the repeater field has rows of data
        $x = 0;
        if (have_rows('schema__uitems')):

            // loop through the rows of data
            while (have_rows('schema__uitems')) : the_row();

                ?>
                <div class="col-12 col-sm-6 col-md-3 col-lg-2">
                    <p><?php echo $x; ?></p>
                    <h4>
                        <?php echo get_sub_field('title'); ?>
                    </h4>
                    <h5>
                        <?php echo get_sub_field('desc'); ?>
                    </h5>
                </div>
                <?php
                $x++;
            endwhile;
        endif;

        ?>
    </div>
</div>

<div class="container">
    <div class="row">
        <?php

        if (have_rows('contact_boxes')):

            while (have_rows('contact_boxes')) : the_row();
                $site = get_sub_field('site');
                $ico = get_sub_field('ico');
                ?>

                <div class="col-12 col-sm-6 col-md-4">
                    <a href="<?php echo $site['url']; ?>" class="d-block"
                       target="<?php echo $site['target'] ? $site['target'] : '_self' ?>">
                        <img src="<?php echo $ico['url']; ?>"
                             alt="<?php echo $ico['alt']; ?>">
                        <h5>
                            <?php the_sub_field('title'); ?>
                        </h5>
                    </a>
                </div>
            <?php
            endwhile;
        endif;
        ?>
    </div>
</div>
<?php
get_template_part('templates/dhl_express_new/prefooter');
get_template_part('templates/dhl_express_new/footer_bottom_first');
get_template_part('templates/dhl_express_new/footer_bottom_second');
?>
