<?php

use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

$posts = get_field('custom_posts__relation');
?>

<?php if ($posts): ?>
    <section class="article_blog mb-0 mb-md-5 mt-4">
        <div class="container">
            <div class="row">
                <?php foreach ($posts as $post) { ?>
                    <?php setup_postdata($post); ?>
                    <?php get_template_part('templates/knowledge/article-box'); ?>
                <?php }
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>