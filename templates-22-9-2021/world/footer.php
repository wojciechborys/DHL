<footer class="mm-main-footer__container">

    <div class="container mm-main-footer__info">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <p class="text-center">Coś nie działa? Napisz do nas na <a href="mailto:swiat@dhlexpress.pl">swiat@dhlexpress.pl</a></p>
            </div>
        </div>
    </div>

    <div class="mm-main-footer mm-main-footer--subfooter">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <?php dynamic_sidebar('sidebar-subfooter'); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mm-main-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-4">
                    <p>2018 &copy; DHL Express. Wszystkie prawa zastrzeżone</p>
                </div>
                <div class="col-12 col-md-8 col-lg-8">
                    <?php dynamic_sidebar('sidebar-footer'); ?>
                </div>
            </div>
        </div>
    </div>

    <?php SD\Template\Tags\cookieConsentWorld(); ?>

</footer>
