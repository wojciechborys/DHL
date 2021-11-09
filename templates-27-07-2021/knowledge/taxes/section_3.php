<?php if (get_row_layout() == 'section_3'): ?>
    <section class="popular_questions">
        <div class="container-taxes">
            <div class="row">
                <div class="col mx-auto">
                    <div class="accordion list" id="accordion">
                        <?php if (have_rows('section_3_item')): ?>
                            <?php $i = 0;
                            while (has_sub_field('section_3_item')): ?>
                                <div class="card">
                                    <div class="card-header px-0" id="heading<?php echo $i; ?>">
                                        <h2 class="mb-0 py-md-3">
                                            <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#c<?php echo $i; ?>" aria-expanded="false"
                                                    aria-controls="c<?php echo $i; ?>">
                                                <?php the_sub_field('section_3_impact_main_title'); ?>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="c<?php echo $i; ?>" class="show"
                                         aria-labelledby="heading<?php echo $i; ?>"
                                         data-parent="#accordion">
                                        <div class="card-body font__subtitle--0222">
                                            <div class="row">
                                                <div class="col-12 col-md-6">
                                                    <div class="section_3__title"> <?php the_sub_field('section_3_impact_title'); ?> </div>
                                                    <div class="pt-3"> <?php the_sub_field('section_3_impact_text'); ?></div>
                                                    <div class="pt-5 section_3__title"> <?php the_sub_field('section_3_impact_routes_title'); ?></div>
                                                    <div class="pt-3"> <?php the_sub_field('section_3_impact_routes_text'); ?></div>
                                                    <?php $image = get_sub_field('section_3_impact_routes_image'); ?>
                                                    <img class="pt-5 w-100 pb-3" src="<?php echo $image['url']; ?>"> </img>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <div class="section_3__title"> <?php the_sub_field('section_3_what_dhl_is_doing_title'); ?> </div>
                                                    <div class="pt-3"> <?php the_sub_field('section_3_what_dhl_is_doing_subtitle'); ?> </div>
                                                    <ul class="taxes-page__list">
                                                        <?php
                                                        if (have_rows('section_3_what_dhl_is_doing_list')):
                                                            while (have_rows('section_3_what_dhl_is_doing_list')) : the_row();
                                                                $item = get_sub_field('section_3_what_dhl_is_doing_list_item');
                                                                ?>
                                                                <li class="taxes-page__list__item pt-3"> <?php echo $item ?> </li>
                                                            <?php
                                                            endwhile;
                                                        endif;
                                                        ?>
                                                    </ul>

                                                    <div class="pt-4 section_3__title"> <?php the_sub_field('section_3_what_is_needed_from_you_title'); ?> </div>
                                                    <div class="pt-3"> <?php the_sub_field('section_3_what_is_needed_from_you_subtitle'); ?> </div>
                                                    <ul class="taxes-page__list">
                                                        <?php
                                                        if (have_rows('section_3_what_is_needed_from_you_list')):
                                                            while (have_rows('section_3_what_is_needed_from_you_list')) : the_row();
                                                                $item = get_sub_field('section_3_what_is_needed_from_you_list_item');
                                                                ?>
                                                                <li class="taxes-page__list__item"> <?php echo $item ?> </li>
                                                            <?php
                                                            endwhile;
                                                        endif;
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>


