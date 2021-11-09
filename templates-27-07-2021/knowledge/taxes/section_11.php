<section class="popular_questions">
    <?php if (get_row_layout() == 'section_11'): ?>
        <div class="container-taxes-small">
            <span class="popular_questions--title title text-center text-uppercase d-block"><?php the_sub_field('section_11_title'); ?></span>
            <div class="row">
                <div class="col-md-12 col-lg-10 mx-auto">
                    <div class="accordion list" id="accordion2">
                        <?php if (have_rows('questions__questions')): ?>
                            <?php $i = 10;
                            while (has_sub_field('questions__questions')): ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?php echo $i; ?>">
                                        <h2 class="mb-0">
                                            <button class="card-header--btn btn btn-link d-block section_11__question text-uppercase collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#c<?php echo $i; ?>" aria-expanded="false"
                                                    aria-controls="c<?php echo $i; ?>">
                                                <?php the_sub_field('question'); ?>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="c<?php echo $i; ?>" class="collapse"
                                         aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordion2">
                                        <div class="card-body section_11__answer ">
                                            <p><?php the_sub_field('answer'); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
