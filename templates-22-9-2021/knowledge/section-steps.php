<?php

$title = get_field('steps__title');
$text = get_field('steps__text');
$bottom_text = get_field('steps__bottom_text');

?>
<section class="homeinfo">
    <div class="container">
        <span class="font__title--022 font__color--gray text-uppercase text-center text-lg-left d-block mb-3"><?php echo $title; ?></span>
        <div class="pb-3 pb-lg-5">
            <div class="font__subtitle--0222 homeinfo--subtitle"> <?php echo $text; ?></div>
        </div>
        <div class="row d-flex justify-content-center justify-content-lg-start homeinfo--container mt-2 mt-lg-4">
            <?php
            $step = get_field('steps__step_1');
            if ($step): ?>
                <a class="col-12 col-md-6 col-lg-4 order-2 order-lg-0 align-self-end homeinfo--item"
                   href="<?php echo esc_url($step['link']); ?>">
                    <div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="<?php echo esc_url($step['image']['url']); ?>"
                             alt="<?php echo $step['image']['alt']; ?>">
                    </div>
                    <span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left"><?php echo $step['title'] ?></span>
                    <span class="font__subtitle--0222 homeinfo--subtitle "><?php echo $step['text'] ?></span>

                    <?php if ($step['button_text'] != "") { ?>
                        <div class="teaser-buttons">
                            <span class="btn btn--red-mini2 btn btn--auto btn-primary btn--calc"><?php echo $step['button_text']; ?></span>
                        </div>
                    <?php } ?>

                    <hr>
                </a>
            <?php endif; ?>
            <?php
            $step = get_field('steps__step_2');
            if ($step): ?>
                <a class="col-12 col-md-6 col-lg-4 order-1 order-lg-1 align-self-center homeinfo--item"
                   href="<?php echo esc_url($step['link']); ?>">
                    <div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="<?php echo esc_url($step['image']['url']); ?>"
                             alt="<?php echo $step['image']['alt']; ?>">
                    </div>
                    <span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left"><?php echo $step['title'] ?></span>
                    <span class="font__subtitle--0222 homeinfo--subtitle"><?php echo $step['text'] ?></span>
                    <?php if ($step['button_text'] != "") { ?>
                        <div class="teaser-buttons">
                            <span class="btn btn--red-mini2 btn btn--auto btn-primary btn--calc"><?php echo $step['button_text']; ?></span>
                        </div>
                    <?php } ?>
                    <hr>
                </a>
            <?php endif; ?>
            <?php
            $step = get_field('steps__step_3');
            if ($step): ?>
                <a class="col-12 col-md-6 col-lg-4 order-0 order-lg-2 align-self-start homeinfo--item"
                   href="<?php echo esc_url($step['link']); ?>">
                    <div class="homeinfo--img d-block text-center d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="<?php echo esc_url($step['image']['url']); ?>"
                             alt="<?php echo $step['image']['alt']; ?>">
                    </div>
                    <span class="homeinfo--title d-block font__title--05 font__color--red text-center text-sm-left"><?php echo $step['title'] ?></span>
                    <span class="font__subtitle--0222 homeinfo--subtitle"><?php echo $step['text'] ?></span>

                    <?php if ($step['button_text'] != "") { ?>
                        <div class="teaser-buttons">
                            <span class="btn btn--red-mini2 btn btn--auto btn-primary btn--calc"><?php echo $step['button_text']; ?></span>
                        </div>
                    <?php } ?>
                    <hr>
                </a>
            <?php endif; ?>
        </div>
        <div class="mt-5">
            <div class="font__subtitle--0222 homeinfo--subtitle"> <?php echo $bottom_text; ?></div>
        </div>
    </div>
</section>