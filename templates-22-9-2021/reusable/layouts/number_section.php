<?php if (get_row_layout() == 'number_section'):
    $title = get_sub_field('title');
    $numbers = get_sub_field('numbers');
    $text_bottom = get_sub_field('text_bottom');
    $ID = get_sub_field('id');
    ?>
    <section id="<?php echo $id; ?>" class="<?php echo get_row_layout() ?>">
        <div class="container content-section">
            <h2 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-4 mb-lg-5 pb-3"><?php echo $title ?></h2>
            <div class="carousel-numbers pt-3 pb-2">
                <?php
                foreach ($numbers as $key => $number):
                    ?>
                    <div class="number-slide">
                        <div class="text-center">
                            <h4 class="font__title--01 number-slide__title mb-4">
                                <?php echo $number['number']; ?>
                            </h4>
                            <p class="number-slide__desc font__subtitle--022">
                                <?php echo $number['text']; ?>
                            </p>
                        </div>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
            <div class="text-center pt-4 pt-lg-5">
                <?php echo $text_bottom; ?>
            </div>
        </div>
    </section>

<?php endif; ?>