<?php

use Roots\Sage\Assets;

?>

<?php if (get_row_layout() == 'section_10'):
    $title = get_sub_field('section_10_title');
    $leftTextList = get_sub_field('section_10_left_text');
    $rightList = get_sub_field('section_10_right_list');
    $image = get_sub_field('section_10_image');
    $file = get_sub_field('section_10_pdf');
    $fileData = $file['section_10_pdf_file'];
    $fileImage = $file['section_10_pdf_image'];
    $miscText = get_sub_field('section_10_misc_text');
    $filesize = round($fileData['filesize'] / (1024 * 1024), 2, PHP_ROUND_HALF_UP);
    $pdfText = get_sub_field('section_10_pdf_text');
    $downloadText = get_sub_field('section_10_pdf_text_download');
    ?>
    <section class="section_10">
        <div class="container-taxes-small">
            <div class="title section_10__title"><?php the_sub_field('section_10_title'); ?></div>
            <div class="row pt-3 mb-4 mb-md-0 pb-3 pb-md-0 justify-content-center">
                <div class="col-md-6 section_10__left">
                    <div class="section_10__left-title pb-4">
                        <?php the_sub_field('section_10_left_list_title'); ?>
                    </div>
                    <ul class="taxes-page__list marker-ok">
                        <?php
                        if (have_rows('section_10_left_list')):
                            while (have_rows('section_10_left_list')) : the_row();
                                $text = get_sub_field('section_10_left_list_item')
                                ?>
                                <li class="taxes-page__list__item"><?php echo $text ?></li>
                            <?php
                            endwhile;
                        endif; ?>
                    </ul>
                    <ul class="taxes-page__list list">
                        <?php
                        if (have_rows('section_10_left_text')):
                            while (have_rows('section_10_left_text')) : the_row();
                                $text = get_sub_field('section_10_left_text_item')
                                ?>
                                <li class="taxes-page__list__item list-style-none"><?php echo $text ?></li>
                            <?php
                            endwhile;
                        endif; ?>
                    </ul>
                    <div class="text-center mt-5">
                        <img class="" src="<?php echo $image['url']; ?>" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="section_10__right-title font-weight-bold mb-4 d-md-none">
                        <?php the_sub_field('section_10_right_list_title'); ?>
                    </div>
                    <div class="section_10__right-wrapper">
                        <div class="section_10__right-title font-weight-bold mb-4 d-none d-md-block">
                            <?php the_sub_field('section_10_right_list_title'); ?>
                        </div>
                        <div class="section_10__right-text">
                            <?php
                            foreach ($rightList as &$item) { ?>
                                <p class="mb-0 font-weight-bold"><?php echo $item['section_10_right_list_item_title'] ?></p>
                                <p class=""><?php echo $item['section_10_right_list_item_text'] ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section_10__file">
                <div class="text-center mb-4 mb-md-4 d-none d-md-block"><?php echo $pdfText ?></div>
                <div class="d-flex justify-content-center">
                    <div class="taxes-file border">
                        <img src="<?php echo $fileImage['url'] ?>" alt="" class="taxes-file__image">
                        <div class="taxes-file__content d-flex">
                            <img src="<?= esc_url(Assets\asset_path('images/taxes-page/file-icon.png', 'asset-sources/dhlknowledge/dist')); ?>"
                                 alt="">
                            <div>
                                <div class="font-weight-bold">
                                    <?php echo $fileData['title'] ?>
                                </div>
                                <p class="mb-0"><span
                                            class="text-uppercase mr-1"><?php echo $fileData['subtype'] ?></span>(<?php echo $filesize ?>
                                    MB)</p>
                                <a href="<?php echo $fileData['url'] ?>"
                                   class="taxes-file__content__download font-weight-bold"><u><?php echo $downloadText ?></u></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-taxes border-bottom">
            <div class="section_10__misc">
                <?php echo $miscText ?>
            </div>
        </div>
    </section>
<?php endif; ?>



