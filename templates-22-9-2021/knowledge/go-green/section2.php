<?php
$image = get_field('gogreen__section2_photo');
$title = get_field('gogreen__section2_title');
$body = get_field('gogreen__section2_body');
?>


<section>
    <div class="container-gogreen">
        <div class="row d-flex align-items-center">
            <div class="col-lg-4">
                <img src="<?php echo $image['url']; ?>" class="w-100 section2__image">
            </div>
            <div class="col-lg-7 offset-lg-1 section2__wrapper py-5 py-md-5 py-lg-0">
                <div class="section2__title font_gogreen--3 px-3 px-lg-0"><?php echo $title ?></div>
                <div class="section2__mark mt-3 mb-4"></div>
                <div class="section2__desc font_gogreen--4 px-2 px-lg-0"><?php echo $body ?></div>
            </div>
        </div>
    </div>
</section>