<?php
?>

<?php if (get_row_layout() == 'section_7'): ?>
    <section class="section_7">
        <div class="container-taxes-small">
            <div class="section_7__title title pb-3"><?php the_sub_field('section_7_title'); ?></div>
            <div class="pb-5 section_7__subtitle"><?php the_sub_field('section_7_subtitle'); ?></div>
            <div class="row pt-3 justify-content-center">
                <div class="col-md-6">
                    <div class="section_7__left-title pb-4">
                        <?php the_sub_field('section_7_left_title'); ?>
                    </div>
                    <div class="section_7__left-subtext pb-4">
                        <?php the_sub_field('section_7_left_subtext'); ?>
                    </div>
                    <ul class="taxes-page__list">
                        <?php
                        if (have_rows('section_7_left_list')):
                            while (have_rows('section_7_left_list')) : the_row();
                                $text = get_sub_field('section_7_left_list_item')
                                ?>
                                <li class="taxes-page__list__item pt-3"><?php echo $text ?></li>
                            <?php
                            endwhile;
                        endif; ?>
                    </ul>
                </div>

                <div class="col-md-6 section_7__right">
                    <div class="section_7__right-main-wrapper">
                        <!--                                <div class="section_7__right-mark"></div>-->
                        <div class="section_7__right-wrapper">
                            <div class="section_7__right-title pb-4">
                                <?php the_sub_field('section_7_right_title'); ?>
                            </div>
                            <div class="section_7__right-text ">
                                <?php the_sub_field('section_7_right_subtext'); ?>
                            </div>
                        </div>
                    </div>
                    <?php $image = get_sub_field('section_7_right_image'); ?>
                    <div class="text-center">
                        <img class="section_7__right__image" src="<?php echo $image['url']; ?>">
                    </div>
                </div>

            </div>
        </div>
    </section>
<?php endif; ?>



