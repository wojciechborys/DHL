<?php

use Roots\Sage\Assets;
use MintMedia\PolylangT9n\Polylang;

?>
<!--<div class="banner banner__main-bg"></div>-->
<div class="" id="header-top">
    <header class="banner__header">
        <div class="container banner__container">
            <div class="banner__bar" data-banner-bar>

                <div class="hamburger js-hamburger">
                </div>
                <a class="brand banner__brand" href="<?= esc_url(home_url('/')); ?>">
                    <img class="brand banner__brand-image brand banner__brand-image--xs"
                         src="<?= esc_url(Assets\asset_path('images/logo.png', 'asset-sources/dhlexpress/dist')); ?>"
                         alt="DHL Express"/>
                    <img class="brand banner__brand-image brand banner__brand-image--md-up"
                         src="<?= esc_url(Assets\asset_path('images/logo-large.png', 'asset-sources/dhlexpress/dist')); ?>"
                         alt="DHL Express"/>
                </a>
                <?php
                if ($post) {
                    $template = get_post_meta($post->ID, '_wp_page_template', true);
                } elseif (is_404()) {
                    $template = '404';
                }
                if (isset($template)) {
                    if ($template !== 'custom-page.php') {
                        ?>
                        <?php
                        wp_nav_menu([
                            'container' => false,
                            'theme_location' => 'main_navigation',
                            'menu_class' => 'banner__list navbar-nav ml-0 mr-auto',
                            'walker' => new SD\Walkers\B4NavWalker(),
                            'link_before' => '<span class="nav-primary__link-text">',
                            'link_after' => '</span>',
                        ]);
                        ?>
                    <?php }
                } ?>
                <?php
                if (function_exists('pll_the_languages')) :
                    ?>
                    <div class="langs">
                        <div class="active-lang">
                            <?php
                            if (pll_current_language() === 'pl') {
                                echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAABGdBTUEAAK/INwWK6QAAABl0RVh0U29mdHdhcmUAQWRvYmUgSW1hZ2VSZWFkeXHJZTwAAAEISURBVHjaYvz/8SMDDPyD43//gPQ/bAAggFhACvn4gMT///8Zwdr+/wcRjP//MzMwMP1HAV+ePQMIIBYGqKL/yIz/2AAjI+O/P38AAoiFSNUQKaCTAAKIBehWRrhqMMSjAagDIIBYGPj5Gfr6/j979v/PH4Y/f/7D0e/f/38DGb/BjN8gWWnpfwsXAgQQ2EkPH/5/8OD/718MvyHqfv3/9fv/r18gNhLJ+OkT0DkAAQR2ElgIZDyyIlTVEMv/MDAABBBIAzPYAQxwRZja/gA1/GX4+xfoHIAAAmlg+v2HQVISbMxfhj8gnYxgIxkgJBD9/QtBQMUAAcT4FRy5cMSAykWTAgKAAAMA0PVcqMe0XaEAAAAASUVORK5CYII=" title="Polski" alt="Polski">';
                            } elseif (pll_current_language() === 'en') {
                                echo '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAALCAIAAAD5gJpuAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAflJREFUeNpinDRzn5qN3uFDt16+YWBg+Pv339+KGN0rbVP+//2rW5tf0Hfy/2+mr99+yKpyOl3Ydt8njEWIn8f9zj639NC7j78eP//8739GVUUhNUNuhl8//ysKeZrJ/v7z10Zb2PTQTIY1XZO2Xmfad+f7XgkXxuUrVB6cjPVXef78JyMjA8PFuwyX7gAZj97+T2e9o3d4BWNp84K1NzubTjAB3fH0+fv6N3qP/ir9bW6ozNQCijB8/8zw/TuQ7r4/ndvN5mZgkpPXiis3Pv34+ZPh5t23//79Rwehof/9/NDEgMrOXHvJcrllgpoRN8PFOwy/fzP8+gUlgZI/f/5xcPj/69e/37//AUX+/mXRkN555gsOG2xt/5hZQMwF4r9///75++f3nz8nr75gSms82jfvQnT6zqvXPjC8e/srJQHo9P9fvwNtAHmG4f8zZ6dDc3bIyM2LTNlsbtfM9OPHH3FhtqUz3eXX9H+cOy9ZMB2o6t/Pn0DHMPz/b+2wXGTvPlPGFxdcD+mZyjP8+8MUE6sa7a/xo6Pykn1s4zdzIZ6///8zMGpKM2pKAB0jqy4UE7/msKat6Jw5mafrsxNtWZ6/fjvNLW29qv25pQd///n+5+/fxDDVbcc//P/zx/36m5Ub9zL8+7t66yEROcHK7q5bldMBAgwADcRBCuVLfoEAAAAASUVORK5CYII=" title="English" alt="English">';
                            }
                            ?>
                        </div>
                        <div class="lang-arrow js-toggle-lang">

                        </div>
                        <ul class="banner__language-switch js-banner__language-switch">
                            <?php
                            pll_the_languages([
                                'hide_current' => 1,
                                'show_flags' => 1,
                                'show_names' => false,
                            ]);
                            ?>
                        </ul>
                    </div>

                    <?php
                endif;
                ?>

                <?php
                $mydhlUrl = '';
                if (pll_current_language() === 'pl') {
                    $mydhlUrl = 'https://mydhl.express.dhl/pl/pl/home.html';
                } elseif (pll_current_language() === 'en') {
                    $mydhlUrl = 'https://mydhl.express.dhl/pl/en/home.html';
                }
                if (isset($template)) {
                    if ($template !== 'custom-page.php') {
                        ?>
                        <a href="<?php echo $mydhlUrl; ?>" target="_blank"
                           class="btn btn--auto btn-primary btn--calc ml-3 mr-3 order-3" title="MyDHL+">MyDHL+</a>
                    <?php }
                }
                ?>
                <div class="contact-form__btn-wrapper">
                    <button class="btn btn-secondary btn--wide contact-form__submit"
                            data-submit="<?php if (is_front_page()) : ?>contact<?php else : ?>toggle<?php endif; ?>"><?= Polylang\t9n('Wysyłaj taniej'); ?></button>
                </div>
            </div>
        </div>
    </header>
</div>
