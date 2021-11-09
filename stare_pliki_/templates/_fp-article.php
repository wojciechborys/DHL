<?php
use MintMedia\Dhl\Tags;
?>
<article class="<?= $col; ?> articles-section__article">
    <a href="<?php the_permalink(); ?>" class="articles-section__link">
        <?php
        if (has_post_thumbnail()) :
            ?><img src="<?php the_post_thumbnail_url('fp-article'); ?>" alt="<?= esc_attr(get_the_title()) ?>" class="img-fluid articles-section__figure" /><?php
        endif;
        ?>

        <div class="articles-section__content">
            <h3 class="articles-section__article-header"><?php the_title(); ?></h3>
            <p class="articles-section__excerpt"><?php Tags\excerpt(); ?></p>
        </div>
    </a>
</article>
