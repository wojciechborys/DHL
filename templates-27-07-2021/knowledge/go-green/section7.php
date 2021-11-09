<?php
$image = get_field('gogreen__section7_photo');
$upperText = get_field('gogreen__section7_upper_text');
$treeNumber = get_field('gogreen__section7_number');
$bottomText = get_field('gogreen__section7_bottom_text');
?>

<section class="section7">
    <div class="container-gogreen">
            <div class="col-lg-12 col-12 section7__bg d-flex flex-column align-items-center justify-content-center" style="background-image: url(<?php echo $image['url'] ?>);">
                <span class="section7__upperText font_gogreen--6">
                    <?php echo $upperText ?>
                </span>

                <span class="section7__treeNumber font_gogreen--7 py-3">
                    <?php echo $treeNumber ?>
                </span>

                <span class="section7__bottomText font_gogreen--8">
                    <?php echo $bottomText ?>
                </span>
            </div>
    </div>
</section>