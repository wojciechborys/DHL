<?php
/**
 * Template name: [Baza wiedzy] newhome
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>

<?php while (have_posts()) : the_post(); ?>

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


	<section class="article">
		<div class="container">
			<span class="cat-name">Wiedza celna</span>
			<h2>Jak zapłacić cło online?</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
			<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.
			</p>
			<p class="text-center">
				<img class="img-fluid mx-auto" src="<?= esc_url(Assets\asset_path('images/content_image.jpg', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
			</p>

			<h3>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h3>
			<p>Sed consectetur libero eros. Integer semper aliquam nibh, id lobortis diam rhoncus id. Phasellus tincidunt risus eget blandit egestas. Sed tincidunt libero vel purus consequat rhoncus. Integer vel felis fermentum, suscipit orci in, pretium massa. Praesent dictum massa sed felis lobortis, eu consectetur tellus volutpat. Interdum et malesuada fames ac ante ipsum primis in fauc</p>
			<p>Vivamus magna turpis, dignissim et convallis ac, lacinia at elit. Donec varius lectus at est convallis, id pellentesque tortor eleifend. Sed sit amet elementum augue, vel dignissim tellus. Nulla placerat ornare justo mollis finibus. Sed imperdiet libero magna, ac convallis elit molestie eget. Nulla nec sollicitudin tellus, vel finibus erat. Nullam faucibus nulla augue, sed venenatis felis finibus eget. Donec eget sem tortor.</p>

			<img class="img-fluid d-block mx-auto float-xl-left mr-xl-5" src="<?= esc_url(Assets\asset_path('images/content_image2.jpg', 'asset-sources/dhlknowledge/dist')); ?>" alt="">
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
	</section>

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

    <?php get_template_part('templates/knowledge/prefooter'); ?>
<?php endwhile; ?>