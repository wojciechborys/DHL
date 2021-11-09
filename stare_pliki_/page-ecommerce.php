<?php
/**
 * Template name: [Świat] Ecommerce
 */

use SD\Template\Tags;
?>

<header class="ecommerce">
    <div class="container-fluid ecommerce__banner">
        <div class="row">
            <?php
            $banner = get_field('ecommerce_banner');
            if ($banner): ?>
                <div class="col-12 col-md-6 banner__image"
                     style="background-image: url('<?php echo $banner['image']['url'] ?>');">
                </div>
                <div class="col-12 col-md-6 banner__info d-flex align-items-center text-center text-md-left">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-7">
                                <h2 class="banner__title"><?php echo $banner['title'] ?></h2>
                                <p class="banner__description mt-4 mb-5"><?php echo $banner['description'] ?></p>
                                <a class="banner__button"
                                   href="<?php echo $banner['button']['url'] ?>"><?php echo $banner['button']['button-txt'] ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            endif;
            ?>

        </div>
    </div>
</header>
<section style="overflow-x: hidden;">
    <div class="container about-dhl">
        <div class="row">
            <div class="col-12 col-md-6 order-1 pb-4 text-center text-md-left">
                <h2 class="about-dhl__title">Otwórz się na świat </h2>
                <p class="about-dhl__desc">DHL Express od lat wspiera firmy w handlu transgranicznym </p>
            </div>
            <div class="col-12 order-3 order-md-2 col-md-6">
                <div class="owl-nav customNavigation text-center text-md-right">
                </div>
            </div>
            <div class="col-12 order-2 order-md-3 about-dhl__slider">
                <?php
                // check if the repeater field has rows of data
                if (have_rows('ecommerce-about')):

                    // loop through the rows of data
                    while (have_rows('ecommerce-about')) : the_row();
                        $image = get_sub_field('ico');
                        ?>
                        <div class="">
                            <div class="box-about box-about__gray">
                                <div class="box-about__ico">
                                    <img class="ico" src="<?php the_sub_field('ico') ?>"
                                         alt="ico">
                                </div>
                                <div class="box-about__text">
                                    <p class="text"><?php echo the_sub_field('desc') ?></p>
                                </div>
                            </div>
                        </div>

                    <?php endwhile;
                endif; ?>
            </div>
        </div>
    </div>
