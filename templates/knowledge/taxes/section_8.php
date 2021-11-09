<?php

use Roots\Sage\Assets;

?>

<?php if (get_row_layout() == 'section_8'):
    $title = get_sub_field('section_8_title');
    $subtitle = get_sub_field('section_8_subtext');
    $rows = get_sub_field('section_8_row');
    $file = get_sub_field('section_8_pdf');
    $fileData = $file['section_8_pdf_file'];
    $fileImage = $file['section_8_pdf_image'];
    $filesize = round($fileData['filesize'] / (1024 * 1024), 2, PHP_ROUND_HALF_UP);
    $tableHead1 = get_sub_field('section_8_table_head_1');
    $tableHead2 = get_sub_field('section_8_table_head_2');
    $tableHead3 = get_sub_field('section_8_table_head_3');
    $downloadText = get_sub_field('section_8_table_download');
    ?>

    <section class="<?php echo get_row_layout() ?>">
        <div class="container-taxes-small">
            <div class="title text-center"><?php echo $title ?></div>
            <div class="subtitle text-center"><?php echo $subtitle ?></div>
            <div class="table--radius">
                <table class="table table-bordered border-top-0 border-left-0 border-right-0">
                    <thead>
                    <tr>
                        <th scope="col"></th>
                        <th scope="col"><?php echo $tableHead1 ?></th>
                        <th scope="col"><?php echo $tableHead2 ?></th>
                        <th scope="col"><?php echo $tableHead3 ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $j = 1;
                    foreach ($rows as &$row) { ?>
                        <tr class="<?php if ($j % 2 === 0) echo "striped" ?>">
                            <td rowspan="<?php echo count($row['section_8_table_rows']) ?>"
                                class="position-relative bg-white">
                                <div class="number-col"><?php echo $j ?></div>
                            </td>
                            <td><b><?php echo $row['section_8_table_rows'][0]['section_8_row_element_category'] ?></td>
                            <td><?php echo $row['section_8_table_rows'][0]['section_8_row_example'] ?></td>
                            <td rowspan="<?php echo count($row['section_8_table_rows']) ?>">
                                <?php echo $row['section_8_table_rows_important'] ?>
                            </td>
                        </tr>
                        <?php if (count($row['section_8_table_rows']) > 1) { ?>
                            <?php for ($i = 1; $i < count($row['section_8_table_rows']); $i++) { ?>
                                <tr class="<?php if ($j % 2 === 0) echo "striped" ?>">
                                    <td><b><?php echo $row['section_8_table_rows'][$i]['section_8_row_element_category'] ?></b></td>
                                    <td><?php echo $row['section_8_table_rows'][$i]['section_8_row_example'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        <?php
                        $j++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
                <div class="taxes-file border">
                    <img src="<?php echo $fileImage['url'] ?>" alt="" class="taxes-file__image">
                    <div class="taxes-file__content d-flex">
                        <img src="<?= esc_url(Assets\asset_path('images/taxes-page/file-icon.png', 'asset-sources/dhlknowledge/dist')); ?>"
                             alt="">
                        <div>
                            <div class="font-weight-bold mb-3 mb-sm-0">
                                <?php echo $fileData['title'] ?>
                            </div>
                            <p class="mb-0 d-none d-sm-block"><span
                                        class="text-uppercase mr-1"><?php echo $fileData['subtype'] ?></span>(<?php echo $filesize ?>
                                MB)</p>
                            <a href="<?php echo $fileData['url'] ?>"
                               class="taxes-file__content__download font-weight-bold"><u><?php echo $downloadText ?></u></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
