<?php
namespace MintMedia\Dhl\Templates;

function articles_section () {
    global $post;

    $query = new \WP_Query([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'category__not_in' => [31, 33],
        'posts_per_page' => 3
    ]);

    if ($query->have_posts()) :
        if (1 === $query->post_count) {
            $col = 'col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4';
            $row = 'justify-content-center';
        } elseif (2 === $query->post_count) {
            $col = 'col-12 col-sm-10 col-md-6 col-lg-5 col-xl-4';
            $row = 'justify-content-center';
        } else {
            $col = 'col';
            $row = '';
        }
        ?>

<section class="articles-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="articles-section__header">Skorzystaj<br /> z&nbsp;naszego poradnika</h2>

                <div class="articles-section__wrapper">
                    <div class="row articles-section__articles articles-section__articles--x<?= $query->post_count; ?> <?= $row; ?>" data-articles>

                    <?php
                    $stylesheet_dir = \get_stylesheet_directory();

                    while ($query->have_posts()) :
                        $query->the_post();

                        include $stylesheet_dir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '_fp-article.php';

                    endwhile;
                    ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <?php
        \wp_reset_postdata();

    endif;
}

function related_articles () {
    global $post;

    $query = new \WP_Query([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => 3,
        'category__not_in' => [31, 33],
        'post__not_in' => array(get_the_ID()),
    //    'exclude'        => $post->ID
    ]);

    if ($query->have_posts()) :
        if (1 === $query->post_count) {
            $col = 'col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4';
            $row = 'justify-content-center';
        } elseif (2 === $query->post_count) {
            $col = 'col-12 col-sm-10 col-md-6 col-lg-5 col-xl-4';
            $row = 'justify-content-center';
        } else {
            $col = 'col';
            $row = '';
        }
        ?>

<aside class="related-articles">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="related-articles__header">Polecane artykuły</h2>

                <div class="related-articles__wrapper">
                    <div class="row related-articles__articles related-articles__articles--x<?= $query->post_count; ?> <?= $row; ?>" data-articles>
                    <?php
                    $stylesheet_dir = \get_stylesheet_directory();

                    while ($query->have_posts()) :
                        $query->the_post();

                        include $stylesheet_dir . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '_single-article.php';
                    endwhile;
                    ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>

    <?php
    \wp_reset_postdata();

    endif;
}

function contact_form_thanks () {
    $burl = \esc_url(\home_url('/#benefits'));

    $output = '<h3 class="contact-form__header contact-form__header--thanks">Dziękujemy!</h3>' . "\n" .
              '<p class="contact-form__info contact-form__info--thanks">Skontaktujemy się z&nbsp;Tobą w ciągu 24h (w&nbsp;dni robocze)</p>' . "\n";
            //  '<a href="'.$burl.'" class="btn btn-secondary btn--wide contact-form__submit contact-form__submit--thanks" data-submit="benefits" data-scroller>Zobacz nasze korzyści</button>';

    return $output;
}

function contact_form () {
    include \get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '_contact-form.php';
}

function disclaimer_single () {
    include \get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '_single-disclaimer.php';
}

function cookie_consent () {
    include \get_stylesheet_directory() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . '_cookie-consent.php';
}
