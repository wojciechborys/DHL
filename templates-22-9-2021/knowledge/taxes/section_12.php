<?php
$title = get_sub_field('section_12_title');
$subtitle = get_sub_field('section_12_subtitle');
$videoUrl = get_sub_field('section_12_video_url_');
$videoBg = get_sub_field('section_12_video_bg');
$videoId = get_sub_field('section_12_video_id');


use Roots\Sage\Assets;
?>

<section class="section_12">
    <div class="container-taxes border-bottom">
        <div class="content">
            <h2 class="section_12--title"><?php echo $title ?></h2>
            <div class="section_12--box-subtitle">
                <div class="section_12--subtitle"><?php echo $subtitle ?></div>
            </div>
            <div class="section_12__video youtube-main">
                <div class="video video-section mw-101 w-101 h-100">
                    <div class="video-wrapper section12-video-handle w-101 h-100">
                        <div id="ytVideo" class="ytVideo" data-yt-link="<?php echo $videoUrl; ?>" data-yt-id="<?php echo $videoId; ?>"></div>
                    </div>

                    <div class="video-overlay d-flex justify-content-center align-items-center flex-column" style="background-image: url('<?php echo $videoBg['url']; ?>')">
                        <div class="play-btn" id="play-btn" style='background-image: url("<?php echo esc_url(Assets\asset_path('images/play-btn-white.png', 'asset-sources/dhlknowledge/dist')); ?>")' alt="play btn"> </div>

                    </div>
                </div>
            </div>

            <div class="col-12 section_12__video-mobile youtube-main px-0">
                <div class="video video-section mw-101 w-101 h-100">
                    <div class="video-wrapper gogreen-video-handle-mobile w-101 h-100">
                        <div id="ytVideoMobile" class="ytVideo" data-yt-link="<?php echo $videoUrl; ?>" data-yt-id="<?php echo $videoId; ?>"></div>
                    </div>

                    <div class="video-overlay d-flex justify-content-center align-items-center flex-column bg-mobile" style="background-image: url('<?php echo $videoBg['url']; ?>')">
                        <div class="play-btn play-btn-mobile" id="play-btn" style='background-image: url("<?php echo esc_url(Assets\asset_path('images/play-btn-white.png', 'asset-sources/dhlknowledge/dist')); ?>")' alt="play btn"> </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</section>