</section>
<section class="py-4 dhl-simple">
    <div class="container dhl-simple__bg">
        <?php $posts_slider_classic = get_field('posts-slider-classic');
        if ($posts_slider_classic) :
            ?>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2 class="dhl-simple__title">
                        <?php echo $posts_slider_classic['title']; ?>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12 dhl-slider-1">
                    <?php
                    foreach ($posts_slider_classic['post-classic'] as $index => $single_item) {
                        ?>
                        <div class="">
                            <div class="dhl-simple__box-post">
                                <a class="box-post__link" href="<?php echo get_the_permalink($single_item->ID); ?>">
                                    <div class="box-post-image">
                                        <?php $topImageSrc = Tags\getTopImageSrc($single_item->ID); ?>
                                        <img src="<?php echo esc_url($topImageSrc); ?>" alt=""
                                             class="mw-100">
                                    </div>
                                    <div class="box-post-info text-center text-sm-left">
                                        <p class="box-post-info__cat text-uppercase">news</p>
                                        <h5 class="box-post-info__title"><?php echo get_the_title($single_item->ID); ?></h5>
                                        <div class="box-post-info__read-more">
                                            <p class="box-post-info__link text-uppercase" target="_blank">Czytaj
                                                więcej</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>

        <?php endif; ?>
    </div>
</section>
<section class="globe sidebar-open">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-9 globe-canvas">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-xl-4">
                            <h2 class="globe__title text-center text-lg-left">
                                W jakim kierunku <br> chcesz rozwijać <br>e-biznes?
                            </h2>
                        </div>
                        <div class="col-12 col-xl-8 mb-4 mb-lg-0">
                            <div id="main-col">
                                <div id="myearth" class="little-earth">
                                    <div id="tip-layer">
                                        <div>
                                            <div id="tip-big"></div>
                                            <div id="tip-small"></div>
                                        </div>
                                    </div>
                                    <!--                                    <div id="button-reset"></div>-->
                                </div>
                            </div><!--main-col-->
                            <div id="side-col" class="d-none">
                                <div>
                                    <h2>From</h2>
                                    <select id="from" onchange="if ( ! this.getAttribute('disabled') ) selectFrom();">
                                        <option></option>
                                    </select>

                                    <h2>To</h2>
                                    <select id="to" onchange="if ( ! this.getAttribute('disabled') ) selectTo();"
                                            disabled>
                                        <option></option>
                                    </select>

                                </div>
                            </div><!--side-col-->
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 globe--transition globe-choice pr-md-0">
                <div class="globe-text">
                    <p class="list__title places-list--dropdown d-flex align-items-center">
                        <img class="img mw-100 mr-2"
                             src="<?php echo get_template_directory_uri(); ?>/asset-sources/dhlexpress/dist/images/co.png"
                             alt="">
                        <span>Wybierz kraj</span></p>
                    <ul class="places-list" id="list">
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-3 globe--transition globe-about pr-md-0">
                <div class="globe-text globe-about-place">
                    <p class="list__title info-back d-none d-md-flex align-items-center">
                        <img class="img mw-100 mr-2"
                             src="<?php echo get_template_directory_uri(); ?>/asset-sources/dhlexpress/dist/images/back.png"
                             alt="">
                        <span>Powrót</span></p>
                    <div class="globe-about-place__image">
                        <img class="img mw-100 mr-2"
                             src="<?php echo get_template_directory_uri(); ?>/asset-sources/dhlexpress/dist/images/bgec.png"
                             alt="">
                    </div>
                    <div class="globe-about-place__text">
<!--                        <p class="globe-about-place__info">Trzynasta ekonomia na świecie</p>-->
<!--                        <p class="globe-about-place__info">79% ekonomii to sektor usług</p>-->
<!--                        <p class="globe-about-place__info">65% użytkowników internetu kupuje online</p>-->
                    </div>
                    <div class="globe-about-place__download pt-5">
                        <p class="globe-about-place__desc">Chcesz poznać ten rynek bliżej? Pobierz bezpłatny
                            informator! </p>
                        <a class="download__button" href="http://dhl.local/ecommerce/#ekspansja">POBIERZ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="contact" id="ekspansja">
    <div class="container directory">
        <div class="row justify-content-center">
            <div class="col-12 directory__headers text-center">
                <div class="directory__headers-image pb-4">
                    <img class="img mw-100"
                         src="<?php echo get_template_directory_uri(); ?>/asset-sources/dhlexpress/dist/images/form-header-img.png"
                         alt="">
                </div>
            </div>
            <div class="col-12 col-md-10 text-center">
                <div class="directory__headers-text">
                    <h2 class="title" id="ekspansja-tytul">
                        Skorzystaj z naszego doświadczenia <br>
                        w handlu transgranicznym
                    </h2>
                    <p class="desc">
                        Uzupełnij dane i wpisz kraj ekspansji, a otrzymasz wskazówki, jak zacząć
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-10">
                <?php
                if (get_bloginfo('language') == 'es-ES') {
                    echo do_shortcode('[contact-form-7 id="1965" title="Ekspansja EN"]');
                } else {
                    echo do_shortcode('[contact-form-7 id="3244" title="Ekspansja"]');
                }
                ?>
            </div>
            <div class="col-8 directory__data text-center">
                <p class="directory__data-clause">
                    Twoje dane będziemy przetwarzali w celu obsługi Twojego zapytania. Ponadto, będziemy przetwarzać
                    dane w celach analitycznych w tym profilowania, dążymy bowiem do ciągłego ulepszania naszych usług,
                    dlatego chcemy dostarczać tylko potencjalnie intersujące Cię informacje – spersonalizowane
                    propozycje. Przysługuje Ci prawo dostępu do treści swoich danych, ich przenoszenia, sprostowania,
                    usunięcia lub ograniczenia przetwarzania oraz skargi do organu nadzoru. Przysługuje Ci również prawo
                    do wniesienia sprzeciwu. Więcej informacji uzyskasz na stronie: www.dhl.com.pl/dane
                </p>
            </div>
        </div>
    </div>
</section>
<section class="like-others">
    <div class="container">
        <?php
        $posts_slider = get_field('slider-posts');

        if ($posts_slider) {
            ?>
            <div class="row d-lg-none default-title-row">
                <div class="col-12 col-lg-6 text-center text-lg-left">
                    <div class="like-others__headers">
                        <h2 class="like-others__title"><?php echo $posts_slider['title']; ?>
                        </h2>
                        <p class="like-others__desc">
                            <?php echo $posts_slider['desc']; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row like-others__mobile-carousel">
                <div class="col-12 col-lg-6 text-center text-lg-left">
                    <div class="like-others__headers">
                        <h2 class="like-others__title"><?php echo $posts_slider['title']; ?>
                        </h2>
                        <p class="like-others__desc">
                            <?php echo $posts_slider['desc']; ?>
                        </p>
                    </div>
                </div>
                <?php
                foreach ($posts_slider['posts'] as $index => $single) {
                    if ($index == 1) {
                        $additional = "like-others--to-top";
                    } else {
                        $additional = "";
                    }
                    ?>
                    <?php $topImageSrc = Tags\getTopImageSrc($single->ID); ?>
                    <div class="col-lg-6 <?php echo $additional ?> pb-4">
                        <div class="like-others__box-post">
                            <a class="box-post__link" href="<?php echo get_the_permalink($single->ID); ?>">
                                <div class="box-post__image"
                                     style="background-image: url('<?php echo esc_url($topImageSrc); ?>');">
                                </div>
                                <div class="box-post__info">
                                    <h4 class="box-post__title">
                                        <?php echo get_the_title($single->ID); ?>
                                    </h4>
                                </div>
                            </a>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</section>
<?php get_template_part('templates/footer1'); ?>
