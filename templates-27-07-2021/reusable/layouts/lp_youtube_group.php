<?php

use Roots\Sage\Assets;

$youtube_link = get_sub_field('youtube_link');
$link = get_sub_field('link');
?>
<div class="container text-center youtube-titles-container"
     id="<?php echo str_replace(' ', '-', get_sub_field('id')); ?>">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <h3 class="font__title--022 youtube-titles-container__title"><?php
                echo get_sub_field('title');
                ?></h3>
            <div class="youtube-titles-container__desc">
                <?php
                echo get_sub_field('desc');
                ?>
            </div>
            <?php if ($link): ?>
                <a class="btn btn--auto btn--red btn-primary btn--calc form-new-send-2" href="<?php
                echo $link['url'];
                ?>"><?php
                    echo $link['title'];
                    ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="container-fluid youtube-main">
    <div class="row">
        <div class="col-12 p-0">
            <div class="video video-section mw-100">
                <div class="video-wrapper">
                    <div id="ytVideo" class="ytVideo" data-yt-link="<?php echo $youtube_link['link']; ?>"
                         data-yt-id="<?php echo $youtube_link['video_id']; ?>"></div>
                </div>
                <div class="video-overlay d-flex justify-content-center align-items-center flex-column"
                     style="background-image: url('<?php echo get_sub_field('poster'); ?>')">
                    <div class="play-btn" id="play-btn"
                         style='background-image: url("<?php echo esc_url(Assets\asset_path('images/play-btn.png', 'asset-sources/dhlknowledge/dist')); ?>")'
                         alt="play btn">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
