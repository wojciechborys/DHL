<?php if (get_row_layout() == 'image_text_section'):
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $image_text = get_sub_field('image_text');
    $ID = get_sub_field('id');
    ?>
    <section class="<?php echo get_row_layout() ?>">
        <div class="container mt-4 mt-lg-5 pt-5">
            <h2 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-4 mb-lg-5"><?php echo $title ?></h2>
            <div class="font__subtitle--0222 mb-5 text-center color-gray2"><?php echo $text ?></div>
            <div class="image-text">
                <?php
                foreach ($image_text
                         as $key => $row):
                    ?>
                    <div class="row align-items-center image-text-row">
                        <div class="col-lg-6 order-2 <?php echo $row['image_position'] === 'left' ? 'order-lg-2 pl-lg-5' : 'order-lg-1 pr-lg-5' ?>">
                            <h4 class="font__title--0333 image-text-title mb-4 text-uppercase"><?php echo $row['title'] ?></h4>
                            <div class="image-text-desc font__subtitle--0222 color-gray2 <?php echo $row['image_position'] === 'left' ? '' : 'w-75' ?>"><?php echo $row['text'] ?></div>
                        </div>
                        <div class="col-lg-6 order-1 text-center text-lg-left <?php echo $row['image_position'] === 'left' ? 'order-lg-1 pr-lg-5' : 'order-lg-2 ' ?>">
                            <img class="img-fluid" src="<?php echo $row['image']['url']; ?>"
                                 alt="<?php echo $row['image']['alt'] ?>">
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
    </section>

<?php endif; ?>