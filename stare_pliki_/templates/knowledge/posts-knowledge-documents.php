<?php

use MintMedia\PolylangT9n\Polylang;

if (get_field('documents__enable', $id) && is_tax()) :
    $taxonomy_id = get_queried_object_id();
    $taxonomy_name = get_queried_object()->taxonomy;
    $taxonomy_children = get_term_children($taxonomy_id, $taxonomy_name);
  //  $term_first = $taxonomy_children[0];
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_status' => 'publish',
        'posts_per_page' => 6,
        'post_type' => 'knowledge',
        'tax_query' => array(
            array(
                'taxonomy' => 'knowledge_category',
                'field' => 'term_id',
                'terms' => $taxonomy_id,
                'include_children' => true,
                'operator' => 'IN'
            ),
        ),
        'paged' => $paged
    );


    $posts_category = new WP_Query($args); ?>
    <section class="file_post">
        <div class="container">
            <div class="row">
                <div id="knowledgePosts" class="documents col-md-12 col-lg-10 col-xl-8 mx-auto">
                    <?php if ($posts_category->have_posts()) { ?>
                        <?php while ($posts_category->have_posts()) {
                            $posts_category->the_post();
                            ?>
                            <?php get_template_part('templates/knowledge/documents-box'); ?>
                        <?php }
                        echo paginator(get_pagenum_link()); ?>
                    <?php } else { ?>
                        <p class="text-center"><?= Polylang\t9n('Brak postów'); ?></p>
                    <?php }
                    wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>