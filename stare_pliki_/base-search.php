<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;

?>
<!doctype html>
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

<div class="wrap container" role="document">

    <div class="row">
        <div class="col-12">
            <div id="carouselExampleControls" class="carousel slide archive-slider" data-ride="carousel">
                <div class="carousel-inner" role="listbox" style="overflow:hidden;">
                    <?php

                    $slidesCore = new Sliders\Core();
                    $slides = $slidesCore->getSlides('slider-w-archiwum');

                    $first = true;

                    foreach($slides as $slide) {
                        ?>

                        <div class="carousel-item <?php if($first) { ?> active<?php } ?>">
                            <div class="container">
                                <div class="row">
                                    <div class="col-12 col-md-6 col-lg-4 order-2 order-md-1">
                                        <article>
                                            <small class="tag"><?php echo $slide['tag'] ?></small>
                                            <h2 class="header header--size1"><?php echo $slide['title'] ?></h2>
                                            <p><?php echo $slide['excerpt'] ?></p>
                                            <p><a href="<?php echo $slide['permalink'] ?>" class="btn btn-primary btn-lg">Przeczytaj więcej!</a>
                                        </article>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-8 order-1 order-md-2 archive-slider__image" style="background-image: url('<?php echo $slide['image'] ?>')"></div>
                                </div>
                            </div>
                        </div>

                        <?php $first = false; } ?>

                </div>

                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-12">
            <?php include Wrapper\template_path(); ?>
        </div>

    </div><!-- /.content -->
</div><!-- /.wrap -->

<?php
do_action('get_footer');
get_template_part('templates/world/footer');
wp_footer();
?>
</body>
</html>
