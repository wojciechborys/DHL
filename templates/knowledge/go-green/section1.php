<?php
$title = get_field('gogreen__section1_title');
$body = get_field('gogreen__section1_body');
$videoUrl = get_field('gogreen__section1_video-url');
$videoBg = get_field('gogreen__section1_video-bg');
$videoId = get_field('gogreen__section1_video-id');
$image = get_field('gogreen__section1_bg');

use Roots\Sage\Assets;
?>

<section class="section1">
    <div class="container-gogreen">
        <div class="row mx-0">
            <div class="col-12 section1__bg d-flex justify-content-center" style="background-image: url(<?php echo $image['url'] ?>);">

                <div class="section1__block">
                    <h1 class="section1__block-header font_gogreen--1"> <?php echo $title; ?> </h1>
                    <div class="section1__block-mark"></div>
                    <h2 class="section1__block-subheader font_gogreen--2 px-md-5 px-lg-0"><?php echo $body; ?></h2>
                </div>

                <div class="section1__video youtube-main">
                    <div class="video video-section mw-100 w-100 h-100">
                        <div class="video-wrapper gogreen-video-handle w-100 h-100">
                            <div id="ytVideo" class="ytVideo" data-yt-link="<?php echo $videoUrl; ?>" data-yt-id="<?php echo $videoId; ?>"></div>
                        </div>

                        <div class="video-overlay d-flex justify-content-center align-items-center flex-column" style="background-image: url('<?php echo $videoBg['url']; ?>')">
                            <div class="play-btn" id="play-btn" style='background-image: url("<?php echo esc_url(Assets\asset_path('images/play-btn-red.png', 'asset-sources/dhlknowledge/dist')); ?>")' alt="play btn"> </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 section1__video-mobile youtube-main px-0">
                <div class="video video-section mw-100 w-100 h-100">
                    <div class="video-wrapper gogreen-video-handle-mobile w-100 h-100">
                        <div id="ytVideoMobile" class="ytVideo" data-yt-link="<?php echo $videoUrl; ?>" data-yt-id="<?php echo $videoId; ?>"></div>
                    </div>

                    <div class="video-overlay d-flex justify-content-center align-items-center flex-column" style="background-image: url('<?php echo $videoBg['url']; ?>')">
                        <div class="play-btn play-btn-mobile" id="play-btn" style='background-image: url("<?php echo esc_url(Assets\asset_path('images/play-btn-red.png', 'asset-sources/dhlknowledge/dist')); ?>")' alt="play btn"> </div>
                    </div>
                </div>
            </div>
        </div>

</section>