<?php

use Roots\Sage\Assets;


?>


<div class="container tails" id="<?php echo str_replace(' ', '-', get_sub_field('id')); ?>">
    <div class="row">
        <div class="col-12 text-center">
            <h2 class="tails__title">
                <?php
                echo get_sub_field('title');
                ?>
            </h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12 position-relative">
            <div class="tails-slider">
                <?php
                foreach (get_sub_field('tiles') as $key => $slide):
                    ?>
                    <div class="tail-slide">
                        <div class="tail-slide__pic-container">
                            <img class="tail-slide__pic" src="<?php echo $slide['icon']['url']; ?>"
                                 alt="<?php echo $slide['icon']['alt'] ?>">
                        </div>
                        <div class="text-center">
                            <h4 class="tail-slide__title">
                                <?php echo $slide['title']; ?>
                            </h4>
                            <p class="tail-slide__desc">
                                <?php echo $slide['desc']; ?>
                            </p>
                        </div>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
            <div class="tails-slider__arrows">
                <div class="tails-slider__arrow tails-slider__arrow--left">
                    <img src="
                    <?php echo esc_url(Assets\asset_path('images/arr-left.png', 'asset-sources/dhlknowledge/dist')); ?>"
                         alt="arrow left">
                </div>
                <div class="tails-slider__arrow tails-slider__arrow--right">
                    <img src="
                    <?php echo esc_url(Assets\asset_path('images/arr-right.png', 'asset-sources/dhlknowledge/dist')); ?>"
                         alt="arrow right">
                </div>
            </div>
        </div>
    </div>
</div>