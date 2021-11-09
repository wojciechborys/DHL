<?php
use SD\Template\Tags;
use SD\Restricted;

//the_post();

$thumbnail = Tags\getFeaturedImageSrc();
$mainTagTerm = Tags\getMainTag();
$mainTag = $mainTagTerm instanceof \WP_Term ? $mainTagTerm->name : '';

?>

<article class="article-box<?php if (!Restricted\canView()) : ?> article-box--locked<?php endif; ?>">
    <header>
        <?php if($mainTag) { ?>
            <small class="tag"><?php echo $mainTag ; ?></small>
        <?php } ?>
        <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" class="article-box__image-link" rel="nofollow">
            <?php if($thumbnail) { ?>
                <img class="article-box__image" src="<?php echo $thumbnail ?>" alt=""/>
            <?php } else { ?>
                <div class="article-box__image" style="background: #333; padding-bottom:66.666666666666%; width:100%; height:0;"></div>

            <?php } ?>
        </a>
        <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" class="article-box__link">
            <h3 class="header header--size4 text-center"><?php the_title() ?></h3>
        </a>
    </header>
    
    <div class="article-box__excerpt">
        <p>
        <?php
            $excerpt = \wp_trim_words(\strip_shortcodes(get_the_excerpt()), 11, '&hellip;');
            echo $excerpt;
        ?>
        </p>
    </div>
    <footer class="article-box__footer">
        <?php $simpleRating = new SD\SimpleRating\Core(); echo $simpleRating->likeCounterWidget(); ?><span>Data: <?php echo get_the_date('d.m.Y'); ?></span>
    </footer>
</article>
