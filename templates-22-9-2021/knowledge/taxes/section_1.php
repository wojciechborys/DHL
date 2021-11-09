<?php if (get_row_layout() == 'section_1'):
    $title = get_sub_field('section_1_title');
    $headerTitle = get_sub_field('section_1_image_title');
    $headerSubtitle = get_sub_field('section_1_image_subtitle');
    $subtitle = get_sub_field('section_1_subtitle');
    $imageHeader = get_sub_field('section_1_image')['url'];
    ?>

    <section class="<?php echo get_row_layout() ?>">
        <div class="section_1__image" style="background-image: url('<?php echo $imageHeader ?>');">
<!--            <img src="--><?php //echo $imageHeader ?><!--" class="img-fluid">-->
            <div class="section_1__image__gradient"></div>
            <div class="container-taxes">
                <div class="section_1__header">
                    <div class="section_1__header__title"><?php echo $headerTitle ?></div>
                    <div class="section_1__header__subtitle"><?php echo $headerSubtitle ?></div>
                </div>
            </div>
        </div>

    </section>

<?php endif; ?>
