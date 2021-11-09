<?php if (get_row_layout() == 'section_4'): ?>
    <section class="section_4">
        <div class="container-taxes-small">
            <div class="row justify-content-center">
                <div class="section_4__title title pb-5"><?php the_sub_field('section_4_title'); ?></div>
            </div>
            <div class="row justify-content-center">
                <?php if (have_rows('section_4_box')):
                    while (have_rows('section_4_box')) : the_row();
                        $title = get_sub_field('section_4_box_title');
                        $subtitle = get_sub_field('section_4_box_subtitle');
                        $subtext = get_sub_field('section_4_box_subtext');
                        ?>

                        <div class="col-md-6 mx-auto">
                            <div class="section_4__box">
                                <div class="section_4__box_top pt-5">
                                    <div class="section_4__box_top__title px-5 pb-3">
                                        <?php echo $title; ?>
                                    </div>
                                    <div class="section_4__box_top__icon"></div>
                                </div>
                                <div class="section_4__box_bottom px-4">
                                    <div class="d-flex flex-column">
                                        <div class="text-center font-weight-bold">
                                            <?php echo $subtitle; ?>
                                        </div>
                                        <div class="section_4__box_bottom__text">
                                            <?php echo $subtext; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>



