<?php if (get_row_layout() == 'needs_realized'):
    $title = get_sub_field('needs_title');
    $description = get_sub_field('needs_description');
    $needsImage = get_sub_field('needs_picture');
    $list = get_sub_field('needs_list');
?>

    <section class="section_needs">
        <div class="container content-section">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex align-items-center justify-content-center h-100 section_needs--image" >
                        <img class="img-fluid" src="<?php echo $needsImage['url'] ?>" alt="">
                    </div>

                </div>

                <div class="col-md-9 container-needs">
                        <h2 class="title"><?php echo $title?></h2>

                        <p class="subtitle"><?php echo $description?></p>
                    <ul class="needs-list">
                    <?php
                        foreach ($list as $item) { ?>

                                <li class="needs-list__item"><img src="" alt=""><?php echo $item['need_item'] ?></li>

                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>