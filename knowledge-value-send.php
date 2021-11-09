<?php

/**
 * Template name: Page Wyceń i Wyślij
 */

use MintMedia\PolylangT9n\Polylang;
use MintMedia\ShipmentCalc\Helpers;
use MintMedia\Dhl\Templates;
use MintMedia\Dhl\Tags;
use SD\Template\Tags as SdTags;
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

?>

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/knowledge/header-new'); ?>

    <?php get_template_part('templates/knowledge/section-tiled-2'); ?>

<section class="content-calc" id="calculator">
    <div class="content-calc__calculator-wrapper">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6 mx-auto">
                    <h2 class="font__title--01 font__color--gray text-uppercase text-center d-block mb-5"><?php the_field('calculator_title', 'option'); ?></h2>
                </div>
            </div>

            <div class="row">
            <div class="col-lg-10 col-xl-8 mx-auto pr-xl-0 pl-xl-0">
            <form action="<?= esc_url(home_url('/')); ?>" method="post">
                <div class="row content-calc__calculator">
                    <label class="col-12 col-md-6 col-lg-5 form-group content-calc__label content-calc__label--country order-2 order-lg-1 pr-lg-0 d-none">
                        <?= Polylang\t9n('Kod pocztowy'); ?>*
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--postal" type="text" name="rate_calc[postal]" placeholder="xx-xxx" data-calc-field="postal" />
                    </label>
                    <div class="col-12 col-md-2 d-flex align-items-end justify-content-center mb-3 order-1 order-md-3">
                        <img src="<?php echo esc_url(Assets\asset_path('images/plane.png', 'asset-sources/dhlexpress/dist')); ?>" alt="Plane" class="img-fluid mb-1 plane" />
                    </div>
                    <label class="col-12 col-md-6 col-lg-5 form-group content-calc__label content-calc__label--country order-3 order-md-2">
                        <?= Polylang\t9n('Kraj przeznaczenia'); ?>*

                        <select id="country" class="form-control content-calc__input content-calc__input--text" type="number" name="rate_calc[country]" data-calc-field="country">
                            <option value="" selected></option>
                            <?php
                            $countries = Helpers\OptionsHelper::get_instance()->get_hidden('countries');

                            foreach ($countries as $code => $name) :
                                $cuntry_name = Polylang\t9n($name);
                                ?><option value="<?php echo esc_attr($code); ?>"><?php echo esc_html($cuntry_name); ?></option><?php
                            endforeach;
                            ?>
                        </select>
                    </label>
                </div>

                <div class="row content-calc__calculator">
                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--weight">
                        <?= Polylang\t9n('Waga'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--weight" type="number" name="rate_calc[weight]" placeholder="0.3" min="0.1" value="0.3" data-calc-field="weight" />
                    </label>

                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--length">
                        <?= Polylang\t9n('Długość'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--length" type="number" name="rate_calc[length]" placeholder="30" min="1"  value="30" data-calc-field="length" />
                    </label>

                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--width">
                        <?= Polylang\t9n('Szerokość'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--width" type="number" name="rate_calc[width]" placeholder="25" min="1" value="25" data-calc-field="width" />
                    </label>

                    <label class="col-6 col-md-3 form-group content-calc__label content-calc__label--height">
                        <?= Polylang\t9n('Wysokość'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--height" type="number" name="rate_calc[height]" placeholder="1" min="1" value="1" data-calc-field="height" />
                    </label>
                </div>

                <div class="row">
                    <div class="col-12 text-center content-calc__btn-wrapper">
                        <button class="btn btn--auto btn--red btn-primary text-uppercase btn--calc btn--wide" type="button" role="button" data-calc-field="calculate"><?php the_field('calculator_text_button', 'option'); ?></button>
                    </div>
                </div>
            </form>
            </div>
            </div>

        </div>
    </div>

<div class="bg__color--gray-light">
    <?php
    $chosenVariation = MintMedia\Dhl\Experiments\get_variation();
    ?><div class="content-calc__results container" data-calc-results >
        <div class="row content-calc__results-wrapper">
            <div class="col-12 col-sm-6 col-lg-3 chosen-option content-calc__result content-calc__result--walk<?php if ($chosenVariation === 1) : ?> order-2<?php endif; ?>" data-calc-result="walk" data-result-version="normal" data-alt-class="content-calc__result--alternate">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase font__color--gray"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--walk font__subtitle--011"><?= Polylang\t9n('Osobiście'); ?></h3>
                    <p class="content-calc__result-info " data-alt-text="<?= Polylang\t9n_attr('Po&nbsp;co&nbsp;dźwigać? Zamów kuriera przez&nbsp;internet!'); ?>"><?= Polylang\t9n('Ponad 600&nbsp;punktów nadań'); ?></p>
                    <p class="content-calc__result-price font__color--gray"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="<?= esc_url(Polylang\t9n('https://locator.dhl.com/ServicePointLocator/m/index.jsp?l=pl&u=km')); ?>" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase" target="_blank" data-offer-btn="walk"><?= Polylang\t9n('Znajdź'); ?></a>
                    <p class="content-calc__shipment-time el__color--gray_light" data-alt-text="<?= Polylang\t9n_attr('Punkty partnerskie DHL ServicePoint przyjmują przesyłki o&nbsp;wadze do&nbsp;10&nbsp;kg.'); ?>"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount text-center">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &nbsp;<img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 content-calc__result content-calc__result--click<?php if ($chosenVariation === 1) : ?> order-3<?php endif; ?>" data-calc-result="click" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--click font__subtitle--011"><?= Polylang\t9n('Przez internet'); ?></h3>
                    <p class="content-calc__result-info "><?= Polylang\t9n('Bez wychodzenia z&nbsp;domu'); ?></p>
                    <p class="content-calc__result-price font__color--gray"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="<?= esc_url(Polylang\t9n('https://webshipping2.dhl.com/wsi/WSIServlet?moduleKey=Login&countryCode=pl&languageCode=pl&createShip=y')); ?>" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase" target="_blank" data-offer-btn="click"><?= Polylang\t9n('Zamów'); ?></a>
                    <p class="content-calc__shipment-time el__color--gray_light"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount text-center">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &nbsp;<img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 content-calc__result content-calc__result--call<?php if ($chosenVariation === 1) : ?> order-4<?php endif; ?>" data-calc-result="call" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--call font__subtitle--011"><?= Polylang\t9n('Przez telefon'); ?></h3>
                    <p class="content-calc__result-info"><?= Polylang\t9n('Odbiór w&nbsp;domu lub w&nbsp;biurze'); ?></p>
                    <p class="content-calc__result-price font__color--gray"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="tel:<?= Polylang\t9n_attr('426345100'); ?>" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase" data-cta="<?= Polylang\t9n('Zadzwoń'); ?>"  data-tel="<?= Polylang\t9n_attr('426345100'); ?>" data-offer-btn="call"><?= Polylang\t9n('Zadzwoń'); ?></a>
                    <p class="content-calc__shipment-time el__color--gray_light"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount text-center">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &nbsp;<img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>
            <!--            content-calc__results--has-results-->
            <div class="col-12 col-sm-6 col-lg-3 content-calc__result content-calc__result--call<?php if ($chosenVariation === 1) : ?> order-1<?php endif; ?>" data-calc-result="postals" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase font__subtitle--011 image-red">
                        <?php echo Polylang\t9n('RABAT DLA FIRM'); ?>
                    </div>
<!--                    <h3 class="content-calc__result-header content-calc__result-header--call">--><?//= Polylang\t9n('Oferta dla firm'); ?><!--</h3>-->
                    <h3 class="content-calc__result-header content-calc__result-header--call font__subtitle--011"><?= Polylang\t9n('Wysyłasz regularnie?'); ?></h3>
                    <p class="content-calc__result-info"><?= Polylang\t9n('Otwórz konto biznesowe i zyskaj <b>65% rabatu</b> na przesyłki zagraniczne'); ?></p>
<!--                    <p class="content-calc__result-info">--><?//= Polylang\t9n('Skorzystaj z oferty dla firm – eksport i import przesyłek'); ?><!--</p>-->
                    <!--p class="content-calc__result-price mb-0">
                    </p-->
                    <div class="content-calc__no-price"></div>
                    <a href="<?php echo esc_url(get_field('calculator_button4_url', 'option')); ?>" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase mt-5"><?= Polylang\t9n('SKORZYSTAJ'); ?></a>
                    <p class="content-calc__shipment-time el__color--gray_light"><?php echo Polylang\t9n('Oferta dla regularnych wysyłek i importów'); ?></p>
                    <div class="content-calc__additional js-show-additional-discount text-center">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &nbsp;<img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>

            <div class="col-12 content-calc__disclaimer<?php if ($chosenVariation === 1) : ?> order-5<?php endif; ?> mt-3" data-calc-result>
                <div class="content-calc__result-inner p-3 m-0 font__subtitle--03">
                    <?= Polylang\t9n('Ostateczna cena oraz czas transportu mogą się różnić od&nbsp;wyświetlonego w&nbsp;zależności od&nbsp;zawartości przesyłki, wartości towaru, kraju i&nbsp;adresu docelowego. Obowiązują dopłaty i&nbsp;usługi dostępne w&nbsp;Cenniku Usług Międzynarodowych&nbsp;2020.'); ?>
                    <br>
                    <br>
                    <?= Polylang\t9n('*Oferta przeznaczona jest dla przedsiębiorców, podmiotów gospodarczych i instytucji. Warunkiem uzyskania oferty z rabatem w wysokości 65% od cennika standardowego jest deklaracja wysyłania średnio 1 przesyłki międzynarodowej za pośrednictwem DHL Express (Poland) Sp. z o.o. w ramach usługi Time Definite International. Warunki cenowe zostaną przepisane do indywidualnego numeru klienta. Szczegóły oferty dostępne u przedstawicieli handlowych DHL Express (Poland) Sp. z o.o.'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

    <?php get_template_part('templates/reusable/layouts/section_section_country'); ?>
    <?php get_template_part('templates/knowledge/section-image-text-link'); ?>
    <?php get_template_part('templates/knowledge/prefooter'); ?>

<?php endwhile; ?>