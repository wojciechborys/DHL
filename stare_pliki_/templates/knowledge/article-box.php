<?php
use SD\Template\Tags;
use SD\Restricted;

//the_post();

$thumbnail = Tags\getFeaturedImageSrc();


?>
<div class="col-sm-6 col-md-6 col-lg-4 mb-4">
    <div class="article_blog--item bg__color--gray-light">
        <?php if ($thumbnail) { ?>
            <img class="img-fluid w-100" src="<?php echo esc_url($thumbnail); ?>" alt=""/>
        <?php } else { ?>
            <div class="article-box__image"
                 style="background: #333; padding-bottom:66.666666666666%; width:100%; height:0;"></div>
        <?php } ?>
        <div class="article_blog--desc">
            <a href="<?php the_permalink() ?>" title="<?php the_title() ?>" class="d-block font__title--04 font__color--gray mb-3"><?php the_title() ?></a>
            <span class="font__subtitle--16-2"><?php
                $excerpt = \wp_trim_words(\strip_shortcodes(get_the_excerpt()), 11, '&hellip;');
                echo $excerpt;
                ?> </span>
        </div>
    </div>
</div>