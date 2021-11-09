<?php if (get_row_layout() == 'section_5'): ?>
    <section class="section_5">
        <div class="container-taxes-small">
            <div class="section_5__title"><?php the_sub_field('section_5_mobile_title'); ?></div>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="section_5__left-title pb-4 mb-3">
                        <?php the_sub_field('section_5_left_title'); ?>
                    </div>
                    <ul class="taxes-page__list marker-ok">
                        <?php
                        if (have_rows('section_5_left_list')):
                            while (have_rows('section_5_left_list')) : the_row();
                                $text = get_sub_field('section_5_left_list_item')
                                ?>
                                <li class="taxes-page__list__item"><?php echo $text ?></li>
                                <!--                                        <div class="section_5__left-item pb-3">-->
                                <!--                                            <div class="section_5__left-item_icon"></div>-->
                                <!--                                            <div class="section_5__left-item_text pl-2">--><?php //echo $text ?><!--</div>-->
                                <!--                                        </div>-->
                            <?php
                            endwhile;
                        endif; ?>
                    </ul>
                </div>
                <div class="col-md-6 section_5__right">
                    <div class="section_5__right-main-wrapper">
                        <!--                                <div class="section_5__right-mark"></div>-->
                        <div class="section_5__right-wrapper">
                            <div class="section_5__right-title pb-4 mb-3">
                                <?php the_sub_field('section_5_right_title'); ?>
                            </div>
                            <div class="section_5__right-text">
                                <?php the_sub_field('section_5_right_text'); ?>
                            </div>
                        </div>
                    </div>
                    <?php $image = get_sub_field('section_5_right_image'); ?>
                    <div class="text-center">
                        <img class="section_5__right__image" src="<?php echo $image['url']; ?>"/>
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php endif; ?>



