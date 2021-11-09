<?php
$id = get_the_ID();
if (is_tax()) {
    $id = get_queried_object();
}
if (get_field('blog__enable', $id)) :
    $title = get_field('blog__title', $id);
    ?>
    <?php

    $args = array(
        'post_type' => 'post',
        'category_name' => 'posty-swiat',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => 3,
    );

    $mostPopular = new WP_Query($args);

    ?>
    <section class="article_blog">
        <div class="container">
            <span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block"><?php echo $title; ?></span>
            <?php if ($mostPopular->have_posts()) { ?>
                <div class="row">

                    <?php while ($mostPopular->have_posts()) {
                        $mostPopular->the_post();
                        ?>
                        <?php get_template_part('templates/knowledge/article-box'); ?>
                    <?php }
                    wp_reset_postdata(); ?>
                </div>
                <?php
                $link = get_field('blog__button', $id);
                if ($link):
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                    <div class="more_btn text-center">
                        <a class="btn btn--auto btn--red btn-primary btn--calc d-block d-sm-inline-block"
                           href="<?php echo esc_url($link_url); ?>"
                           target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div>
    </section>
<?php endif; ?>