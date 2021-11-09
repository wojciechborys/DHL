<?php if (get_row_layout() == 'ebook_section'):
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $pdf = get_sub_field('pdf');
    $image = get_sub_field('image');
    $id = get_sub_field('id');
    ?>
    <section id="<?php echo $id; ?>" class="<?php echo get_row_layout() ?> mb-5 pb-5">
        <div class="container-fluid  px-3 px-lg-0">
            <div class="row">
                <div class="offset-lg-2 col-lg-8 line">
                </div>
            </div>
        </div>
        <div class="container-fluid pr-0 px-lg-0 mt-lg-5 pt-lg-5">
            <div class="row">
                <div class="offset-lg-2 col-lg-4 pr-lg-5 order-2 order-lg-1">
                    <?php if ($title != '') { ?>
                        <h2 class="font__title--022 font__color--gray text-uppercase d-block mb-4 mb-lg-5 pr-3 pr-lg-0"><?php echo $title ?></h2>
                    <?php } ?>
                    <?php if ($text != '') { ?>
                        <div class="font__subtitle--0222 mb-4 color-gray2 pr-3 pr-lg-0"><?php echo $text ?></div>
                    <?php } ?>
                    <?php if ($pdf) { ?>
                        <a href="<?php echo $pdf['url'] ?>" class="btn btn--red-mini2 btn btn--auto btn-primary btn--calc mr-3" target="_blank">POBIERZ</a>
                    <?php } ?>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 mb-4 mb-lg-0">
                    <img class="w-100" src="<?php echo $image['url']; ?>"
                         alt="<?php echo $image['alt'] ?>">
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>