<?php
if (!isset($query) || !$query instanceof WP_Query) {
    die;
}

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

<aside class="related-articles" id="related-articles">
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

                        include $stylesheet_dir.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'_single-article.php';
                    endwhile;
                    ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</aside>
