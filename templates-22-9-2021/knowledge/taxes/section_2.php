<?php if (get_row_layout() == 'section_2'):
    $imageUrl = get_sub_field('section_2_image')['url'];
    $title = get_sub_field('section_2_title');
    $subtext = get_sub_field('section_2_subtext');
    $titleList = get_sub_field('section_2_subtitle');
    $list = get_sub_field('section_2_list');
    ?>

    <section class="<?php echo get_row_layout() ?>">
        <div class="container-taxes">
            <div class="row">
                <div class="col-md-6 text-center">
                    <img src="<?php echo $imageUrl ?>" class="section_2__image-left">
                </div>
                <div class="col-md-6">
                    <h2 class="title"><?php echo $title ?></h2>
                    <p class="subtitle mb-4"><?php echo $subtext ?></p>
                    <p class="titleList"><?php echo $titleList ?></p>

                    <?php
                    foreach ($list as &$item) { ?>
                        <ul class="taxes-page__list">
                            <li class="taxes-page__list__item"><?php echo $item['section_2_list_item'] ?></li>
                        </ul>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
