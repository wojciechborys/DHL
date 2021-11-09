<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;


?>

<?php
do_action('get_header');
get_template_part('templates/knowledge/header');
?>

<?php get_template_part('templates/knowledge/header-new'); ?>
<?php get_template_part('templates/knowledge/category'); ?>
<?php get_template_part('templates/knowledge/posts-knowledge-category'); ?>
<?php get_template_part('templates/knowledge/posts-knowledge-documents'); ?>
<?php get_template_part('templates/knowledge/posts-knowledge-faq'); ?>
<?php get_template_part('templates/knowledge/questions'); ?>
<?php get_template_part('templates/knowledge/prefooter'); ?>
<?php get_template_part('templates/knowledge/blog-posts-world'); ?>
<?php
wp_footer();
?>

