<?php

use SD\Template\Tags;
use SD\Restricted;

//the_post();

$thumbnail = get_the_post_thumbnail_url();


?>
<div class="col-lg-12 mb-4">
    <div class="article_blog--item article_blog--item-big bg__color--gray-light d-flex">
        <?php if ($thumbnail) { ?>
            <img class="img-fluid article_blog--item-big__img w-50 pr-2" src="<?php echo esc_url($thumbnail); ?>" alt=""/>
        <?php } else { ?>
            <div class="article-box__image"
                 style="background: #333; padding-bottom:66.666666666666%; width:100%; height:0;"></div>
        <?php } ?>
        <div class="article_blog--desc w-50">
            <a href="<?php the_permalink() ?>" title="<?php the_title() ?>"
               class="d-block font__title--04 font__color--gray mb-3"><?php the_title() ?></a>
            <span class="font__subtitle--16-2"><?php
                $excerpt = \wp_trim_words(\strip_shortcodes(get_the_excerpt()), 15, '&hellip;');
                echo $excerpt;
                ?> </span>
        </div>
    </div>
</div>



