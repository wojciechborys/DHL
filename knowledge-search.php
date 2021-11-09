<?php

/**
 * Template name: [Baza wiedzy] Search
 */

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;
use Roots\Sage\Assets;
use SD\Sliders;
use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

?>
<?php

$search = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';
$id_page = get_the_ID();
$tax_article = get_field('categories__article');
$tax_documents = get_field('categories__documents');
$tax_faqs = get_field('categories__faq');

$posts_article = get_posts_by_tax($tax_article, $search);
$posts_document = get_posts_by_tax($tax_documents, $search);
$posts_faq = get_posts_by_tax($tax_faqs, $search);


?>

<?php while (have_posts()) : the_post(); ?>

    <?php get_template_part('templates/knowledge/header-new'); ?>


    <section class="search_blog">
        <div class="container">
            <span class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php the_content(); ?></span>
            <span class="font__subtitle--0222 d-none d-sm-block text-center mb-4">&nbsp;<br>&nbsp;</span>
            <div class="row">
                <form method="GET" action="/baza-wiedzy-search" class="col-12 col-lg-8 mx-auto">
                    <div class="row">
                        <div class="col-12 col-sm-8 col-lg-8 col-xl-9">
                            <div class="form-group">
                                <input type="text" class="form-control" id="search" name="search" placeholder=""
                                       value="<?php echo $search; ?>">
                            </div>
                        </div>
                        <div class=" col-12 col-sm-4 col-lg-4 col-xl-3">
                            <div class="form-group">
                                <input type="submit"
                                       class="btn w-100 btn--auto btn--red btn-primary btn--calc"
                                       value="<?= Polylang\t9n('SZUKAJ'); ?>">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row mt-4 pt-sm-5">
                <div class="col-12 col-lg-10 mx-auto text-center pt-1">
                    <button data-type="posts_articles" type="button"
                            class="btn btn-secondary ml-1 mr-1 mb-2 font__subtitle--0222 active js-search-filter"><?= Polylang\t9n('Artykuły z bazy wiedzy'); ?>
                        (<?php echo $posts_article->found_posts; ?>)
                    </button>
                    <button data-type="posts_documents" type="button"
                            class="btn btn-secondary ml-1 mr-1 mb-2 font__subtitle--0222 js-search-filter"><?= Polylang\t9n('Dokumenty'); ?>
                        (<?php echo $posts_document->found_posts; ?>)
                    </button>
                    <button data-type="posts_faqs" type="button"
                            class="btn btn-secondary ml-1 mr-1 mb-2 font__subtitle--0222 js-search-filter"><?= Polylang\t9n('Pytania i odpowiedzi '); ?>
                        (<?php echo $posts_faq->found_posts; ?>)
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section class="search-results mb-5">
        <div class="container">
            <div id="posts_articles" class="search-posts row">
                <?php if ($posts_article->have_posts()) { ?>
                    <?php while ($posts_article->have_posts()) {
                        $posts_article->the_post();
                        ?>
                        <?php get_template_part('templates/knowledge/article-box'); ?>
                    <?php } ?>
                    <?php if ($posts_article->found_posts > 6) { ?>
                        <div class="button_container m-4 text-center" style="width: 100%;">
                            <button id="categories__article" data-search="<?php echo esc_attr($search); ?>" data-id="<?php echo esc_attr($id_page); ?>" data-offset="6"
                                 class="btn btn--auto btn--red btn-primary btn--calc d-block d-sm-inline-block js-search-more"><?= Polylang\t9n('ZOBACZ WIĘCEJ'); ?></button>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p class="col-12 text-center"><?= Polylang\t9n('Brak postów'); ?></p>
                <?php }
                wp_reset_postdata(); ?>
            </div>
            <div id="posts_documents" class="search-posts row d-none">
                <div class="documents col-md-12 col-lg-10 col-xl-8 mx-auto">
                    <?php if ($posts_document->have_posts()) { ?>
                        <?php while ($posts_document->have_posts()) {
                            $posts_document->the_post();
                            ?>
                            <?php get_template_part('templates/knowledge/documents-box'); ?>
                        <?php } ?>
                        <?php if ($posts_document->found_posts > 6) { ?>
                            <div class="button_container m-4 text-center" style="width: 100%;">
                                <button id="categories__documents" data-search="<?php echo esc_attr($search); ?>"  data-id="<?php echo esc_attr($id_page); ?>" data-offset="6"
                                     class="btn btn--auto btn--red btn-primary btn--calc d-block d-sm-inline-block js-search-more"><?= Polylang\t9n('ZOBACZ WIĘCEJ'); ?></button>
                            </div>
                        <?php } ?>
                    <?php } else { ?>
                        <p class="text-center"><?= Polylang\t9n('Brak postów'); ?></p>
                    <?php }
                    wp_reset_postdata(); ?>
                </div>
            </div>
            <div id="posts_faqs" class="search-posts row d-none">
                <div class="col-md-12 col-lg-10 mx-auto">
                    <div class="accordion list faqs" id="accordion">
                        <?php if ($posts_faq->have_posts()) { ?>
                            <?php while ($posts_faq->have_posts()) {
                                $posts_faq->the_post();
                                ?>
                                <?php get_template_part('templates/knowledge/faq-box'); ?>
                            <?php } ?>
                            <?php if ($posts_faq->found_posts > 6) { ?>
                                <div class="button_container m-4 text-center" style="width: 100%;">
                                    <button id="categories__faq" data-search="<?php echo esc_attr($search); ?>" data-id="<?php echo esc_attr($id_page); ?>" data-offset="6"
                                         class="btn btn--auto btn--red btn-primary btn--calc d-block d-sm-inline-block js-search-more"><?= Polylang\t9n('ZOBACZ WIĘCEJ'); ?></button>
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <p class="text-center"><?= Polylang\t9n('Brak postów'); ?></p>
                        <?php }
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php get_template_part('templates/knowledge/newsletter-form'); ?>
    <?php get_template_part('templates/knowledge/blog-posts-world'); ?>
    <?php get_template_part('templates/knowledge/prefooter'); ?>
    <?php // get_template_part('templates/page', 'header'); ?>
    <?php // get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>