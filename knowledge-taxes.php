<?php

/**
 * Template name: Taxes page
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
    <?php get_template_part('templates/knowledge/prefooter'); ?>
</div>

