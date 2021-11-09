<?php
use SD\Template\Tags;
?>
<article class="<?= $col; ?> related-articles__article">
    <a href="<?php the_permalink(); ?>" class="articles-section__link">
	
		<?php
		$thumbnailID = get_post_meta(get_the_ID(), '_sd_recommendations_image_id', true);

		if (!$thumbnailID) {
			$thumbnailID = get_post_thumbnail_id(get_the_ID());
		}

		if ($thumbnailID) :
			?><img src="<?= esc_url(wp_get_attachment_image_url($thumbnailID, 'fp-article')); ?>" alt="<?= esc_attr(get_the_title()) ?>" class="img-fluid related-articles__figure" /><?php
		endif;
		?>

        <div class="related-articles__content">
            <h3 class="related-articles__article-header"><?php the_title(); ?></h3>
            <p class="related-articles__excerpt"><?php Tags\theExcerpt(); ?></p>
        </div>
    </a>
</article>
