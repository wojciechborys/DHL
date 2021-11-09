<?php
/*
YARPP Template: Sidebar
Author: Mateusz Źrebiec
Description: Templatka dla sidebara.
*/
use SD\Template\Tags;

if (have_posts()) :
    ?><div class="recommended-aside">
    <h3 class="recommended-aside__title">Polecamy</h3>

    <ul class="recommended-aside__list">
        <?php
        while (have_posts()) : the_post();
            $postID = get_the_ID();
            ?><li class="recommended-aside__item">
                <a class="recommended-aside__link" href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>

                <?php
                $tag = Tags\getMainTag();

                if ($tag) :
                    ?><a rel="nofollow" href="<?= esc_url(get_term_link($tag)); ?>" class="recommended-aside__tag"><?= $tag->name; ?></a><?php
                endif;
                ?>

                <time class="recommended-aside__time"><?= get_the_date('j F Y', $postID); ?></time>
            </li><?php
        endwhile;
        ?>
    </ul>

</div><?php
endif;
