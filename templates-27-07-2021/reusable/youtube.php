<?php

use Roots\Sage\Assets;

$youtube = get_field('lp_youtube_group', $post->ID);

?>
<div class="container text-center youtube-titles-container" id="<?php echo str_replace(' ', '-', $youtube['id']); ?>">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <h3 class="font__title--022 youtube-titles-container__title"><?php
                echo $youtube['title'];
                ?></h3>
            <div class="youtube-titles-container__desc">
                <?php
                echo $youtube['desc'];
                ?>
            </div>
            <a class="btn btn--auto btn--red btn-primary btn--calc form-new-send" href="<?php
            echo $youtube['link']['url'];
            ?>"><?php
                echo $youtube['link']['title'];
                ?></a>
        </div>
    </div>
</div>
<div class="container-fluid youtube-main">
    <div class="row">
        <div class="col-12 p-0">
            <div class="video video-section mw-100">
                <div class="video-wrapper">
                    <div id="ytVideo" class="ytVideo" data-yt-link="<?php echo $youtube['youtube_link']['link']; ?>"
                         data-yt-id="<?php echo $youtube['youtube_link']['video_id']; ?>"></div>
                </div>
                <div class="video-overlay d-flex justify-content-center align-items-center flex-column"
                     style="background-image: url('<?php echo $youtube['poster']; ?>')">
                    <div class="play-btn" id="play-btn"
                         style='background-image: url("<?php echo esc_url(Assets\asset_path('images/play-btn.png', 'asset-sources/dhlknowledge/dist')); ?>")'
                         alt="play btn">
                    </div>
                </div>
            </div>
        </div>
    </div>
