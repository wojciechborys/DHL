<?php

$title = get_field('tiled_2__title');
$desc = get_field('tiled_2__description');

?>
<section class="blog_category mb-0">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php echo $title; ?></h1>
                <span class="font__subtitle--0222 text-center d-block mb-5" style="font-size: 20px"><?php echo $desc; ?></span>
            </div>
        </div>
    </div>
</section>

<?php include(sprintf('%s/templates/reusable/layouts/section_tiles.php', get_template_directory())); ?>
