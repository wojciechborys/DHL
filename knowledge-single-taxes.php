<?php
/*
Template Name: Taxes knowledge base
Template Post Type: knowledge
*/
?>

<div class="taxes-page">
    <?php while (have_posts()) : the_post(); ?>
        <?php if (have_rows('tax_page_layout')): ?>
            <?php while (have_rows('tax_page_layout')) : the_row(); ?>
                <?php $layout = get_row_layout(); ?>
                <?php get_template_part('templates/knowledge/taxes/' . $layout); ?>
            <?php endwhile; ?>
        <?php endif; ?>
    <?php endwhile; ?>
</div>


