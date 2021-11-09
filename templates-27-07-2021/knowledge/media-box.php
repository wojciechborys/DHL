<?php

//the_post();

?>
<a href="<?php echo the_field('link'); ?>" class="media-box d-flex align-items-center col-md-12 col-lg-10 mx-auto" rel="nofollow noopener" target="_blank">
    <img src="<?php echo esc_url(get_field('logo')['url']); ?>" class="box__image">
    <div class="media-box__desc">
        <h4 class="media-box__title"><?php the_title() ?></h4>
        <span class="media-box__date"><?php echo the_field('data'); ?></span>
    </div>
</a>