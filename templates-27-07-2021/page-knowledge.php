<?php
/**
 * Template name: [Baza wiedzy]
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;
use MintMedia\ShipmentCalc\Helpers;

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

<?php while (have_posts()) : the_post(); ?>


<?php get_template_part('templates/knowledge/header-new'); ?>



<section class="blog_category mt-5 pt-5">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-md-4">
				<div class="blog_category--item bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_bw_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--05 text-uppercase font__color--gray">poradnik wysyłkowy</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4">
				<div class="blog_category--item bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_bw_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--05 text-uppercase font__color--gray">wiedza celna</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-md-4">
				<div class="blog_category--item bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_bw_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--05 text-uppercase font__color--gray">DOKUMENTY</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="content-calc" id="calculator">
    <div class="content-calc__calculator-wrapper bg__color--yellow">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-12 col-xl-6 mx-auto">
                    <h2 class="font__title--01 font__color--gray text-uppercase text-center d-block mb-5"><?= Polylang\t9n('Wybierz kraj docelowy i&nbsp;oblicz cenę przesyłki!'); ?></h2>
                </div>
            </div>

			<div class="row">
			<div class="col-lg-8 mx-auto">
            <form action="<?= esc_url(home_url('/')); ?>" method="post">
                <div class="row content-calc__calculator">
                    <label class="col-12 col-md-6 col-lg-5 form-group content-calc__label content-calc__label--country">
                        <?= Polylang\t9n('Kod poczotowy'); ?>*
                        <input class="form-control content-calc__input content-calc__input--text content-calc__input--postal" type="text" name="rate_calc[postal]" placeholder="xx-xxx" data-calc-field="postal" />
                    </label>

                    <div class="col-12 col-md-3 col-lg-2 d-flex align-items-end justify-content-center mb-3">
                        <img src="<?php echo esc_url(Assets\asset_path('images/plane.png', 'asset-sources/dhlexpress/dist')); ?>" alt="Plane" class="img-fluid mb-1" />
                    </div>

                    <label class="col-12 col-md-6 col-lg-5 form-group content-calc__label content-calc__label--country">
                        <?= Polylang\t9n('Kraj przeznaczenia'); ?>*

                        <select class="form-control content-calc__input content-calc__input--text" type="number" name="rate_calc[country]" data-calc-field="country">
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
                        <button class="btn btn--auto btn--red btn-primary text-uppercase btn--calc btn--wide" type="button" role="button" data-calc-field="calculate"><?= Polylang\t9n('Oblicz'); ?></button>
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
    ?><div class="content-calc__results  content-calc__results--has-results  container" data-calc-results >
        <div class="row content-calc__results-wrapper">
            <div class="col-12 col-sm-6 col-lg-3 chosen-option content-calc__result content-calc__result--walk<?php if ($chosenVariation === 1) : ?> order-2<?php endif; ?>" data-calc-result="walk" data-result-version="normal" data-alt-class="content-calc__result--alternate">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--walk"><?= Polylang\t9n('Osobiście'); ?></h3>
                    <p class="content-calc__result-info el__color--gray_light" data-alt-text="<?= Polylang\t9n_attr('Po&nbsp;co&nbsp;dźwigać? Zamów kuriera przez&nbsp;internet!'); ?>"><?= Polylang\t9n('Ponad 600&nbsp;punktów nadań'); ?></p>
                    <p class="content-calc__result-price"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="<?= esc_url(Polylang\t9n('https://locator.dhl.com/ServicePointLocator/m/index.jsp?l=pl&u=km')); ?>" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase" target="_blank" data-offer-btn="walk"><?= Polylang\t9n('Znajdź'); ?></a>
                    <p class="content-calc__shipment-time" data-alt-text="<?= Polylang\t9n_attr('Punkty partnerskie DHL ServicePoint przyjmują przesyłki o&nbsp;wadze do&nbsp;10&nbsp;kg.'); ?>"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount text-center d-block">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> <img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 content-calc__result content-calc__result--click<?php if ($chosenVariation === 1) : ?> order-3<?php endif; ?>" data-calc-result="click" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--click"><?= Polylang\t9n('Przez internet'); ?></h3>
                    <p class="content-calc__result-info el__color--gray_light"><?= Polylang\t9n('Bez wychodzenia z&nbsp;domu'); ?></p>
                    <p class="content-calc__result-price"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="<?= esc_url(Polylang\t9n('https://webshipping2.dhl.com/wsi/WSIServlet?moduleKey=Login&countryCode=pl&languageCode=pl&createShip=y')); ?>" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase" target="_blank" data-offer-btn="click"><?= Polylang\t9n('Zamów'); ?></a>
                    <p class="content-calc__shipment-time"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount text-center d-block">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> <img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 content-calc__result content-calc__result--call<?php if ($chosenVariation === 1) : ?> order-4<?php endif; ?>" data-calc-result="call" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
                    <h3 class="content-calc__result-header content-calc__result-header--call"><?= Polylang\t9n('Przez telefon'); ?></h3>
                    <p class="content-calc__result-info el__color--gray_light"><?= Polylang\t9n('Odbiór w&nbsp;domu lub w&nbsp;biurze'); ?></p>
                    <p class="content-calc__result-price"><span class="content-calc__price-zl" data-price="zl">00</span><span class="content-calc__price-point">,</span><span class="content-calc__price-gr" data-price="gr">00</span> <span class="content-calc__price-currency"><?= Polylang\t9n('zł/brutto'); ?></span></p>
                    <a href="tel:<?= Polylang\t9n_attr('426345100'); ?>" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase" data-cta="<?= Polylang\t9n('Zadzwoń'); ?>"  data-tel="<?= Polylang\t9n_attr('426345100'); ?>" data-offer-btn="call"><?= Polylang\t9n('Zadzwoń'); ?></a>
                    <p class="content-calc__shipment-time"><?= Polylang\t9n('Szacowany czas dostawy wynosi'); ?> <span data-singular="<?= Polylang\t9n_attr('dzień roboczy'); ?>" data-plural="<?= Polylang\t9n_attr('dni robocze'); ?>" data-shipment-time></span><abbr title="<?=
                    Polylang\t9n_attr('Ostateczna cena oraz czas transportu może się różnic od wyświetlonego w zależności od zawartości przesyłki, wartości towaru, kraju docelowego, adresu docelowego. Obowiązują wszystkie dopłaty i usługi dostępne w Cenniku Usług Międzynarodowych 2020.');
                    ?>">*</abbr></p>
                    <div class="content-calc__additional js-show-additional-discount text-center d-block">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> <img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-lg-3 content-calc__result content-calc__result--call<?php if ($chosenVariation === 1) : ?> order-4<?php endif; ?>" data-calc-result="postals" data-result-version="normal">
                <div class="content-calc__result-inner">
                    <div class="content-calc__badge text-uppercase"><?php echo Polylang\t9n('Najlepsza opcja'); ?></div>
<!--                    <h3 class="content-calc__result-header content-calc__result-header--call">--><?//= Polylang\t9n('Oferta dla firm'); ?><!--</h3>-->
                    <h3 class="content-calc__result-header content-calc__result-header--call"><?= Polylang\t9n('Wysyłasz regularnie?'); ?></h3>
                    <p class="content-calc__result-info el__color--gray_light"><?= Polylang\t9n('Zapytaj o ofertę dla firm. Zyskaj atrakcyjne stawki na eksport i import przesyłek'); ?></p>
<!--                    <p class="content-calc__result-info">--><?//= Polylang\t9n('Skorzystaj z oferty dla firm – eksport i import przesyłek'); ?><!--</p>-->
                    <p class="content-calc__result-price mb-1">
                    </p>
                    <a href="/<?php echo $formSlug; ?>/#open-account" class="btn btn-primary btn--wide content-calc__btn d-block font__title--07 text-uppercase"><?= Polylang\t9n('Sprawdź'); ?></a>
                    <p class="content-calc__shipment-time"><?php echo Polylang\t9n('Szybkie dostawy i odbiory z 220 krajów i terytoriów'); ?></p>
                    <div class="content-calc__additional js-show-additional-discount text-center d-block">
                        <?php echo Polylang\t9n('Odbierz dodatkowy rabat'); ?> <img src="<?= esc_url(Assets\asset_path('images/r_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="&raquo;">
                    </div>
                </div>
            </div>

            <!--div class="col-12 content-calc__disclaimer<?php if ($chosenVariation === 1) : ?> order-5<?php endif; ?>" data-calc-result>
                <div class="content-calc__result-inner">
                    <p><?= Polylang\t9n('Ostateczna cena oraz czas transportu mogą się różnić od&nbsp;wyświetlonego w&nbsp;zależności od&nbsp;zawartości przesyłki, wartości towaru, kraju i&nbsp;adresu docelowego. Obowiązują dopłaty i&nbsp;usługi dostępne w&nbsp;Cenniku Usług Międzynarodowych&nbsp;2020.'); ?></p>
                </div>
            </div-->
        </div>
    </div>
</div>
</section>



<section>
	<div class="container">
		<div class="row pt-md-5 pb-md-5 align-items-end">
			<div class="col-md-6 pr-lg-4">
				<div class="row align-items-end pt-5 pb-5">
					<div class="col-md-12 col-lg-5 text-center text-lg-left">
						<img class="img-fluid" src="<?= esc_url(Assets\asset_path('images/wycen_1.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<div class="col-md-12 col-lg-7 text-center text-lg-left mt-4 mt-lg-0 mb-xl-5">
						<span class="font__title--055 font__color--red d-block mb-2 mt-3 mt-md-0">Potrzebujesz <br>wysyłać <br>jeszcze szybciej?</span>
						<a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase mt-1 mt-md-4" href="#">ZOBACZ WIĘCEJ</a>
					</div>
				</div>
			</div>
			<div class="col-md-6 pl-lg-4 el__border-left-2">
				<div class="row align-items-end pt-5 pb-5">
					<div class="col-md-12 col-lg-5 text-center text-lg-left">
						<img class="img-fluid" src="<?= esc_url(Assets\asset_path('images/wycen_2.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<div class="col-md-12 col-lg-7 text-center text-lg-left mt-4 mt-lg-0 mb-xl-5">
						<span class="font__title--055 font__color--red d-block mb-2 mt-3 mt-md-0">Masz problem? Nie wiesz jak wysłać? Potrzebujesz dokumentów?</span>
						<a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase mt-1 mt-md-4" href="#">ZOBACZ WIĘCEJ</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>




<?php /* page znajdz przesylke
<div class="slider_search slider_search--static">
	<div class="container">
		<form method="GET" action="https://www.logistics.dhl/pl-pl/home/tracking.html" target="_blank">
			<div class="row">
				<div class="col-12 col-lg-3 mb-4 mb-lg-0 d-flex align-items-center justify-content-center">
					<span class="text-uppercase text-white font__title--4">Śledzenie przesyłki</span>
				</div>
				<div class="col-12 col-lg-6">
					<input type="text" name="tracking-id" class="form-control tracking_nr" id="email" name="email" placeholder="Podaj numer przesyłki">
					<input type="hidden" name="submit">
				</div>
				<div class="col-12 col-lg-3 mt-2 mt-lg-0 text-center">
					<button type="submit" role="button" class="d-block btn--check w-100">SPRAWDŹ</button>
					<a rel="nofollow" target="_blank"  title="Zarządzaj dostawą przesyłki" href="https://delivery.dhl.com/prg/waybill.xhtml?ctrycode=PL" class="el__poa text-white mt-3 mt-md-2 mb-2 d-block el__w100">Przeadresuj swoją przesyłkę</a>
				</div>
			</div>
		</form>
	</div>
</div>


<section class="article article--page mt-lg-5">
	<div class="container">
		<div class="row align-items-center align-items-lg-start">
			<div class="col-12 col-md-6 order-2 order-lg-1">
				<img class="img-fluid" src="<?= esc_url(Assets\asset_path('images/mapa_img.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
			</div>
			<div class="col-12 col-md-6 order-1 order-lg-2">
				<h2>Lorem ipsum dolor sit, consectetur adipiscing </h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. </p>
			</div>
		</div>
	</div>
</section>

    <?php get_template_part('templates/knowledge/header-new'); ?>

    <?php ?>
    <div class="slider_search slider_search--static">
        <div class="container">
            <form method="GET" action="https://www.logistics.dhl/pl-pl/home/tracking.html" target="_blank">
                <div class="row">
                    <div class="col-12 col-lg-3 mb-4 mb-lg-0 d-flex align-items-center justify-content-center">
                        <span class="text-uppercase text-white font__title--4">Śledzenie przesyłki</span>
                    </div>
                    <div class="col-12 col-lg-6">
                        <input type="text" name="tracking-id" class="form-control tracking_nr" id="email" name="email"
                               placeholder="Podaj numer przesyłki">
                        <input type="hidden" name="submit">
                    </div>
                    <div class="col-12 col-lg-3 mt-2 mt-lg-0 text-center">
                        <button type="submit" role="button" class="d-block btn--check w-100">SPRAWDŹ</button>
                        <a rel="nofollow" target="_blank" title="Zarządzaj dostawą przesyłki"
                           href="https://delivery.dhl.com/prg/waybill.xhtml?ctrycode=PL"
                           class="el__poa text-white mt-3 mt-md-2 mb-2 d-block el__w100">Przeadresuj swoją przesyłkę</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <section class="article article--page mt-lg-5">
        <div class="container">
            <div class="row align-items-center align-items-lg-start">
                <div class="col-12 col-md-6 order-2 order-lg-1">
                    <img class="img-fluid"
                         src="<?= esc_url(Assets\asset_path('images/mapa_img.png', 'asset-sources/dhlknowledge/dist')); ?>"
                         alt="">
                </div>
                <div class="col-12 col-md-6 order-1 order-lg-2">
                    <h2>Lorem ipsum dolor sit, consectetur adipiscing </h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur
                        ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                        Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu,
                        consequat nec accumsan quis, tempor quis leo. </p>
                </div>
            </div>
        </div>
    </section>


    <section class="article_blog mb-0 mb-md-5 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--gray-light">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
                            <span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--gray-light">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
                            <span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--gray-light">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
                            <span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="homeinfo">
        <div class="container">
            <span class="font__title--022 font__color--gray text-uppercase text-center text-lg-left d-block mb-3">Lorem ipsum dolor sit, <br>consectetur adipiscing <br>elit In ut mollis.</span>
            <div class="row d-flex justify-content-center justify-content-lg-start homeinfo--container">
                <div class="col-12 col-md-6 col-lg-4 align-self-end homeinfo--item">
                    <div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
                        <img class="img-fluid"
                             src="<?= esc_url(Assets\asset_path('images/hs_01.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                    </div>
                    <span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left">KARIERA W DHL</span>
                    <span class="font__subtitle--0222 homeinfo--subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
                    <hr>
                </div>
                <div class="col-12 col-md-6 col-lg-4 align-self-center homeinfo--item">
                    <div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
                        <img class="img-fluid"
                             src="<?= esc_url(Assets\asset_path('images/hs_02.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                    </div>
                    <span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left">Wsparcia dla e-commerce</span>
                    <span class="font__subtitle--0222 homeinfo--subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
                    <hr>
                </div>
                <div class="col-12 col-md-6 col-lg-4 align-self-start homeinfo--item">
                    <div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
                        <img class="img-fluid"
                             src="<?= esc_url(Assets\asset_path('images/hs_03.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                    </div>
                    <span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left">NASZE USŁUGI</span>
                    <span class="font__subtitle--0222 homeinfo--subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
                    <hr>
                </div>
            </div>
        </div>
    </section>

    <section class="article_blog article_blog--home bg__color--gray-light">
        <div class="container">
            <span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block">Aktualności - alerty</span>
            <div class="row slick-slider">
                <div class="col-12 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--white">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
                            <span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--white">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
                            <span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--white">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
                            <span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--white">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
                            <span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--white">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
                            <span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 mb-4 mb-lg-0">
                    <div class="article_blog--item bg__color--white">
                        <img class="img-fluid w-100"
                             src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div class="article_blog--desc">
                            <span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
                            <span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php ?>


<?php /* // O nas page ?>

<div class="article article--page">
	<div class="container">
		<p>
		<img class="alignleft" src="<?= esc_url(Assets\asset_path('images/about_us.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
		</p>
		<h2 class="article--page--title">Lorem ipsum dolor sit, consectetur adipiscing elit In ut mollis.</h2>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. Aenean accumsan tristique augue, fermentum cursus erat bibendum et. </p>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a.</p>
		<p><br>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. Aenean accumsan tristique augue, fermentum cursus erat bibendum et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. Aenean accumsan tristique augue, fermentum cursus erat bibendum et. </p>

		<div class="row  mb-0 mb-xl-5 pb-xxl-4 article--page--category justify-content-center justify-content-lg-start">
			<div class="col-12 col-sm-6 col-lg-4">
				<div class="blog_category--item blog_category--item--no-padding text-center text-lg-left">
					<div class="blog_category--ico blog_category--ico--article d-flex align-items-center justify-content-center justify-content-lg-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Cena i czas transportu</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-4">
				<div class="blog_category--item blog_category--item--no-padding text-center text-lg-left">
					<div class="blog_category--ico blog_category--ico--article d-flex align-items-center justify-content-center justify-content-lg-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Cena i czas transportu</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-4">
				<div class="blog_category--item blog_category--item--no-padding text-center text-lg-left">
					<div class="blog_category--ico blog_category--ico--article d-flex align-items-center justify-content-center justify-content-lg-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Cena i czas transportu</span>
					</div>
				</div>
			</div>
		</div>
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. Aenean accumsan tristique augue, fermentum cursus erat bibendum et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. Aenean accumsan tristique augue, fermentum cursus erat bibendum et. </p>
	</div>

	<section class="full_carousel">
		<div class="container--carousel">
			<div class="slick slick-slider-fw">
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
				<div><img class="w-100" src="<?= esc_url(Assets\asset_path('images/fw_slider.png', 'asset-sources/dhlknowledge/dist')); ?>" alt=""></div>
			</div>
		</div>
	</section>

	<div class="container">
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. Aenean accumsan tristique augue, fermentum cursus erat bibendum et. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam sit amet augue sed sem efficitur ultrices. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean hendrerit mi justo, eget elementum massa egestas a. Ut nec erat nibh. Nam enim arcu, consequat nec accumsan quis, tempor quis leo. Aenean accumsan tristique augue, fermentum cursus erat bibendum et. </p>
	</div>
</div>



<div class="container">
	<hr>
</div>



<section class="blog_category mt-5 pt-0 pt-xl-5 mb-5 pb-0 pb-xl-5">
	<div class="container">
		<span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-5">DOWIEDZ SIĘ WIĘCEJ</span>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Cena i czas transportu</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Oferta/ SL</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Znajdź DHL servicepoint</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_04.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Poradnik wysyłkowy</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php */ ?>


    <?php /*
<section class="slider">
	<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	  <ol class="carousel-indicators">
	    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
	    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	  </ol>
	  <div class="carousel-inner">
	    <div class="carousel-item active">
	      <img class="d-block w-100" src="<?= esc_url(Assets\asset_path('images/slide_01.jpg', 'asset-sources/dhlknowledge/dist')); ?>" alt="First slide">

	      <div class="carousel-caption text-left d-flex align-items-center justify-content-center">
	      	<div class="container">
		        <div class="row">
		            <div class="col-12 col-lg-7 col-xl-5 pb-5 pb-md-1">
		                <span class="background_image--title d-block font__title--01 font__color--gray">Wyślij szybką <br>przesyłkę <br>zagraniczną!</span>
		                <p class="font__color--dark-gray font__subtitle--022 pb-2 pb-md-4">Działamy kompleksowo i niezawodnie.</p>
		                <a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase" href="#" target="_self">ZOBACZ WIĘCEJ</a>
		            </div>
		        </div>
		    </div>
		  </div>

	    </div>
	    <div class="carousel-item">
	      <img class="d-block w-100" src="<?= esc_url(Assets\asset_path('images/slide_01.jpg', 'asset-sources/dhlknowledge/dist')); ?>" alt="Second slide">

	      <div class="carousel-caption text-left d-flex align-items-center justify-content-center">
	      	<div class="container">
		        <div class="row">
		            <div class="col-12 col-lg-7 col-xl-5 pb-5 pb-md-1">
		                <span class="background_image--title d-block font__title--01 font__color--gray">Wyślij szybką <br>przesyłkę <br>zagraniczną!</span>
		                <p class="font__color--dark-gray font__subtitle--022 pb-2 pb-md-4">Działamy kompleksowo i niezawodnie.</p>
		                <a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase" href="#" target="_self">ZOBACZ WIĘCEJ</a>
		            </div>
		        </div>
		    </div>
		  </div>

	    </div>
	    <div class="carousel-item">
	      <img class="d-block w-100" src="<?= esc_url(Assets\asset_path('images/slide_01.jpg', 'asset-sources/dhlknowledge/dist')); ?>" alt="Third slide">

	      <div class="carousel-caption text-left d-flex align-items-center justify-content-center">
	      	<div class="container">
		        <div class="row">
		            <div class="col-12 col-lg-7 col-xl-5 pb-5 pb-md-1">
		                <span class="background_image--title d-block font__title--01 font__color--gray">Wyślij szybką <br>przesyłkę <br>zagraniczną!</span>
		                <p class="font__color--dark-gray font__subtitle--022 pb-2 pb-md-4">Działamy kompleksowo i niezawodnie.</p>
		                <a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase" href="#" target="_self">ZOBACZ WIĘCEJ</a>
		            </div>
		        </div>
		    </div>
		  </div>

	    </div>
	  </div>
	  <a class="d-none carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
	    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="d-none carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
	    <span class="carousel-control-next-icon" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
	<div class="slider_search">
		<div class="container">
			<form method="GET" action="https://www.logistics.dhl/pl-pl/home/tracking.html" target="_blank">
				<div class="row">
					<div class="col-12 col-lg-3 mb-4 mb-lg-0 d-flex align-items-center justify-content-center">
						<span class="text-uppercase text-white font__title--4">Śledzenie przesyłki</span>
					</div>
					<div class="col-12 col-lg-6">
						<input type="text" name="tracking-id" class="form-control tracking_nr" id="email" name="email" placeholder="Podaj numer przesyłki">
						<input type="hidden" name="submit">
					</div>
					<div class="col-12 col-lg-3 mt-2 mt-lg-0 text-center">
						<button type="submit" role="button" class="d-block btn--check w-100">SPRAWDŹ</button>
						<a rel="nofollow" target="_blank"  title="Zarządzaj dostawą przesyłki" href="https://delivery.dhl.com/prg/waybill.xhtml?ctrycode=PL" class="el__poa text-white mt-3 mt-md-2 mb-2 d-block el__w100">Przeadresuj swoją przesyłkę</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>




<section class="blog_category">
	<div class="container">
		<span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-5">Jak ci możemy pomóc?</span>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Cena i czas transportu</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Oferta/ SL</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Znajdź DHL servicepoint</span>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-6 col-lg-3">
				<div class="blog_category--item blog_category--item--home bg__color--gray-light text-center text-md-left">
					<div class="blog_category--ico blog_category--ico--home d-flex align-items-center justify-content-center justify-content-md-start">
						<img src="<?= esc_url(Assets\asset_path('images/ico_h_04.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					</div>
					<hr>
					<div class="blog_category--name">
						<span class="font__title--06 mb-1 mt-4 d-block font__color--red text-uppercase">LOREM IPSUM</span>
						<span class="font__title--05 text-uppercase font__color--gray">Poradnik wysyłkowy</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<div class="container">
	<hr>
</div>

<section class="homeinfo">
	<div class="container">
		<span class="font__title--022 font__color--gray text-uppercase text-center text-lg-left d-block mb-3">Lorem ipsum dolor sit, <br>consectetur adipiscing <br>elit In ut mollis.</span>
		<div class="row d-flex justify-content-center justify-content-lg-start homeinfo--container">
			<div class="col-12 col-md-6 col-lg-4 align-self-end homeinfo--item">
				<div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
					<img class="img-fluid" src="<?= esc_url(Assets\asset_path('images/hs_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
				</div>
				<span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left">KARIERA W DHL</span>
				<span class="font__subtitle--0222 homeinfo--subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
				<hr>
			</div>
			<div class="col-12 col-md-6 col-lg-4 align-self-center homeinfo--item">
				<div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
					<img class="img-fluid" src="<?= esc_url(Assets\asset_path('images/hs_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
				</div>
				<span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left">Wsparcia dla e-commerce</span>
				<span class="font__subtitle--0222 homeinfo--subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
				<hr>
			</div>
			<div class="col-12 col-md-6 col-lg-4 align-self-start homeinfo--item">
				<div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
					<img class="img-fluid" src="<?= esc_url(Assets\asset_path('images/hs_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
				</div>
				<span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left">NASZE USŁUGI</span>
				<span class="font__subtitle--0222 homeinfo--subtitle">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
				<hr>
			</div>
		</div>
	</div>
</section>

<section class="article_blog article_blog--home bg__color--gray-light">
	<div class="container">
	<span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block">Aktualności - alerty</span>
		<div class="row slick-slider">
			<div class="col-12 mb-4 mb-lg-0">
				<div class="article_blog--item bg__color--white">
					<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					<div class="article_blog--desc">
						<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
						<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
					</div>
				</div>
			</div>
			<div class="col-12 mb-4 mb-lg-0">
				<div class="article_blog--item bg__color--white">
					<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					<div class="article_blog--desc">
						<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
						<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
					</div>
				</div>
			</div>
			<div class="col-sm-12 mb-4 mb-lg-0">
				<div class="article_blog--item bg__color--white">
					<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					<div class="article_blog--desc">
						<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
						<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
					</div>
				</div>
			</div>
			<div class="col-12 mb-4 mb-lg-0">
				<div class="article_blog--item bg__color--white">
					<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					<div class="article_blog--desc">
						<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
						<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
					</div>
				</div>
			</div>
			<div class="col-12 mb-4 mb-lg-0">
				<div class="article_blog--item bg__color--white">
					<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					<div class="article_blog--desc">
						<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
						<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
					</div>
				</div>
			</div>
			<div class="col-sm-12 mb-4 mb-lg-0">
				<div class="article_blog--item bg__color--white">
					<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
					<div class="article_blog--desc">
						<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
						<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>






    <?php get_template_part('templates/knowledge/header-new'); ?>

	<!-- Baza Szukajka -->

	<section class="search_blog">
    	<div class="container">
    	<span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3">Lorem impsum dolor</span>
    	<span class="font__subtitle--0222 d-none d-sm-block text-center mb-4">&nbsp;<br>&nbsp;</span>
    		<div class="row">
    			<div class="col-12 col-lg-8 mx-auto">
    				<div class="row">
    					<div class="col-12 col-sm-8 col-lg-8 col-xl-9">
							<div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="">
                            </div>
						</div>
						<div class="col-12 col-sm-4 col-lg-4 col-xl-3">
							<div class="form-group">
                                <button class="btn w-100 btn--auto btn--red btn-primary btn--calc form-new-send"><?= Polylang\t9n('SZUKAJ'); ?></button>
                            </div>
						</div>
    				</div>
    			</div>
    		</div>
    		<div class="row mt-4 pt-sm-5">
    			<div class="col-12 col-lg-10 mx-auto text-center pt-1">
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2 font__subtitle--0222 active">Artykuły z bazy wiedzy (6)</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2 font__subtitle--0222">Dokumenty (4)</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2 font__subtitle--0222">Pytania i odpowiedzi (1)</button>
    			</div>
    		</div>
	    </div>
	</section>

	<section class="article_blog">
    	<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
							<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
							<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
							<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
			</div>
			<div class="more_btn text-center">
				<a class="btn btn--auto btn--red btn-primary btn--calc form-new-send d-block d-sm-inline-block" href="#">ZOBACZ WIĘCEJ</a>
			</div>
    	</div>
    </section>

	<div class="clearfix"></div>

	<!-- end Baza Szukajka -->








	<!-- Baza News -->

	<?php get_template_part('templates/knowledge/header-new'); ?>

	<section class="article">
    <div class="container">
        <div class="categories">
            <span class="cat-name">Poradnik wysyłkowy</span>
        </div>
        <h2>Jak zapłacić cło online?</h2>
        <div class="contest">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.</p>
<p><img class="size-full wp-image-2236 aligncenter" src="http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/content_image.jpg" alt="" width="819" height="562" srcset="http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/content_image.jpg 819w, http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/content_image-300x206.jpg 300w, http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/content_image-768x527.jpg 768w, http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/content_image-750x515.jpg 750w" sizes="(max-width: 819px) 100vw, 819px" /></p>
<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
<p>Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.</p>
<p><img class="size-full wp-image-2413 alignleft" src="http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/conten_image2.jpg" alt="" width="632" height="532" srcset="http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/conten_image2.jpg 632w, http://dhl.mintmedia.ourworks.pl/wp-content/uploads/2019/11/conten_image2-300x253.jpg 300w" sizes="(max-width: 632px) 100vw, 632px" /></p>
<p><br>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.</p>
<ul>
<li>Phasellus tincidunt risus eget blandit egestas.</li>
<li>Sed tincidunt libero vel purus consequat rhoncus.</li>
<li>Integer vel felis fermentum, suscipit orci in</li>
<li>Praesent dictum massa sed felis lobortis, eu consectr</li>
<li>tellus volutpat. Interdum et malesuada</li>
</ul>
<p>&nbsp;</p>
<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
<p>Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.</p>
        </div>
    </div>
</section>


	<!--section class="article">
		<div class="container">
			<span class="cat-name">Wiedza celna</span>
			<h2>Jak zapłacić cło online?</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
			<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.
			</p>
			<p>
				<img class="aligncenter" src="<?= esc_url(Assets\asset_path('images/content_image.jpg', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
			</p>

			<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
			<p>Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
			<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.</p>
			<p>
			<img class="alignleft" src="<?= esc_url(Assets\asset_path('images/content_image2.jpg', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
			</p>
			<p>&nbsp;</p>
			<p>
				Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.
			</p>

			<ul>
				<li>Phasellus tincidunt risus eget blandit egestas. </li>
				<li>Sed tincidunt libero vel purus consequat rhoncus. </li>
				<li>Integer vel felis fermentum, suscipit orci in</li>
				<li>Praesent dictum massa sed felis lobortis, eu consectr </li>
				<li>tellus volutpat. Interdum et malesuada </li>
			</ul>
			<p>&nbsp;</p>
			<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
			<p>Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
			<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.</p>

		</div>
	</section-->

	<section class="related_files">
		<div class="container">
			<span class="d-block font__title--4 font__color--red">Materiały powiązane</span>
			<div class="row related_files--items">
				<div class="col-md-6 col-lg-4">
					<a class="related_files--file-link font__subtitle--16-2 font__color--default d-flex align-items-center" href="#">List gwarancyjny dotyczący sankcji sektorowych (Rosja)</a>
				</div>
				<div class="col-md-6 col-lg-4">
					<a class="related_files--file-link font__subtitle--16-2 font__color--default d-flex align-items-center" href="#">List gwarancyjny dotyczący sankcji sektorowych (Rosja)</a>
				</div>
				<div class="col-md-6 col-lg-4">
					<a class="related_files--file-link font__subtitle--16-2 font__color--default d-flex align-items-center" href="#">List gwarancyjny dotyczący sankcji sektorowych (Rosja)</a>
				</div>
			</div>
			<hr>
		</div>
	</section>

	<section class="article_blog">
    	<div class="container">
    	<span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block">CZYTAJ TEŻ</span>
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
							<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
							<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
						</div>
					</div>
				</div>
			</div>
    	</div>
    </section>

    <section class="newsletter_form bg__color--gray-light d-flex align-items-center pt-4 pb-4 pt-sm-0 pb-sm-0">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<span class="font__title--022 font__color--gray text-uppercase d-block mb-3 text-center text-sm-left">Newsletter</span>
					<span class="font__subtitle--0222 d-block mb-4 text-center text-sm-left">Zostaw swój adres email, na który otrzymasz <br>informacje o promocjach i pomocne <br>materiały.</span>
					<form action="" class="mt-1">
						<div class="row">
							<div class="col-12 col-sm-8 col-lg-7">
								<div class="form-group">
	                                <input type="text" class="form-control" id="email" name="email" placeholder="<?= Polylang\t9n('Adres e-mail'); ?>">
	                            </div>
							</div>
							<div class="col-12 col-sm-4 col-lg-5">
								<div class="form-group">
	                                <button class="btn btn--auto btn--red btn-primary btn--calc form-new-send d-block d-sm-inline-block"><?= Polylang\t9n('WYŚLIJ'); ?></button>
	                            </div>
							</div>
							<div class="col-lg-12">
								<label for="newsletterTermsConsent" class="mt-2 form-check-label newsletter__label newsletter__label--checkbox">
	                                <input id="newsletterTermsConsent" type="checkbox" name="terms-consent" value="tak" class="form-check-input newsletter__input newsletter__input--checkbox" data-newsletter-input="">
	                                Tak, zapoznałem się z <a href="http://dhl.localhost/regulamin-uslugi-newsletter" target="_blank">Regulaminem</a>. Akceptuję jego treść <br>i chcę otrzymywać aktualne informacje i materiały premium.</label>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>


	<!-- end Baza News -->
<?php /*
	<section class="article_blog">
    	<div class="container">
    	<span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block">Sprawdź naszego bloga</span>
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
							<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
							<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
						</div>
					</div>
				</div>
			</div>
			<div class="more_btn text-center">
				<a class="btn btn--auto btn--red btn-primary btn--calc form-new-send d-block d-sm-inline-block" href="#">ZOBACZ WIĘCEJ</a>
			</div>
    	</div>
    </section>

	<div class="clearfix mb-5"></div>

<!-- Dokumenty -->
	<section class="search_blog">
    	<div class="container">
    	<span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3">Dokumenty</span>
    	<span class="font__subtitle--0222 d-block text-center mb-3 mb-sm-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis <br>tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
    		<div class="row">
    			<div class="col-12 col-lg-10 mx-auto text-center pt-1">
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2 active">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    			</div>
    		</div>
	    </div>
	</section>

	<section class="file_post">
    	<div class="container">
			<div class="row">
				<div class="col-md-12 col-lg-10 col-xl-8 mx-auto">
					<div class="file_post--item row">
						<div class="col-sm-9 col-lg-10 font__title--06 text-uppercase font__color--red d-flex align-items-center">
							<span class="file_post--file-ico">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
						</div>
						<div class="col-sm-3 col-lg-2 d-flex align-items-center justify-content-sm-end">
							<a class="btn--yellow font__subtitle--0222 d-block d-sm-inline text-center w-100 mt-3 mt-sm-0" href="#">POBIERZ</a>
						</div>
					</div>
					<div class="file_post--item row">
						<div class="col-sm-9 col-lg-10 font__title--06 text-uppercase font__color--red d-flex align-items-center">
							<span class="file_post--file-ico">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
						</div>
						<div class="col-sm-3 col-lg-2 d-flex align-items-center justify-content-sm-end">
							<a class="btn--yellow font__subtitle--0222 d-block d-sm-inline text-center w-100 mt-3 mt-sm-0" href="#">POBIERZ</a>
						</div>
					</div>
					<div class="file_post--item row">
						<div class="col-sm-9 col-lg-10 font__title--06 text-uppercase font__color--red d-flex align-items-center">
							<span class="file_post--file-ico">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span>
						</div>
						<div class="col-sm-3 col-lg-2 d-flex align-items-center justify-content-sm-end">
							<a class="btn--yellow font__subtitle--0222 d-block d-sm-inline text-center w-100 mt-3 mt-sm-0" href="#">POBIERZ</a>
						</div>
					</div>
				</div>
			</div>

			<nav aria-label="Page navigation">
			  <ul class="pagination justify-content-center">
			    <li class="page-item">
			      <a class="page-link" href="#" aria-label="Previous">
			        <span aria-hidden="true">
			        	<img class="page-image" src="<?= esc_url(Assets\asset_path('images/paginate_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="<">
			        </span>
			      </a>
			    </li>
			    <li class="page-item"><a class="page-link" href="#">1</a></li>
			    <li class="page-item"><a class="page-link active" href="#">2</a></li>
			    <li class="page-item"><a class="page-link">...</a></li>
			    <li class="page-item"><a class="page-link" href="#">3</a></li>
			    <li class="page-item">
			      <a class="page-link" href="#" aria-label="Next">
			        <span aria-hidden="true">
			        	<img class="page-image el__rotate" src="<?= esc_url(Assets\asset_path('images/paginate_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="" />
			        </span>
			      </a>
			    </li>
			  </ul>
			</nav>

    	</div>
    	<hr>
    </section>
<!-- end Dokumenty -->


<!-- Podstrona -->
	<section class="search_blog">
    	<div class="container">
    	<span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3">Lorem impsum dolor</span>
    	<span class="font__subtitle--0222 d-block text-center mb-3 mb-sm-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis <br>tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
    		<div class="row">
    			<div class="col-12 col-lg-10 mx-auto text-center pt-1">
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2 active">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    				<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2">FIltr numer 1</button>
    			</div>
    		</div>
	    </div>
	</section>
	<section class="article_blog">
    	<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
							<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
							<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
							<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
							<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
						</div>
					</div>
				</div>
			</div>

			<nav aria-label="Page navigation">
			  <ul class="pagination justify-content-center">
			    <li class="page-item">
			      <a class="page-link" href="#" aria-label="Previous">
			        <span aria-hidden="true">
			        	<img class="page-image" src="<?= esc_url(Assets\asset_path('images/paginate_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="<">
			        </span>
			      </a>
			    </li>
			    <li class="page-item"><a class="page-link" href="#">1</a></li>
			    <li class="page-item"><a class="page-link active" href="#">2</a></li>
			    <li class="page-item"><a class="page-link">...</a></li>
			    <li class="page-item"><a class="page-link" href="#">3</a></li>
			    <li class="page-item">
			      <a class="page-link" href="#" aria-label="Next">
			        <span aria-hidden="true">
			        	<img class="page-image el__rotate" src="<?= esc_url(Assets\asset_path('images/paginate_arrow.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="" />
			        </span>
			      </a>
			    </li>
			  </ul>
			</nav>
			<hr>
    	</div>

    </section>



    <section class="popular_questions">
		<div class="container">
			<span class="popular_questions--title font__title--022 font__color--gray text-center text-uppercase d-block">Najczęściej zadawane pytania</span>
			<div class="row">
				<div class="col-md-12 col-lg-10 mx-auto">



					 <div class="accordion list" id="accordion">
				        <div class="card">
				            <div class="card-header" id="heading1">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c1" aria-expanded="false" aria-controls="c1">
				                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				                    </button>
				                </h2>
				            </div>
				            <div id="c1" class="collapse" aria-labelledby="heading1" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>
				        <div class="card">
				            <div class="card-header" id="heading2">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c2" aria-expanded="false" aria-controls="c2">
				                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				                    </button>
				                </h2>
				            </div>
				            <div id="c2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>
				        <div class="card">
				            <div class="card-header" id="heading3">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c3" aria-expanded="false" aria-controls="c3">
				                    Lorem ipsum dolor sit amet.
				                    </button>
				                </h2>
				            </div>
				            <div id="c3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>
				        <div class="card">
				            <div class="card-header" id="heading4">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c4" aria-expanded="false" aria-controls="c4">
				                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				                    </button>
				                </h2>
				            </div>
				            <div id="c4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>

				    </div>
				</div>
			</div>
		</div>
	</section>

	<!-- end Podstrona -->

	<!-- Baza wiedzy -->
	 <section class="search_blog">
    	<div class="container">
    	<span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3">Lorem impsum dolor</span>
    	<span class="font__subtitle--0222 d-block text-center mb-4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In ut mollis <br>tellus, nec tempus mauris. Mauris vitae nibh ex.</span>
    		<div class="row">
    			<div class="col-12 col-lg-8 mx-auto">
    				<div class="row">
    					<div class="col-12 col-sm-8 col-lg-8 col-xl-9">
							<div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="">
                            </div>
						</div>
						<div class="col-12 col-sm-4 col-lg-4 col-xl-3">
							<div class="form-group">
                                <button class="btn w-100 btn--auto btn--red btn-primary btn--calc form-new-send"><?= Polylang\t9n('SZUKAJ'); ?></button>
                            </div>
						</div>
    				</div>
    			</div>
    		</div>
	    </div>
	</section>

	<section class="blog_category">
		<div class="container">
			<div class="row">
				<div class="col-12 col-sm-6 col-md-4">
					<div class="blog_category--item bg__color--gray-light text-center text-md-left">
						<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
							<img src="<?= esc_url(Assets\asset_path('images/ico_bw_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						</div>
						<hr>
						<div class="blog_category--name">
							<span class="font__title--05 text-uppercase font__color--gray">poradnik wysyłkowy</span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4">
					<div class="blog_category--item bg__color--gray-light text-center text-md-left">
						<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
							<img src="<?= esc_url(Assets\asset_path('images/ico_bw_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						</div>
						<hr>
						<div class="blog_category--name">
							<span class="font__title--05 text-uppercase font__color--gray">wiedza celna</span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4">
					<div class="blog_category--item bg__color--gray-light text-center text-md-left">
						<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
							<img src="<?= esc_url(Assets\asset_path('images/ico_bw_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						</div>
						<hr>
						<div class="blog_category--name">
							<span class="font__title--05 text-uppercase font__color--gray">DOKUMENTY</span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4">
					<div class="blog_category--item bg__color--gray-light text-center text-md-left">
						<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
							<img src="<?= esc_url(Assets\asset_path('images/ico_bw_04.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						</div>
						<hr>
						<div class="blog_category--name">
							<span class="font__title--05 text-uppercase font__color--gray">Wysyłane towary</span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4">
					<div class="blog_category--item bg__color--gray-light text-center text-md-left">
						<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
							<img src="<?= esc_url(Assets\asset_path('images/ico_bw_05.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						</div>
						<hr>
						<div class="blog_category--name">
							<span class="font__title--05 text-uppercase font__color--gray">FAQ</span>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-6 col-md-4">
					<div class="blog_category--item bg__color--gray-light text-center text-md-left">
						<div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
							<img src="<?= esc_url(Assets\asset_path('images/ico_bw_06.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						</div>
						<hr>
						<div class="blog_category--name">
							<span class="font__title--05 text-uppercase font__color--gray">pytania i odpowiedzi?</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<section class="popular_questions">
		<div class="container">
			<span class="popular_questions--title font__title--022 font__color--gray text-center text-uppercase d-block">Najczęściej zadawane pytania</span>
			<div class="row">
				<div class="col-md-12 col-lg-10 mx-auto">



					 <div class="accordion" id="accordion">
				        <div class="card">
				            <div class="card-header" id="heading1">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c1" aria-expanded="false" aria-controls="c1">
				                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				                    </button>
				                </h2>
				            </div>
				            <div id="c1" class="collapse" aria-labelledby="heading1" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>
				        <div class="card">
				            <div class="card-header" id="heading2">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c2" aria-expanded="false" aria-controls="c2">
				                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				                    </button>
				                </h2>
				            </div>
				            <div id="c2" class="collapse" aria-labelledby="heading2" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>
				        <div class="card">
				            <div class="card-header" id="heading3">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c3" aria-expanded="false" aria-controls="c3">
				                    Lorem ipsum dolor sit amet.
				                    </button>
				                </h2>
				            </div>
				            <div id="c3" class="collapse" aria-labelledby="heading3" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>
				        <div class="card">
				            <div class="card-header" id="heading4">
				                <h2 class="mb-0">
				                    <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed" type="button" data-toggle="collapse" data-target="#c4" aria-expanded="false" aria-controls="c4">
				                    Lorem ipsum dolor sit amet, consectetur adipiscing elit.
				                    </button>
				                </h2>
				            </div>
				            <div id="c4" class="collapse" aria-labelledby="heading4" data-parent="#accordion">
				                <div class="card-body font__subtitle--0222">
				                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in faucibus.</p>
				                </div>
				            </div>
				        </div>

				    </div>
				</div>
			</div>
		</div>
	</section>



	<section class="newsletter_form bg__color--gray-light d-flex align-items-center pt-4 pb-4 pt-sm-0 pb-sm-0">
		<div class="container">
			<div class="row">
				<div class="col-lg-6">
					<span class="font__title--022 font__color--gray text-uppercase d-block mb-3 text-center text-sm-left">Newsletter</span>
					<span class="font__subtitle--0222 d-block mb-4 text-center text-sm-left">Zostaw swój adres email, na który otrzymasz <br>informacje o promocjach i pomocne <br>materiały.</span>
					<form action="" class="mt-1">
						<div class="row">
							<div class="col-12 col-sm-8 col-lg-7">
								<div class="form-group">
	                                <input type="text" class="form-control" id="email" name="email" placeholder="<?= Polylang\t9n('Adres e-mail'); ?>">
	                            </div>
							</div>
							<div class="col-12 col-sm-4 col-lg-5">
								<div class="form-group">
	                                <button class="btn btn--auto btn--red btn-primary btn--calc form-new-send d-block d-sm-inline-block"><?= Polylang\t9n('WYŚLIJ'); ?></button>
	                            </div>
							</div>
							<div class="col-lg-12">
								<label for="newsletterTermsConsent" class="mt-2 form-check-label newsletter__label newsletter__label--checkbox">
	                                <input id="newsletterTermsConsent" type="checkbox" name="terms-consent" value="tak" class="form-check-input newsletter__input newsletter__input--checkbox" data-newsletter-input="">
	                                Tak, zapoznałem się z <a href="http://dhl.localhost/regulamin-uslugi-newsletter" target="_blank">Regulaminem</a>. Akceptuję jego treść <br>i chcę otrzymywać aktualne informacje i materiały premium.</label>

							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>




    <section class="article_blog">
    	<div class="container">
    	<span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block">Sprawdź naszego bloga</span>
			<div class="row">
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_01.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak zamówić kuriera do domu?</span>
							<span class="font__subtitle--16-2">Przesyłanie paczek za pośrednictwem kuriera ma bardzo wiele zalet. Najważniejszą z nich jest czas transportu. Jest on na ogół o wiele </span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_02.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak odpowiednio zapakować przesyłkę?</span>
							<span class="font__subtitle--16-2">Flamaster, klej, papier, taśma, nożyczki. Czy zastanawiałeś się jak zapakujesz swoją przesyłkę?</span>
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0">
					<div class="article_blog--item bg__color--gray-light">
						<img class="img-fluid w-100" src="<?= esc_url(Assets\asset_path('images/blog_03.png', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
						<div class="article_blog--desc">
							<span class="d-block font__title--04 font__color--gray mb-3">Jak naszybciej wysłać przesyłkę za granicę?</span>
							<span class="font__subtitle--16-2">Każdy chciałby, żeby przesyłki kurierskie i przesyłki zagraniczne docierały do odbiorcy jak najszybciej, najlepiej...</span>
						</div>
					</div>
				</div>
			</div>
    	</div>
    </section>
<!-- Baza wiedzy -->
*/ ?>
    <?php get_template_part('templates/knowledge/prefooter'); ?>
<?php endwhile; ?>