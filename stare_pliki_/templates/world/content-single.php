<?php
use SD\Template\Tags;

while (have_posts()) : the_post(); ?>
    <article <?php post_class(['post-single']); ?>>
        <div class="share-buttons share-buttons--big">
            <ul>
                <li><a rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(Tags\getPermalink()); ?>" target="_blank" class="share-buttons__link share-buttons__link--fb">Share on Facebook</a></li>
                <li><a rel="nofollow" href="https://twitter.com/home?status=<?php echo urlencode(Tags\getPermalink()); ?>" target="_blank" class="share-buttons__link share-buttons__link--twitter">Share on Facebook</a></li>
                <li><a rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(Tags\getPermalink()); ?>" target="_blank" class="share-buttons__link share-buttons__link--linkedin"></a></li>
            </ul>
        </div>
        <header class="post-single__header">


            <?php
            $tag = Tags\getMainTag();

            if ($tag) :
                ?><small class="post-single__main-tag"><a rel="nofollow" href="<?= esc_url(get_term_link($tag)); ?>" class="post-single__header-tag"><?= $tag->name; ?></a></small><?php
            endif;
            ?>

            <!-- <h1 class="post-single__title"><?php echo wp_trim_words( get_the_title(), 5, '...' ); ?></h1> -->
            <h1 class="post-single__title"><?php echo the_title(); ?></h1>

            <?php
            $subtitle = Tags\getSubtitle();

            if ($subtitle) :
                ?><p class="post-single__subtitle"><?= $subtitle; ?></p><?php
            endif;
            ?>
        </header>

        <div class="post-single__content">
            <?php
            $postThumbnail = get_the_post_thumbnail($post->ID, 'full', ['class' => 'post-single__thumbnail']);

            if ($postThumbnail) :
                ?><div class="post-single__thumbnail-wrap"><?= $postThumbnail; ?></div><?php
            endif;
            ?>

            <?php Tags\theContent(); ?>
        </div>

        <footer class="post-single__footer">
            <?php $simpleRating = new SD\SimpleRating\Core(); echo $simpleRating->likeCounterWidget(); ?>

            <ul class="socials">
                <li class="socials__item"><a rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(Tags\getPermalink()); ?>" target="_blank" class="socials__link socials__link--fb">Facebook</a></li>
                <li class="socials__item"><a rel="nofollow" href="https://twitter.com/home?status=<?php echo urlencode(Tags\getPermalink()); ?>" target="_blank" class="socials__link socials__link--twitter">Twitter</a></li>
                <li class="socials__item"><a rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo urlencode(Tags\getPermalink()); ?>" target="_blank" class="socials__link socials__link--yt">LinkedIn</a></li>
            </ul>
        </footer>
        <?php // comments_template('/templates/comments.php'); ?>
    </article>
<?php endwhile; ?>
