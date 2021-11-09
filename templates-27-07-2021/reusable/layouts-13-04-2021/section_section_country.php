`<?php
if (get_field('countries__text') != "") {
    $text = get_field('countries__text_override');
}
else {
    $text = get_field('country__text', 'option');
}

?>

<section class="mt-5 mb-5">
    <div class="container">
        <span class="font__title--022 font__color--gray text-center text-uppercase d-block mb-4"><?php echo get_field('country__title', 'option'); ?></span>
        <p class="text-center mb-5 px-lg-5 w-75 mx-auto"><?php echo $text ?></p>
        <div class="row pt-lg-4">
            <div class="col-md-12 col-lg-10 mx-auto">
                <div class="accordion list" id="accordion">
                    <?php if (have_rows('continent', 'option')): ?>
                        <?php $i = 0;
                        while (have_rows('continent', 'option')): the_row(); ?>
                            <div class="card">
                                <div class="card-header" id="heading<?php echo $i; ?>">
                                    <h2 class="mb-0 py-0" style="margin-bottom: 0px !important;">
                                        <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed"
                                                type="button" data-toggle="collapse"
                                                data-target="#c<?php echo $i; ?>" aria-expanded="false"
                                                aria-controls="c<?php echo $i; ?>">
                                            <?php the_sub_field('name'); ?>
                                        </button>
                                    </h2>
                                </div>
                                <div id="c<?php echo $i; ?>" class="collapse show"
                                     aria-labelledby="heading<?php echo $i; ?>" data-parent="#accordion">
                                    <div class="d-flex justify-content-between mb-3 px-1 px-lg-0">
                                        <?php for ($j = 1; $j < 4; $j++) { ?>
                                            <?php $column = get_sub_field('column_' . $j); ?>
                                            <?php if ($column['kraje']) : ?>
                                                <div class="col-4 px-lg-0">
                                                    <?php foreach ($column['kraje'] as $country) { ?>
                                                        <?php if ($country['link'] != ""): ?>
                                                            <a class="d-block country__bottom__text"
                                                               href="<?php echo esc_attr($country['link']); ?>"
                                                               title="<?php echo esc_attr($country['name']); ?>"><?php echo $country['name'] ?></a>
                                                        <?php else: ?>
                                                            <span class="d-block country__bottom__text"><?php echo $country['name']; ?></span>
                                                        <?php endif; ?>
                                                    <?php } ?>
                                                </div>
                                            <?php endif; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <?php $i++; endwhile; ?>
                    <?php endif; ?>
                </div>
                <?php the_field('js_code'); ?>
            </div>
        </div>
    </div>
    <div>
        <?php echo get_field('scripts_questions_service_point', 'option'); ?>
    </div>
</section>
`