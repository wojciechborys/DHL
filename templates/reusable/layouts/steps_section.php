<?php if (get_row_layout() == 'steps_section'):
    $title = get_sub_field('title');
    $steps = get_sub_field('steps');
    $text = get_sub_field('text');
    $image = get_sub_field('image');
    $ID = get_sub_field('id');
    ?>
    <section id="<?php echo $id; ?>" class="<?php echo get_row_layout() ?>">
        <div class="container-fluid position-relative px-0">
            <div class="row">
                <div class="offset-md-4 col-lg-7 step-img">
                    <?php if ($image) : ?>
                        <img class="img-fluid" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
                    <?php endif; ?>
                </div>
                <div class="steps">
                    <h4 class="font__title--022 font__color--gray text-uppercase d-block pt-3 pt-lg-0 mb-4"><?php echo $title ?></h4>
                    <div class="font__subtitle--0222 mb-5 benefits__subtitle color-gray2"><?php echo $text; ?></div>
                    <div class="d-block d-lg-flex flex-wrap">
                        <?php
                        $i = 1;
                        foreach ($steps as $key => $step):
                            ?>
                            <div class="step-item d-flex flex-column align-items-center align-items-lg-start justify-content-center justify-content-lg-start flex-lg-row col-lg-10">
                                <div class="step-item__number"><span class="step-item__number-text">Krok <?php echo $i; ?></span></div>
                                <span class="step-item__text color-gray2">
                                    <?php echo $step['text']; ?>
                                </span>
                            </div>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>