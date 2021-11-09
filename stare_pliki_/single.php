<?php
use MintMedia\Dhl\Templates;
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 single-article__container" data-article-container>
            <?php
            if (function_exists('yoast_breadcrumb')) :
                yoast_breadcrumb('
                    <p id="breadcrumbs" class="site-breadcrumbs">',
                    '</p>'
                );
            endif;
            ?>

            <?php get_template_part('templates/content-single', get_post_type()); ?>
        </div>
    </div>
</div>

<?php
Templates\related_articles();
?>
