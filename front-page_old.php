<?php
use MintMedia\PolylangT9n\Polylang;
use MintMedia\ShipmentCalc\Helpers;
use MintMedia\Dhl\Templates;
use MintMedia\Dhl\Tags;
use SD\Template\Tags as SdTags;
use Roots\Sage\Assets;
?>

<?php
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



<section class="content-intro">
    <div class="content-intro__background">
        <?php the_post_thumbnail('full'); ?>

        <div class="content-intro__container">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-7">
                        <div class="editor text-left">
                            <?php the_content(); ?>
                        </div>
                        <?php $subtitle = get_field('top_visual', $post)['subtitle'];
                        if ($subtitle): ?>
                            <div class="content-intro__info text-left"><?php echo $subtitle; ?></div>
                        <?php endif; ?>

                        <?php if (get_field('top_visual', $post)['cta_button']['url'] && get_field('top_visual', $post)['cta_button']['label']): ?>
                            <p class="content-intro__btn-wrapper text-left">
                                <a href="<?php echo get_field('top_visual', $post)['cta_button']['url']; ?>" class="btn btn-primary btn--content-intro" data-scroller>
                                    <?php echo get_field('top_visual', $post)['cta_button']['label']; ?>
                                </a>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="tracking-form d-flex align-items-center">
            <div class="container">
                <form class="row d-flex align-items-center" method="GET" action="<?php echo $trackingUrl; ?>" target="_blank">
                    <div class="col-12 col-md-3 text-uppercase font__size--xl text-center text-md-left mb-3 mb-md-0">
                        <?php echo Polylang\t9n('Śledzenie przesyłki'); ?>
                    </div>
                    <div class="col-12 col-md-6">
                        <input class="form-control border-white" type="text" name="tracking-id" placeholder="<?php echo Polylang\t9n('Podaj numer przesyłki'); ?>" />
                        <input type="hidden" name="submit" value="1" />
                    </div>
                    <div class="col-12 col-md-3 position-relative">
                        <button class="btn btn-alternative btn--wide" type="submit" role="button"><?= Polylang\t9n('Sprawdź'); ?></button>

                        <a class="font__color--white readdress" rel="nofollow" target="_blank" href="<?php echo $readdressUrl; ?>" title="<?php echo Polylang\t9n('Zarządzaj dostawą przesyłki'); ?>">
                            <?php echo Polylang\t9n('Zarządzaj dostawą przesyłki'); ?>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="content-calc" id="calculator">
    <div class="content-calc__calculator-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-5">
                    <h2 class="content-calc__header pt-5"><?= Polylang\t9n('Wybierz kraj docelowy i&nbsp;oblicz cenę przesyłki!'); ?></h2>
                    <p class="content-calc__info"><?= Polylang\t9n('Po wpisaniu parametrów przesyłki otrzymasz warianty cenowe.'); ?></p>
                </div>
            </div>
            <form action="<?= esc_url(home_url('/')); ?>" method="post">
                <div class="row content-calc__calculator">
                    <label class="col-12 col-md-6 col-lg-2 form-group content-calc__label content-calc__label--country input__home-icon">
                        <?= Polylang\t9n('Twój kod pocztowy'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--postal" type="text" name="rate_calc[postal]" placeholder="xx-xxx" data-calc-field="postal" />
                    </label>

                    <div class="col-12 col-md-3 col-lg-2 d-flex align-items-end justify-content-center mb-3">
                        <img src="<?php echo esc_url(Assets\asset_path('images/plane.png', 'asset-sources/dhlexpress/dist')); ?>" alt="Plane" class="img-fluid mb-1" />
                    </div>

                    <label class="col-12 col-md-6 col-lg-4 form-group content-calc__label content-calc__label--country input__home-icon">
                        <?= Polylang\t9n('Kraj przeznaczenia'); ?>

                        <select class="form-control" type="number" name="rate_calc[country]" data-calc-field="country">
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
                    <label class="col-6 col-md-3 col-lg-2 form-group content-calc__label content-calc__label--weight">
                        <?= Polylang\t9n('Waga'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--weight" type="number" name="rate_calc[weight]" placeholder="0.3" min="0.1" value="0.3" data-calc-field="weight" />
                    </label>

                    <label class="col-6 col-md-3 col-lg-2 form-group content-calc__label content-calc__label--length">
                        <?= Polylang\t9n('Długość'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--length" type="number" name="rate_calc[length]" placeholder="30" min="1"  value="30" data-calc-field="length" />
                    </label>

                    <label class="col-6 col-md-3 col-lg-2 form-group content-calc__label content-calc__label--width">
                        <?= Polylang\t9n('Szerokość'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--width" type="number" name="rate_calc[width]" placeholder="25" min="1" value="25" data-calc-field="width" />
                    </label>

                    <label class="col-6 col-md-3 col-lg-2 form-group content-calc__label content-calc__label--height">
                        <?= Polylang\t9n('Wysokość'); ?>
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--height" type="number" name="rate_calc[height]" placeholder="1" min="1" value="1" data-calc-field="height" />
                    </label>

                    <div class="col-12 col-md-6 col-lg-2 content-calc__btn-wrapper">
                        <button class="btn btn-primary btn--calc btn--wide" type="button" role="button" data-calc-field="calculate"><?= Polylang\t9n('Oblicz'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
    $chosenVariation = MintMedia\Dhl\Experiments\get_variation();
    ?><div class="content-calc__results container" data-calc-results >
        <div class="row content-calc__results-wrapper">
            <div class="col chosen-option content-calc__result content-calc__result--walk<?php if ($chosenVariation === 1) : ?> order-2<?php endif; ?>" data-calc-result="walk" data-result-version="normal" data-alt-class="content-calc__result--alternate">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--walk"><?= Polylang\t9n('Osobiście'); ?></h3>
                    <p class="content-calc__result-info" data-alt-text="<?= Polylang\t9n_attr('Po&nbsp;co&nbsp;dźwigać? Zamów kuriera przez&nbsp;internet!'); ?>"><?= Polylang\t9n('Ponad 600&nbsp;punktów nadań'); ?></p>
                    <p class="content-calc__result-price"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="<?= esc_url(Polylang\t9n('https://locator.dhl.com/ServicePointLocator/m/index.jsp?l=pl&u=km')); ?>" class="btn btn-primary btn--wide content-calc__btn" target="_blank" data-offer-btn="walk"><?= Polylang\t9n('Znajdź'); ?></a>
                    <p class="content-calc__shipment-time" data-alt-text="<?= Polylang\t9n_attr('Punkty partnerskie DHL ServicePoint przyjmują przesyłki o&nbsp;wadze do&nbsp;10&nbsp;kg.'); ?>"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &raquo;
                    </div>
                </div>
            </div>

            <div class="col content-calc__result content-calc__result--click<?php if ($chosenVariation === 1) : ?> order-3<?php endif; ?>" data-calc-result="click" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--click"><?= Polylang\t9n('Przez internet'); ?></h3>
                    <p class="content-calc__result-info"><?= Polylang\t9n('Bez wychodzenia z&nbsp;domu'); ?></p>
                    <p class="content-calc__result-price"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="<?= esc_url(Polylang\t9n('https://webshipping2.dhl.com/wsi/WSIServlet?moduleKey=Login&countryCode=pl&languageCode=pl&createShip=y')); ?>" class="btn btn-primary btn--wide content-calc__btn" target="_blank" data-offer-btn="click"><?= Polylang\t9n('Zamów'); ?></a>
                    <p class="content-calc__shipment-time"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &raquo;
                    </div>
                </div>
            </div>

            <div class="col content-calc__result content-calc__result--call<?php if ($chosenVariation === 1) : ?> order-4<?php endif; ?>" data-calc-result="call" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--call"><?= Polylang\t9n('Przez telefon'); ?></h3>
                    <p class="content-calc__result-info"><?= Polylang\t9n('Odbiór w&nbsp;domu lub w&nbsp;biurze'); ?></p>
                    <p class="content-calc__result-price"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="tel:<?= Polylang\t9n_attr('426345100'); ?>" class="btn btn-primary btn--wide content-calc__btn" data-cta="<?= Polylang\t9n('Zadzwoń'); ?>"  data-tel="<?= Polylang\t9n_attr('426345100'); ?>" data-offer-btn="call"><?= Polylang\t9n('Zadzwoń'); ?></a>
                    <p class="content-calc__shipment-time"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &raquo;
                    </div>
                </div>
            </div>

            <div class="col content-calc__result content-calc__result--call<?php if ($chosenVariation === 1) : ?> order-4<?php endif; ?>" data-calc-result="postals" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
<!--                    <h3 class="content-calc__result-header content-calc__result-header--call">--><?//= Polylang\t9n('Oferta dla firm'); ?><!--</h3>-->
                    <h3 class="content-calc__result-header content-calc__result-header--call"><?= Polylang\t9n('Wysyłasz regularnie?'); ?></h3>
                    <p class="content-calc__result-info"><?= Polylang\t9n('Zapytaj o ofertę dla firm. Zyskaj atrakcyjne stawki na eksport i import przesyłek'); ?></p>
<!--                    <p class="content-calc__result-info">--><?//= Polylang\t9n('Skorzystaj z oferty dla firm – eksport i import przesyłek'); ?><!--</p>-->
                    <p class="content-calc__result-price mb-1">
                    </p>
                    <a href="/<?php echo $formSlug; ?>/#open-account" class="btn btn-primary btn--wide content-calc__btn"><?= Polylang\t9n('Sprawdź'); ?></a>
                    <p class="content-calc__shipment-time"><?php echo Polylang\t9n('Szybkie dostawy i odbiory z 220 krajów i terytoriów'); ?></p>
                    <div class="content-calc__additional js-show-additional-discount">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> &raquo;
                    </div>
                </div>
            </div>

            <div class="col-12 content-calc__disclaimer<?php if ($chosenVariation === 1) : ?> order-5<?php endif; ?>" data-calc-result>
                <div class="content-calc__result-inner">
                    <p><?= Polylang\t9n('Ostateczna cena oraz czas transportu mogą się różnić od&nbsp;wyświetlonego w&nbsp;zależności od&nbsp;zawartości przesyłki, wartości towaru, kraju i&nbsp;adresu docelowego. Obowiązują dopłaty i&nbsp;usługi dostępne w&nbsp;Cenniku Usług Międzynarodowych&nbsp;2020.'); ?></p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="home-newsletter" id="home-newsletter">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6">
                <h2 class="content-calc__header font__size--xxl mb-54px text-center text-md-left">
                    <?php echo Polylang\t9n('Promocje i oferty dla Ciebie'); ?>
                </h2>
                <?php SdTags\newsletterHomeForm(); ?>
            </div>
        </div>
    </div>
</section>


<section class="shipment-options container">
    <div class="row shipment-options__wrapper">
        <div class="col-10 ml-auto mr-auto">
            <h2 class="shipment-options__header break-word"><?= Polylang\t9n('Jak chcesz nadać przesyłkę'); ?></h2>
        </div>

        <div class="col-12">
            <ul class="row shipment-options__list">
                <li class="col-12 col-md-4 shipment-options__item">
                    <div class="shipment-options__option-wrapper">
                        <h3 class="shipment-options__option-header shipment-options__option-header--walk"><?= Polylang\t9n('Osobiście'); ?></h3>

                        <ul class="shipment-options__advantages">
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Bezpłatne opakowanie'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Ponad 600 punktów nadań'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Długie godziny otwarcia'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Przesyłka do&nbsp;10&nbsp;kg'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Opłata przy nadaniu'); ?></span></li>
                        </ul>

                        <p class="shipment-options__btn-wrapper">
                            <a href="<?= esc_url(Polylang\t9n('https://locator.dhl.com/ServicePointLocator/m/index.jsp?l=pl&u=km')); ?>" class="btn btn-primary btn--advantage" target="_blank" data-advantages-btn="walk"><?= Polylang\t9n('Placówki'); ?></a>
                        </p>
                    </div>
                </li>

                <li class="col-12 col-md-4 shipment-options__item">
                    <div class="shipment-options__option-wrapper">
                        <h3 class="shipment-options__option-header shipment-options__option-header--click"><?= Polylang\t9n('Przez internet'); ?></h3>

                        <ul class="shipment-options__advantages">
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Bez wychodzenia z&nbsp;domu'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Odbiór w&nbsp;domu lub biurze'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Dostępność 24h'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Bez potrzeby logowania'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Opłata przy nadaniu'); ?></span></li>
                        </ul>

                        <p class="shipment-options__btn-wrapper">
                            <a href="<?= esc_url(Polylang\t9n('https://webshipping2.dhl.com/wsi/WSIServlet?moduleKey=Login&countryCode=pl&languageCode=pl&createShip=y')); ?>" class="btn btn-primary btn--advantage" target="_blank" data-advantages-btn="click"><?= Polylang\t9n('Zamów'); ?></a>
                        </p>
                    </div>
                </li>

                <li class="col-12 col-md-4 shipment-options__item" id="callCTA">
                    <div class="shipment-options__option-wrapper">
                        <h3 class="shipment-options__option-header shipment-options__option-header--call"><?= Polylang\t9n('Przez telefon'); ?></h3>

                        <ul class="shipment-options__advantages">
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Pomocni konsultanci'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Odbiór w&nbsp;domu lub biurze'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Szeroki wybór usług dodatkowych'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('pn.&nbsp;&ndash;&nbsp;pt. 7:30&nbsp;&ndash;&nbsp;18:30'); ?></span></li>
                            <li class="shipment-options__advantage"><span class="shipment-options__advantage-inner"><?= Polylang\t9n('Opłata przy nadaniu'); ?></span></li>
                        </ul>

                        <p class="shipment-options__btn-wrapper">
                            <a href="tel:<?= Polylang\t9n_attr('426345100'); ?>" class="btn btn-primary btn--advantage js-hover-phone" data-cta="<?= Polylang\t9n('Zadzwoń'); ?>" data-advantages-btn="call" data-tel="<?= Polylang\t9n_attr('426345100'); ?>"><?= Polylang\t9n('Zadzwoń'); ?></a>
                        </p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</section>

<section class="numbers-section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                <h2 class="numbers-section__header"><?= Polylang\t9n('DHL Express w&nbsp;liczbach'); ?></h2>
                <p class="numbers-section__info"><?= Polylang\t9n('Stale poszerzamy horyzonty i&nbsp;doręczamy wszędzie tam, gdzie są&nbsp;nasi klienci.'); ?></p>

                <ul class="row numbers-section__facts">
                    <li class="col-6 numbers-section__fact-wrapper">
                        <div class="numbers-section__fact-inner numbers-section__fact-inner--world">
                            <p class="numbers-section__fact"><span class="numbers-section__number"><?= Polylang\t9n('220+'); ?></span> <?= Polylang\t9n('krajów w&nbsp;zasięgu'); ?></p>
                        </div>
                    </li>
                    <li class="col-6 numbers-section__fact-wrapper">
                        <div class="numbers-section__fact-inner numbers-section__fact-inner--plane">
                            <p class="numbers-section__fact"><span class="numbers-section__number"><?= Polylang\t9n('250+'); ?></span> <?= Polylang\t9n('samolotów w&nbsp;DHL'); ?></p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php
Templates\articles_section();
?>

<section class="files-section container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10">
            <h2 class="files-section__header"><?= Polylang\t9n('Potrzebne pliki'); ?></h2>

            <ul class="files-section__files">
                <li class="files-section__file files-section__file--doc">
                    <span class="files-section__file-name"><?= Polylang\t9n('Pakowanie przesyłek'); ?></span>
                    <a href="<?= esc_url(Polylang\t9n('https://www.dhl.com.pl/content/dam/downloads/pl/express/pl/shipping/packaging/dhl_express_packing_guide_pl_pl.pdf')); ?>" class="files-section__file-link" data-document-link="pdf1"><?= Polylang\t9n('Pobierz'); ?></a>
                </li>

                <?php
                if ((function_exists('pll_current_language') && pll_current_language() === 'pl') || !function_exists('pll_current_language')) :
                    ?>
                <li class="files-section__file files-section__file--doc">
                    <span class="files-section__file-name"><?= Polylang\t9n('Faktura proforma'); ?></span>
                    <a href="<?= esc_url(Polylang\t9n('https://www.dhl.com.pl/content/dam/downloads/pl/express/brochures/faktura_proforma.pdf')); ?>" class="files-section__file-link" data-document-link="pdf2"><?= Polylang\t9n('Pobierz'); ?></a>
                </li>

                <li class="files-section__file files-section__file--doc">
                    <span class="files-section__file-name"><?= Polylang\t9n('Oświadczenie Low Value'); ?></span>
                    <a href="<?= esc_url(Polylang\t9n('https://www.dhl.com.pl/content/dam/downloads/pl/express/pl/shipping/dhl_express_oswiadczenie_lv_pl.pdf')); ?>" class="files-section__file-link" data-document-link="pdf3"><?= Polylang\t9n('Pobierz'); ?></a>
                </li>

                <li class="files-section__file files-section__file--doc">
                    <span class="files-section__file-name"><?= Polylang\t9n('Upoważnienie dla Agencji Celnej (osoba prywatna)'); ?></span>
                    <a href="<?= esc_url(Polylang\t9n('https://www.dhl.com.pl/content/dam/downloads/pl/express/pl/shipping/customs_authorization/dhl_express_authorization_indirect_individual_pl_pl.pdf')); ?>" class="files-section__file-link" data-document-link="pdf4"><?= Polylang\t9n('Pobierz'); ?></a>
                </li>

                <li class="files-section__file files-section__file--doc">
                    <span class="files-section__file-name"><?= Polylang\t9n('Upoważnienie dla Agencji Celnej (firma)'); ?></span>
                    <a href="<?= esc_url(Polylang\t9n('https://www.dhl.com.pl/content/dam/downloads/pl/express/pl/shipping/customs_authorization/dhl_express_authorization_indirect_company_pl_pl.pdf')); ?>" class="files-section__file-link" data-document-link="pdf5"><?= Polylang\t9n('Pobierz'); ?></a>
                </li>
                    <?php
                endif;
                ?>

                <li class="files-section__file files-section__file--doc">
                    <span class="files-section__file-name"><?= Polylang\t9n('Ogólne Postanowienia Umowy i Zasady Odpowiedzialności'); ?></span>
<!--                    <a href="--><?//= esc_url(Polylang\t9n('https://www.dhl.com.pl/content/dam/downloads/g0/express/shipping/terms_condiitions/international/terms_conditions_of_carriage_pl_pl.pdf')); ?><!--" class="files-section__file-link" data-document-link="pdf6">--><?//= Polylang\t9n('Pobierz'); ?><!--</a>-->
                    <a href="<?php echo esc_url(Polylang\t9n('https://www.dhl.com.pl/content/dam/downloads/g0/express/shipping/terms_condiitions/international/terms_conditions_of_carriage_pl_pl.pdf')); ?>" class="files-section__file-link" data-document-link="pdf6"><?php echo Polylang\t9n('Pobierz'); ?></a>
                </li>
            </ul>
        </div>
    </div>
</section>

<?php
if ((function_exists('pll_current_language') && pll_current_language() === 'pl') || !function_exists('pll_current_language')) :
    ?>
<aside class="disclaimer-section" id="benefits">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="disclaimer-section__header disclaimer-section__header--top"><?= Polylang\t9n('DHL Express &ndash; doręczamy przesyłki wszędzie tam, gdzie są&nbsp;nasi klienci'); ?></h1>

                <p class="disclaimer-section__text"><?= Polylang\t9n('DHL Express to&nbsp;globalny lider w&nbsp;dziedzinie międzynarodowych przesyłek ekspresowych. Szeroki zakres usług kurierskich oferowany jest zarówno klientom biznesowym, jak&nbsp;i&nbsp;indywidualnym. Kompleksowe i&nbsp;niezawodne działanie pozwala dotrzeć wszędzie tam, gdzie są&nbsp;nasi klienci.'); ?></p>

                <h2 class="disclaimer-section__header disclaimer-section__header--subheader"><?= Polylang\t9n('Jak wysłać przesyłkę międzynarodową?'); ?></h2>

                <p class="disclaimer-section__text"><?= Polylang\t9n('W&nbsp;DHL Express podchodzimy do&nbsp;sprawy profesjonalnie. Doręczamy przesyłki zagraniczne i&nbsp;dokumenty do&nbsp;największej liczby miejsc na&nbsp;świecie &ndash; ponad 220&nbsp;krajów oraz terytoriów. <a id="disclaimer-link-calculator" href="#calculator" data-scroller>Sprawdź</a>, jak szybko i&nbsp;bezproblemowo nadasz przesyłkę lotniczą.'); ?></p>

                <h2 class="disclaimer-section__header disclaimer-section__header--subheader"><?= Polylang\t9n('Jaki jest koszt doręczenia przesyłki za&nbsp;granicę?'); ?>'</h2>

                <p class="disclaimer-section__text"><?= Polylang\t9n('Ty&nbsp;wybierasz miejsce docelowe i&nbsp;wpisujesz parametry przesyłki, a&nbsp;my&nbsp;obliczamy dla Ciebie warianty cenowe i&nbsp;przedstawiamy najkrótszy czas transportu na&nbsp;wysyłki za&nbsp;granicę &ndash; <a id="disclaimer-link-calculator" href="#calculator" data-scroller>oblicz</a>.'); ?></p>

                <h2 class="disclaimer-section__header disclaimer-section__header--subheader"><?= Polylang\t9n('Jak nadać paczkę za&nbsp;granicę?'); ?>'</h2>

                <p class="disclaimer-section__text"><?= Polylang\t9n('Możesz skorzystać z&nbsp;kilku opcji &ndash; Ty&nbsp;wybierasz tę&nbsp;najbardziej dogodną dla siebie. Zagraniczną przesyłkę lotniczą nadasz osobiście (w&nbsp;najbliższym punkcie DHL), przez internet &ndash; wypełniając formularz lub telefonicznie &ndash; łącząc się z&nbsp;konsultantem DHL Express.'); ?></p>

                <h2 class="disclaimer-section__header disclaimer-section__header--subheader"><?= Polylang\t9n('W&nbsp;jaki sposób nadać paczkę w&nbsp;punkcie DHL?'); ?></h2>

                <p class="disclaimer-section__text"><?= Polylang\t9n('DHL Servicepoint to&nbsp;idealne rozwiązanie, gdy wysyłasz pojedyncze przesyłki za&nbsp;granicę. Posiadamy ponad 600 punktów nadań <link>, w&nbsp;których &ndash; dla Twojej wygody &ndash; obowiązują długie godziny otwarcia. Decydując się na&nbsp;nadanie przesyłki w&nbsp;najbliższym punkcie DHL otrzymasz darmowe opakowanie wliczone w&nbsp;koszty transportu.'); ?></p>

                <h2 class="disclaimer-section__header disclaimer-section__header--subheader"><?= Polylang\t9n('Gdzie mogę monitorować przesyłkę międzynarodową?'); ?></h2>

                <p class="disclaimer-section__text"><?= Polylang\t9n('Na&nbsp;stronie internetowej DHL masz możliwość <a href="http://www.dhl.com.pl/pl/express/sprawdz_przesylke.html" target="_blank">monitorowania statusu</a> lotniczej przesyłki zagranicznej. Monitoring zamówienia umożliwia śledzenie aktualnego miejsca przesyłki. To&nbsp;komfortowe rozwiązanie, gdy przesyłka międzynarodowa jest pilna lub bardzo ważna.'); ?></p>
            </div>
        </div>
    </div>
</aside>
    <?php
endif;
?>
