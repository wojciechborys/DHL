<?php if (get_row_layout() == 'iframe_section'):
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $iframe = get_sub_field('iframe');
    $id = get_sub_field('id');
    ?>
    <section id="<?php echo $id; ?>" class="<?php echo get_row_layout() ?>">
        <div class="container mt-4 mt-lg-5 pt-5">
            <?php if ($title != '') { ?>
                <h2 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-4 mb-lg-5"><?php echo $title ?></h2>
            <?php } ?>
            <?php if ($text != '') { ?>
                <div class="font__subtitle--0222 mb-5 text-center color-gray2"><?php echo $text ?></div>
            <?php } ?>
            <div class="iframe">
                <iframe id="reusableIframe" class="form-box__iframe w-100"
                        src="<?php echo $iframe; ?>"
                        frameborder="0"></iframe>
            </div>
        </div>
    </section>

<?php endif; ?>