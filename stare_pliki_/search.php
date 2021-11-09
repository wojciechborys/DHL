<?php
global $wp_query;

get_template_part('templates/page', 'header');
?>

<?php if (!have_posts()) : ?>
    <div class="alert alert-warning">
        Przepraszamy, nie znaleziono żadnych wpisów.
    </div>

    <?php get_search_form(); ?>
<?php endif; ?>

<?php
if (have_posts()) :
    ?><div class="row main-contents">

    <?php
    while (have_posts()) : the_post();
        ?><div class="col-12 col-sm-6">

        <?php get_template_part('templates/world/article-box'); ?>

        </div>

    <?php
    endwhile;
    ?>

    <div class="col-12 text-center">
        <?php
        $allPages = $wp_query->max_num_pages;
        ?>

        <?php
        if ($allPages > 1) :
            ?><a href="#" class="btn btn-primary btn-wide button-load-more" data-page="1" data-tags="" data-phrase="<?= esc_attr(get_search_query()); ?>">Zobacz więcej</a><?php
        endif;
        ?>
    </div>
    </div>

<?php
endif;
?>
