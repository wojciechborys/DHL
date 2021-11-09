<?php
$id = get_the_ID();

if (is_tax()) {
    $id = get_queried_object();
}

if(get_field('questions_global_settings', $id)) {
    $questions = 'option';
    $scripts = get_field('scripts_questions_service_point', 'option');
} else {
    $questions =  $id;
    $scripts = get_field('scripts_questions_service_point', $id);
}

if (get_field('questions__enable', $id)) :
    $title = get_field('questions__title', $id);
    ?>
    <section class="popular_questions">
        <div class="container">
            <span class="popular_questions--title font__title--022 font__color--gray text-center text-uppercase d-block"><?php echo $title; ?></span>
            <div class="row">
                <div class="col-md-12 col-lg-10 mx-auto">
                    <div class="accordion list" id="accordion">
                        <?php if (have_rows('questions_service_point', $questions)): ?>
                            <?php $i = 0;
                            while (have_rows('questions_service_point', $questions)): the_row(); ?>
                                <div class="card">
                                    <div class="card-header" id="heading<?php echo $i; ?>">
                                        <h2 class="mb-0">
                                            <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed"
                                                    type="button" data-toggle="collapse"
                                                    data-target="#c<?php echo $i; ?>" aria-expanded="false"
                                                    aria-controls="c<?php echo $i; ?>">
                                                <?php the_sub_field('title'); ?>
                                            </button>
                                        </h2>
                                    </div>
                                    <div id="c<?php echo $i; ?>" class="collapse show"
                                         aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordion">
                                        <div class="card-body font__subtitle--0222">
                                            <p><?php the_sub_field('text'); ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <?php echo $scripts; ?>
        </div>
    </section>
<?php endif; ?>
