<?php
while (have_posts()) : the_post();
    ?>

    <article <?php post_class('single-article'); ?>>

        <?php
        if (has_post_thumbnail()) {
            $thumbnailID = get_post_thumbnail_id(get_the_ID());
            $bgImgUrl = wp_get_attachment_image_url($thumbnailID, 'full');
        } else {
            $bgImgUrl = false;
        }
        ?>

        <header class="single-article__header"<?php if ($bgImgUrl) : ?> style="background-image:url('<?= esc_attr($bgImgUrl); ?>');"<?php endif; ?>>
            <div class="container">
                <h1 class="single-article__title"><?php the_title(); ?></h1>
            </div>
        </header>

        <div class="container">
            <div class="single-article__content">
                <?php the_content(); ?>
            </div>

            <?php
            $encodedPermalink = urlencode(get_permalink());
            ?><footer class="single-article__footer">
                <ul class="row single-article__social-list">
                    <li class="col-12 col-sm-4 single-article__social-item single-article__social-item--facebook">
                        <?php
                        $url = esc_url('https://www.facebook.com/sharer/sharer.php?u=') . $encodedPermalink;
                        ?><a class="single-article__social-link single-article__social-link--facebook" href="<?= $url ?>" title="Opublikuj na " target="_blank">Facebook</a>
                    </li>

                    <li class="col-12 col-sm-4 single-article__social-item single-article__social-item--linkedin">
                        <?php
                        $url = esc_url('https://www.linkedin.com/shareArticle?mini=true&title=&summary=&source=&url=') . $encodedPermalink;
                        ?><a class="single-article__social-link single-article__social-link--linkedin" href="<?= $url; ?>" title="Opublikuj na LinkedIn" target="_blank">LinkedIn</a>
                    </li>

                    <li class="col-12 col-sm-4 single-article__social-item single-article__social-item--twitter">
                        <?php
                        $url = esc_url('https://twitter.com/home?status=') . $encodedPermalink;
                        ?><a class="single-article__social-link single-article__social-link--twitter" href="<?= $url; ?>" title="Opublikuj na Twitterze" target="_blank">Twitter</a>
                    </li>
                </ul>

                <a href="<?= esc_url(home_url('/')); ?>" class="single-article__back-btn" data-back>Powrót do&nbsp;strony głównej</a>
            </footer>

        </div>

    </article>

    <?php
endwhile;
?>
