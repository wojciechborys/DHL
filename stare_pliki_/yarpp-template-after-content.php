<?php
/*
YARPP Template: Po treści wpisu
Author: Mateusz Źrebiec
Description: Templatka do wyświetlania powiązanych pod treścią pojedynczego wpisu.
*/
use SD\Template\Tags;
use SD\Restricted;

if (have_posts()) :
    $i = 0;
    ?>
    <aside class="post-single__related">
        <div class="row justify-content-center">
            <?php
            while (have_posts() && $i < 2) : the_post();
                ++$i;
                $postID = get_the_ID();

                $postThumbnail = Tags\getPostThumbnailSrc(null, 'related-image');
            ?><div class="col-12 col-sm-10 col-lg-6">
                <article class="article-box article-box--single<?php if (!Restricted\canView()) : ?> article-box--locked<?php endif; ?>">

                    <header>
                        <?php
                        if ($postThumbnail) :
                            ?><a class="article-box__image-link" href="<?= esc_url(get_permalink()); ?>" title="<?= esc_attr(get_the_title()); ?>">
                                <img class="img-fluid article-box__image" src="<?= esc_url($postThumbnail); ?>" />
                            </a><?php
                        endif;
                        ?>

                        <?php
                        $tag = Tags\getMainTag();

                        if ($tag) :
                            ?><small class="article-box__main-tag"><a rel="nofollow" href="<?= esc_url(get_term_link($tag)); ?>" class="article-box__tag"><?= $tag->name; ?></a></small><?php
                        endif;
                        ?>

                        <a class="article-box__link" href="<?= esc_url(get_permalink()); ?>" title="<?= esc_attr(get_the_title()); ?>">
                            <h3 class="header header--size4"><?php echo wp_trim_words(wp_strip_all_tags(get_the_title()), 3, '&hellip;'); ?></h3>
                        </a>
                    </header>

                    <footer class="article-box__footer">
                        <span class="article-box__date"><?= get_the_date('j F Y', $postID); ?></span>
                    </footer>

                </article>
            </div><?php
            endwhile;
            ?>
        </div>
    </aside><?php
endif;
