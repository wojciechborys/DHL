<?php

?>

<section class="section4">
    <div class="container-gogreen">
        <div class="row mx-0">
            <?php
            if (have_rows('gogreen__section4_blocks'));
            while (have_rows('gogreen__section4_blocks')) : the_row();
                $number = get_sub_field('gogreen__section4_blocks-number');
                $image = get_sub_field('gogreen__section4_blocks-img');
                $text = get_sub_field('gogreen__section4_blocks-text'); ?>
                <div class="section4__block col-12 col-lg-4 px-0">
                    <img src="<?php echo $image['url']; ?>" class="section4__block-img w-100">
                    </img>
                    <div class="section4__subblock d-flex align-items-center py-4">
                        <div class="section4__subblock-num font_gogreen--5">
                            <div><?php echo $number; ?><span class="dot">.</span></div>
                        </div>
                        <div class="section4__subblock-slash">
                            <div class="section4__subblock-slash-bg"> </div>
                        </div>
                        <div class="section4__subblock-text font_gogreen--9">
                            <?php echo $text; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            ?>
        </div>

    </div>
</section>