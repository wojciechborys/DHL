<?php
/**
 * Template name: [Świat] Regulamin newslettera
 */
while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/world/page', 'header'); ?>
  <?php get_template_part('templates/world/content', 'page'); ?>
<?php endwhile; ?>
