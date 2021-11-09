<?php

use SD\Template\Tags;
use MintMedia\PolylangT9n\Polylang;

$news_posts = get_field('news__posts');
$title = get_field('news__title');
?>
<?php if ($news_posts): ?>
    <section class="article_blog article_blog--home bg__color--gray-light">
        <div class="container">
            <span class="article_blog--title font__title--022 font__color--gray text-uppercase text-center d-block"><?php echo $title; ?></span>
            <div class="row slick-slider">
                <?php foreach ($news_posts as $post) { ?>
                    <?php setup_postdata($post);
                    $thumbnail = Tags\getFeaturedImageSrc();
                    ?>
                    <div class="col-12 mb-4 mb-lg-0">
                        <div class="article_blog--item bg__color--white">
                            <?php if ($thumbnail) { ?>
                                <img class="img-fluid w-100" src="<?php echo esc_url($thumbnail); ?>" alt=""/>
                            <?php } else { ?>
                                <div class="article-box__image"
                                     style="background: #333; padding-bottom:66.666666666666%; width:100%; height:0;"></div>
                            <?php } ?>
                            <div class="article_blog--desc">
                                <a href="<?php the_permalink() ?>" title="<?php the_title() ?>"
                                   class="d-block font__title--04 font__color--gray mb-3"><?php the_title() ?></a>
                                <span class="font__subtitle--16-2">
                                <?php
                                $excerpt = \wp_trim_words(\strip_shortcodes(get_the_excerpt()), 11, '&hellip;');
                                echo $excerpt;
                                ?>
                                </span>
                            </div>
                        </div>
                    </div>
                <?php }
                wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>