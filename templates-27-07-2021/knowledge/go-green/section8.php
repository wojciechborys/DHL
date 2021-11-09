<?php
$image = get_field('gogreen__section8_photo');
$title = get_field('gogreen__section8_title');
$body = get_field('gogreen__section8_body');
$link = get_field('gogreen__section8_url');
$show_section = get_field('gogreen__section8_enabled');
$btn_text = get_field('gogreen__section8_btn');
?>

<?php if ($show_section) { ?>
    <section>
        <div class="container-gogreen pb-5 pb-lg-0">
            <div class="row d-flex align-items-center">

                <div class="col-lg-4">
                    <img src="<?php echo $image['url']; ?>" class="w-100 section2__image pb-5 pb-lg-0">
                </div>

                <div class="col-lg-7 offset-lg-1 section2__wrapper">
                    <div class="section2__title font_gogreen--3 px-4 px-lg-0"><?php echo $title ?></div>
                    <div class="section2__mark mt-3 mb-4"></div>
                    <div class="section2__desc font_gogreen--4 px-4 px-lg-0"><?php echo $body ?></div>
                    <div>
                        <a href=<?php echo $link ?> class="btn btn-primary mt-4 btn-lg section8__btn" role="button" aria-pressed="true"><?php echo $btn_text ?></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
} ?>