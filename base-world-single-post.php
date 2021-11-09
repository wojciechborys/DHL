<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use SD\Template\Tags;

?><!doctype html>
<html <?php language_attributes(); ?>>
<?php get_template_part('templates/world/head'); ?>
<body <?php body_class(); ?>>
<!--[if IE]>
<div class="alert alert-warning">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
</div>
<![endif]-->

<?php
do_action('get_header');
get_template_part('templates/world/header');
?>

<?php
$topImageSrc = Tags\getTopImageSrc(get_queried_object_id());
?>

<div class="wrap wrap--single<?php if ($topImageSrc) : ?> wrap--has-bg<?php endif; ?>" role="document"<?php if ($topImageSrc) : ?> style="background-image:url('<?= esc_url($topImageSrc); ?>');"<?php endif; ?>>
    <div class="container">
        <div class="content row">

            <main class="main main--single">
                <?php include Wrapper\template_path(); ?>
            </main><!-- /.main -->

            <aside class="sidebar">
                <?php Tags\newsletterForm(true); ?>

                <?php include Wrapper\world_sidebar_path(); ?>
            </aside><!-- /.sidebar -->

        </div><!-- /.content -->
    </div><!-- /.container -->

    <!-- <div class="container"></div> -->
</div><!-- /.wrap -->

<?php
do_action('get_footer');
get_template_part('templates/world/footer');
wp_footer();
?>
</body>
</html>
