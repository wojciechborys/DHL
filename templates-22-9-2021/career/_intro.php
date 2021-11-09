<?php
use Roots\Sage\Assets;
use SD\Template\Tags;
use SD\Options;
use SD\Options\OptionsHelper;

$optionsHelper = OptionsHelper::getInstance();

$fp = is_front_page();

$companyInfoId = 'companyInfo';

$introTitle = $fp ? Options\getOption('general::front_header') : get_the_title();
$introContent = $fp ? $optionsHelper->get('general::front_text') : get_the_content();
$introButton = $fp ? $optionsHelper->get('general::front_button') : $optionsHelper->get('general::front_button');
?>
<section class="content-intro<?php if ($fp) : ?> content-intro--video-bg<?php endif; ?>" id="top">
    <div class="content-intro__top">
        <div class="content-intro__container container">
            <div class="row">
                <div class="col-12 col-md-8 col-lg-7">
                    <h1 class="content-intro__header"><?= $introTitle; ?></h1>
                    <p class="content-intro__info"><?= $introContent; ?></p>

                    <p class="content-intro__btn-wrapper">
                        <a href="#<?= $companyInfoId; ?>" class="btn btn-primary content-intro__btn" data-toggle="collapse"><?= $introButton; ?></a>
                    </p>
                </div>
            </div>

        </div>

        <?php
        if ($fp) :
            ?><div class="content-intro__video-bg-container">
            <div class="content-intro__video-bg-block">
                <video class="content-intro__video-bg" autoplay muted loop>
                    <source src="<?= esc_url(Assets\asset_path('video/video-bg.mp4')); ?>" type="video/mp4">
                </video>
            </div>
        </div><?php
        endif;
        ?>
    </div>

    <div class="content-intro__container container" id="<?= $companyInfoId; ?>Container">
        <div class="row">
            <div class="col-12">
                <div class="content-intro__company-info collapse" id="<?= $companyInfoId; ?>">
                    <?php Tags\aboutContent(); ?>

                    <div class="content-intro__info-btn-wrapper">
                        <button class="content-intro__info-btn btn btn-primary" role="button" data-toggle="collapse" data-target="#<?= $companyInfoId; ?>" data-scroll="#<?= $companyInfoId; ?>Container">Zamknij</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
