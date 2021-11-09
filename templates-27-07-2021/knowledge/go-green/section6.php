<?php
$image = get_field('gogreen__section6_photo');
$title = get_field('gogreen__section6_title');
$body = get_field('gogreen__section6_body');
?>


<section>
    <div class="container-gogreen" style="background-color: #f7f7f7">
        <div class="row d-flex align-items-center">

            <div class="col-lg-4">
                <img src="<?php echo $image['url']; ?>" class="w-100 section2__image">
            </div>

            <div class="col-lg-7 offset-lg-1 section2__wrapper py-5 py-md-5 py-lg-0">
                <div class="section2__title font_gogreen--3 px-4 px-lg-0"><?php echo $title ?></div>
                <div class="section2__mark mt-3 mb-4"></div>
                <?php
                if (have_rows('gogreen__section6_text'));
                while (have_rows('gogreen__section6_text')) : the_row();
                    $sub_value = get_sub_field('gogreen__section6_text-iso');
                    echo '<div class="section2__desc font_gogreen--4 pb-4 px-4 px-lg-0">' . $sub_value . '</div>';
                endwhile;
                ?>
            </div>
        </div>
    </div>
</section>