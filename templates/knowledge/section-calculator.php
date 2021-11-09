<?php

use MintMedia\PolylangT9n\Polylang;
use MintMedia\ShipmentCalc\Helpers;
use Roots\Sage\Assets;

$trackingUrl = '';
$readdressUrl = '';
$formSlug = '';
if (pll_current_language() === 'pl') {
    $trackingUrl = 'https://www.logistics.dhl/pl-pl/home/tracking.html';
    $readdressUrl = 'https://delivery.dhl.com/prg/jsp/index.xhtml?ctrycode=PL';
    $formSlug = 'przesylki-miedzynarodowe-dla-firm';
} elseif (pll_current_language() === 'en') {
    $trackingUrl = 'https://www.logistics.dhl/global-en/home/tracking.html';
    $readdressUrl = 'https://delivery.dhl.com/prg/jsp/index.xhtml?ctrycode=EN';
    $formSlug = 'international-shipments-for-companies';
}

$repeater = get_field('calculator__packages', 'option');
$length = $repeater[0]['length'];
$height = $repeater[0]['height'];
$weight = $repeater[0]['weight'];
$width = $repeater[0]['width'];
?>

<section class="pt-lg-3 my-5 calculator__service" id="calculatorService">
    <div class="calculator__service__overlay">
    </div>
    <div class="calculator__service__loader">
    </div>
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-10 col-lg-10 col-xl-10 mx-auto">
                    <?php
                    $desc = get_field('calculator__desc');

                    $calculator_classes = 'mb-5 pb-0 pb-lg-4';

                    if ($desc) $calculator_classes = 'mb-4';
                    ?>
                    <h2 class="font__title--022 font__color--gray text-uppercase text-center d-block <?php echo $calculator_classes ?>">
                        <?php the_field('calculator__title'); ?>
                    </h2>
                    <?php if ($desc) { ?>
                        <p class="font__subtitle--00022 text-center mb-5 pb-0 pb-lg-4">
                            <?php echo $desc; ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
            <div class="row calculator content-calc__calculator align-items-start">
                <div class="col-lg-6 d-block text-center justify-content-center calculator__left">
                    <div class="calculator__icon mb-4">
                        <img src="<?= esc_url(Assets\asset_path('images/pack_icon.png', 'asset-sources/dhlknowledge/dist')); ?>">
                    </div>
                    <h4 class="font__title--04 mb-3"><?php the_field('calculator__left__title'); ?></h4>
                    <?php if (have_rows('calculator__packages', 'option')): ?>
                        <div class="calculator__slider">
                            <?php while (have_rows('calculator__packages', 'option')) : the_row(); ?>
                                <div class="calculator__slider__item text-center d-flex align-items-center justify-content-center flex-column"
                                     data-width="<?php echo get_sub_field('width'); ?>"
                                     data-length="<?php echo get_sub_field('length'); ?>"
                                     data-height="<?php echo get_sub_field('height'); ?>"
                                     data-weight="<?php echo get_sub_field('weight'); ?>">
                                    <?php $image = get_sub_field('image');
                                    if (!empty($image)): ?>
                                        <img class="img-fluid" src="<?php echo esc_url($image['url']); ?>"
                                             alt="<?php echo esc_attr($image['alt']); ?>"/>
                                    <?php endif; ?>
                                    <div class="calculator__slider__item__text">
                                        <?php echo get_sub_field('name'); ?> [<?php echo get_sub_field('length'); ?>
                                        x<?php echo get_sub_field('width'); ?>x<?php echo get_sub_field('height'); ?>
                                        cm],
                                        do <?php echo get_sub_field('weight'); ?>kg
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="calculator__slider__arrow calculator__slider__arrow__prev"><span>-</span></div>
                        <div class="calculator__slider__arrow calculator__slider__arrow__next active"><span>+</span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-lg-6 d-flex flex-column align-items-center justify-content-center calculator__right">
                    <div class="calculator__icon mb-4">
                        <img src="<?= esc_url(Assets\asset_path('images/glob.png', 'asset-sources/dhlknowledge/dist')); ?>">
                    </div>
                    <h4 class="font__title--04 mb-3"><?php the_field('calculator__right__title'); ?></h4>
                    <select id="country"
                            class="calculator-main-country calculator__input form-control content-calc__input content-calc__input--text"
                            type="number" name="rate_calc[country]" data-calc-field="country">
                        <option value="" selected></option>
                        <?php
                        $countries = Helpers\OptionsHelper::get_instance()->get_hidden('countries');

                        foreach ($countries as $code => $name) :
                            $cuntry_name = Polylang\t9n($name);
                            ?>
                            <option
                            value="<?php echo esc_attr($code); ?>"><?php echo esc_html($cuntry_name); ?></option><?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div class="row d-none">
                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--weight">
                        <?= Polylang\t9n('Waga'); ?>
                        <input
                                class="form-control content-calc__input content-calc__input--text content-calc__input--weight"
                                type="number" name="rate_calc[weight]" placeholder="0.3" min="0.1"
                                value="<?php echo $weight ?>"
                                data-calc-field="weight"/>
                    </label>

                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--length">
                        <?= Polylang\t9n('Długość'); ?>
                        <input
                                class="form-control content-calc__input content-calc__input--text content-calc__input--length"
                                type="number" name="rate_calc[length]" placeholder="30" min="1"
                                value="<?php echo $length ?>"
                                data-calc-field="length"/>
                    </label>

                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--width">
                        <?= Polylang\t9n('Szerokość'); ?>
                        <input
                                class="form-control content-calc__input content-calc__input--text content-calc__input--width"
                                type="number" name="rate_calc[width]" placeholder="25" min="1"
                                value="<?php echo $width ?>"
                                data-calc-field="width"/>
                    </label>

                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--height">
                        <?= Polylang\t9n('Wysokość'); ?>
                        <input
                                class="form-control content-calc__input content-calc__input--text content-calc__input--height"
                                type="number" name="rate_calc[height]" placeholder="1" min="1"
                                value="<?php echo $height ?>"
                                data-calc-field="height"/>
                    </label>
                    <button class="btn btn--auto btn--red btn-primary text-uppercase btn--calc btn--wide"
                            type="button" role="button"
                            id="calculatorSend"
                            data-calc-field="calculate"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="container bg__color--gray-light content-calc__results" data-calc-results>
        <div class="calculator__result container py-5">
            <div class="row">
                <div class="col-lg-9 mobile-margin-bottom">
                    <div class="col-12 col-lg-12 d-flex align-items-center justify-content-center flex-column text-center mx-auto">
                        <h4 class="font__title--01 font__color--red mb-3"><span class="price" data-calc-price></span>
                            PLN
                        </h4>
                        <span class="font__title--06 font__color--gray2 mb-3"><strong><?php echo get_field('calculator__result__title', 'option'); ?></strong></span>
                        <div class="calculator__result__text">
                            <?php echo get_field('calculator__result__text', 'option'); ?>
                        </div>
                        <span class="font__title--06 font__color--gray2 mb-3"><strong><?php echo get_field('calculator__result__title2', 'option'); ?></strong></span>
                        <div class="calculator__result__text">
                            <?php echo get_field('calculator__result__text2', 'option'); ?>
                        </div>
                    </div>
                    <div class="col-9 col-lg-5 d-flex align-items-center justify-content-center flex-column mx-auto text-center calculator__result__bottom">
                        <?php
                        $button = get_field('calculator__result__button', 'option');
                        if ($button) : ?>
                            <a href="<?php echo $button['url']; ?>"
                               class="btn btn--auto btn-primary btn--calc text-uppercase"
                               target="_blank"><?php echo $button['title']; ?></a>
                        <?php endif; ?>
                    </div>
                </div>


                <div class="col-lg-3 pr-xl-5">
                    <div class="d-flex justify-content-center">
                        <div class="content-calc__result-inner position-relative">
                            <div
                                    class="content-calc__badge text-uppercase font__color--gray image-yellow"><?php echo Polylang\t9n('Oferta dla firm'); ?></div>
                            <!--                    <h3 class="content-calc__result-header content-calc__result-header--call">-->
                            <? //= Polylang\t9n('Oferta dla firm'); ?><!--</h3>-->
                            <h3 class="content-calc__result-header content-calc__result-header--call font__subtitle--011"><?= Polylang\t9n('Wysyłasz regularnie?'); ?></h3>
                            <p class="content-calc__result-info"><?= Polylang\t9n('Zapytaj o ofertę dla firm. Zyskaj atrakcyjne stawki na eksport i import przesyłek'); ?></p>
                            <!--                    <p class="content-calc__result-info">-->
                            <? //= Polylang\t9n('Skorzystaj z oferty dla firm – eksport i import przesyłek'); ?><!--</p>-->
                            <!--p class="content-calc__result-price mb-0">
                            </p-->
                            <div class="content-calc__no-price"></div>
                            <?php
                            $targetUrl = (empty(get_sub_field('custom_landing_url'))) ?
                                esc_url(get_field('calculator_button4_url', 'option')) :
                                get_sub_field('custom_landing_url');
                            ?>

                            <div class="align-items-end">
                                <a href="<?php echo $targetUrl; ?>"
                                   class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase mt-5"><?= Polylang\t9n('Sprawdź'); ?></a>
                                <p class="content-calc__shipment-time el__color--gray_light"><?php echo Polylang\t9n('Szybkie dostawy i odbiory z 220 krajów i terytoriów'); ?></p>
                            </div>

                            <!--                        <a href="--><?php //echo $targetUrl; ?><!--"-->
                            <!--                           class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase mt-5">-->
                            <? //= Polylang\t9n('Sprawdź'); ?><!--</a>-->
                            <!--                        <p class="content-calc__shipment-time el__color--gray_light">-->
                            <?php //echo Polylang\t9n('Szybkie dostawy i odbiory z 220 krajów i terytoriów'); ?><!--</p>     <div class="content-calc__additional js-show-additional-discount text-center">-->
                            <!--                            -->
                            <?php //echo Polylang\t9n('Odbierz dodatkowy rabat'); ?><!-- &nbsp;<img-->
                            <!--                                    src="-->
                            <? //= esc_url(Assets\asset_path('images/r_arrow.png',
                            //                                        'asset-sources/dhlknowledge/dist')); ?><!--" alt="&raquo;">-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</section>
