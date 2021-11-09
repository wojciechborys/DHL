<?php

$title = get_field('services__title');
$text = get_field('services__text');

?>
<section class="search_blog">
    <div class="container">
        <h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php echo $title; ?></h1>
        <div class="row">
            <div class="col-md-8 col-lg-6 mx-auto">
                <span class="font__subtitle--0222 d-block text-center mb-4"><?php echo $text; ?></span>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto text-center pt-1">
                <?php if (have_rows('services__filters')):
                    while (have_rows('services__filters')) : the_row();
                        echo '<a href="'. esc_url(get_sub_field('link')).'" class="btn btn-secondary ml-1 mr-1 mb-2 hash_menu">' . get_sub_field('text') . '</a>';
                    endwhile;
                endif; ?>
            </div>
        </div>
    </div>
</section>