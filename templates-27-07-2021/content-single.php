<?php while (have_posts()) : the_post(); ?>
    <article <?php post_class('single-article'); ?>>
        <header class="single-article__header">
            <h1 class="single-article__title"><?php the_title(); ?></h1>
            <time class="updated single-article__updated" datetime="<?= get_post_time('c', true); ?>"><?= get_the_date(); ?></time>
        </header>

        <div class="single-article__content">
            <?php the_content(); ?>
        </div>

        <?php
        $permalink_encoded = urlencode(get_permalink());
        ?><footer class="single-article__footer">
            <ul class="row single-article__social-list">
                <li class="col-12 col-sm-4 single-article__social-item single-article__social-item--facebook">
                    <?php
                    $url = esc_url('https://www.facebook.com/sharer/sharer.php?u=') . $permalink_encoded;;
                    ?><a class="single-article__social-link single-article__social-link--facebook" href="<?= $url ?>" title="Opublikuj na " target="_blank">Facebook</a>
                </li>
                <li class="col-12 col-sm-4 single-article__social-item single-article__social-item--twitter">
                    <?php
                    $url = esc_url('https://twitter.com/home?status=') . $permalink_encoded;;
                    ?><a class="single-article__social-link single-article__social-link--twitter" href="<?= $url; ?>" title="Opublikuj na Twitterze" target="_blank">Twitter</a>
                </li>
                <li class="col-12 col-sm-4 single-article__social-item single-article__social-item--linkedin">
                    <?php
                    $url = esc_url('https://www.linkedin.com/shareArticle?mini=true&title=&summary=&source=&url=') . $permalink_encoded;
                    ?><a class="single-article__social-link single-article__social-link--linkedin" href="<?= $url; ?>" title="Opublikuj na LinkedIn" target="_blank">LinkedIn</a>
                </li>
            </ul>

            <a href="<?= esc_url(home_url('/')); ?>" class="single-article__back-btn" data-back>Powrót do&nbsp;strony głównej</a>
        </footer>
    </article>
<?php endwhile; ?>
