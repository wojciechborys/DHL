<?php
$id = get_the_ID();

if (get_field('materials__enable', $id)) :
    $title = get_field('materials__title', $id);

    $posts = get_field('materials_files', $id);
    ?>

    <section class="related_files">
        <div class="container">
            <span class="d-block font__title--4 font__color--red"><?php echo $title; ?></span>
            <div class="row related_files--items">
                <?php if ($posts): ?>
                    <?php foreach ( $posts as $material_id ): ?>
                        <div class="col-md-6 col-lg-4">
                            <a class="related_files--file-link font__subtitle--16-2 font__color--default d-flex align-items-center"
                               href="<?php echo esc_url(get_field('rest__file', $material_id)); ?>"
                               download><?php echo get_the_title($material_id); ?></a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <hr>
            </div>
    </section>
<?php endif; ?>