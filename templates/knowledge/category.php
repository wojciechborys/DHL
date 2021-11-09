<?php

use SD\Template\Tags;
use SD\Restricted;
use MintMedia\PolylangT9n\Polylang;

$id = get_the_ID();
if (is_tax()) {
    $id = get_queried_object();
}
if (get_field('category__enable', $id)) :
    $title = get_field('category__title', $id);
    $text = get_field('category__text', $id);
    ?>


    <section class="search_blog">
        <div class="container">
            <h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php echo $title; ?></h1>
            <div class="row">
                <div class="col-md-8 col-lg-6 mx-auto">
                    <span class="font__subtitle--0222 d-block text-center mb-4"><?php echo $text; ?></span>
                </div>
            </div>
            <?php if (get_field('category__search', $id)) : ?>
                <div class="row">
                    <form method="GET" action="/baza-wiedzy-search" class="col-12 col-lg-8 mx-auto">
                        <div class="row">
                            <div class="col-12 col-sm-8 col-lg-8 col-xl-9">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="search" name="search" placeholder="">
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 col-lg-4 col-xl-3">
                                <div class="form-group">
                                    <input type="submit"
                                           class="btn w-100 btn--auto btn--red btn-primary btn--calc"
                                           value="<?= Polylang\t9n('SZUKAJ'); ?>">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </section>
    <?php if (get_field('category-parent__enable', $id)) : ?>
    <?php $args = array(
        'taxonomy' => 'knowledge_category',
        'hide_empty' => false,
        'parent' => 0,
    );
    $knowledge_categories = get_terms($args); ?>
    <section class="blog_category">
        <div class="container">
            <div class="row">
                <?php foreach ($knowledge_categories as $category) { ?>
                    <a href="/bazawiedzy/<?php echo $category->slug; ?>" class="blog_category--link col-12 col-sm-6 col-md-4">
                        <div class="blog_category--item bg__color--gray-light text-center text-md-left">
                            <div class="blog_category--ico d-flex align-items-center justify-content-center justify-content-md-start">
                                <img src="<?php echo esc_url((get_field('icon', $category))['url']); ?>"
                                     alt="<?php echo (get_field('icon', $category))['alt']; ?>">
                            </div>
                            <hr>
                            <div class="blog_category--name">
                                <span class="font__title--05 text-uppercase font__color--gray"><?php echo $category->name; ?></span>
                            </div>
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>
    </section>
<?php endif; ?>
    <?php if (is_tax()) :
    $taxonomy_id = get_queried_object_id();
    $taxonomy_name = get_queried_object()->name;
    $taxonomy_type = get_queried_object()->taxonomy;
    $taxonomy_children = get_term_children($taxonomy_id, $taxonomy_type);
    $class_active = "";
    $class = "category";
    if (get_field('documents__enable', $id)) {
        $class = "documents";
    } else if (get_field('faq__enable', $id)) {
        $class = "faqs";
    }
    ?>
    <section class="search_blog">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10 mx-auto text-center pt-1">
                    <?php $i = 0;
                    foreach ($taxonomy_children as $term) {
                        $term = get_term_by('id', $term, $taxonomy_type);
                        echo '<button type="button" class="btn btn-secondary ml-1 mr-1 mb-2 js-click-filter ' . $class . '" data-parentId="' . $taxonomy_id . '" data-parent="' . $taxonomy_name . '" data-id="' . $term->term_id . '" data-slug="' . $term->slug . '">' . $term->name . '</button>';
                        $i++;
                    } ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php endif; ?>
