<?php
use MintMedia\Dhl\Tags;
?>
<article class="<?= $col; ?> related-articles__article">
    <a href="<?php the_permalink(); ?>" class="articles-section__link">

        <?php
        if (has_post_thumbnail($post->ID)) :
            ?><img src="<?php the_post_thumbnail_url('fp-article'); ?>" alt="<?= esc_attr(get_the_title()) ?>" class="img-fluid related-articles__figure" /><?php
        endif;
        ?>

        <div class="related-articles__content">
            <h3 class="related-articles__article-header"><?php the_title(); ?></h3>
            <p class="related-articles__excerpt"><?php Tags\excerpt(); ?></p>
        </div>
    </a>
</article>
