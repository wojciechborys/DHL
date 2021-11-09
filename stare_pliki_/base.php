<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use MintMedia\Dhl\Templates;


?><!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?>>
    <!--[if IE]>
        <div class="alert alert-warning">
            <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
        </div>
    <![endif]-->

    <?php
        do_action('get_header');
        get_template_part('templates/header');

        if (is_single()) :
            Templates\contact_form();
        endif;
    ?>

    <div class="main-container">
        <main class="main-container--main" role="document">
            <?php  include Wrapper\template_path(); ?>
        </main>

    <?php
        if (is_single() && !is_singular('faqs')) :
            Templates\disclaimer_single();
        endif;
    ?>

    </div><!-- /.main-container -->

    <?php
        do_action('get_footer');
        if(is_front_page()) {
            get_template_part('templates/footer');
        }
        wp_footer();
    ?>
</body>
</html>
