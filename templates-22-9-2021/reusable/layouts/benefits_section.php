<?php if (get_row_layout() == 'benefits_section'):
    $title = get_sub_field('title');
    $benefits = get_sub_field('benefits');
    $text = get_sub_field('text');
    $image = get_sub_field('image');
    $ID = get_sub_field('id');
    ?>
    <section id="<?php echo $id; ?>" class="<?php echo get_row_layout() ?>">
        <div class="container-fluid position-relative px-0">
            <div class="row">
                <div class="col-md-8 benefits-img">
                    <?php if ($image) : ?>
                        <img class="img-fluid" src="<?php echo $image['url'] ?>" alt="<?php echo $image['alt'] ?>">
                    <?php endif; ?>
                </div>
                <div class="benefits">
                    <h4 class="font__title--022 font__color--gray text-uppercase pt-3 pt-lg-0 d-block mb-4"><?php echo $title ?></h4>
                    <p class="font__subtitle--0222 mb-5 pb-3 benefits__subtitle color-gray2"><?php echo $text; ?></p>
                    <div class="d-flex flex-wrap">
                        <?php
                        $i=0;
                        foreach ($benefits as $key => $benefit):
                            ?>
                            <div class="benefit-item col-lg-5 mr-0 px-0 mb-4 mb-lg-5 mr-lg-5  <?php echo $i%2 != 0 ? 'pl-lg-5' : 'pr-lg-5' ?>">
                                <img class="benefit-item__img mb-3" src="<?php echo $benefit['icon']['url']; ?>"
                                     alt="<?php echo $benefit['icon']['alt'] ?>">

                                <h4 class="benefit-item__title mb-2 font__title--055 font__color--red">
                                    <?php echo $benefit['title']; ?>
                                </h4>
                                <p class="font__subtitle--0222 benefit-item__text">
                                    <?php echo $benefit['text']; ?>
                                </p>
                            </div>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>