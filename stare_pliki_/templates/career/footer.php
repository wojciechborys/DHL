<?php
use SD\Options\OptionsHelper;

$optionsHelper = OptionsHelper::getInstance();

$linkedinUrl = $optionsHelper->get('footer::linkedin_url');
?>

<footer class="content-info">


    <div class="mm-main-footer mm-main-footer--subfooter">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <?php
                    $footerText = trim($optionsHelper->get('footer::text'));

                    if ($footerText) :
                        ?><span class="mm-main-footer--subfooter__text"><?= $footerText; ?></span><?php
                    endif;
                    ?>
                </div>
                <div class="col-12 col-md-6 col-lg-6">

                    <?php
                        wp_nav_menu([
                            'container'      => false,
                            'theme_location' => 'footer_navigation',
                            'menu_class'     => 'mm-nav',
                            'link_before'    => '<span class="nav-primary__link-text">',
                            'link_after'     => '</span>',
                        ]);
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mm-main-footer">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-6 footer-copyrights">
                    <p><?= current_time('Y'); ?> &copy; <?= $optionsHelper->get('footer::copyrights'); ?></p>
                </div>
                <div class="col-12 col-lg-6 mm-nav">
                    <?php dynamic_sidebar('career-footer'); ?>
                </div>
            </div>
        </div>
    </div>

</footer>
