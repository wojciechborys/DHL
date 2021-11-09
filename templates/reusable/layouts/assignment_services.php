<?php if (get_row_layout() == 'assignment_services'):
    $title = get_sub_field('assignment_title');
    $list = get_sub_field('assigemen_list');

//    $image = get_sub_field('assignment_image');
    ?>

    <section class="<?php echo get_row_layout()?>">
        <div class="container">
            <div class="assignment_services--title">
                <?php echo $title ?>
            </div>

            <div class="assignment_services--cards row">
                <?php
                foreach ($list as $item) { ?>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-wrapper">
                                    <img class="card-img-top" src="<?php echo $item['assignment_image']['url'] ?>" alt="Card image cap">
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item['assignment_title'] ?></h5>
                                    <?php echo $item['assignment_description']; ?>
                                </div>
                            </div>
                        </div>
                <?php }
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>