<?php

use Roots\Sage\Assets;

?>

<?php if (get_row_layout() == 'section_6'):
    $title = get_sub_field('section_6_title');
    $rows = get_sub_field('section_6_row');
    $miscText = get_sub_field('section_6_misc_text');
    $leftTitle = get_sub_field('section_6_table_header_left');
    $rightTitle = get_sub_field('section_6_table_header_right');
    ?>

    <section class="<?php echo get_row_layout() ?>">
        <div class="container-taxes-small px-xl-0">
            <div class="table-header"><?php echo $title ?></div>
            <table class="table striped table-bordered border-top-0">
                <thead>
                <tr>
                    <th scope="col" class="border-top-0"><img
                                src="<?= esc_url(Assets\asset_path('images/taxes-page/close-icon.png', 'asset-sources/dhlknowledge/dist')); ?>"
                                alt="close"
                                class="mr-2"><?php echo $leftTitle ?>
                    </th>
                    <th scope="col" class="border-top-0"><img
                                src="<?= esc_url(Assets\asset_path('images/taxes-page/ok-icon.png', 'asset-sources/dhlknowledge/dist')); ?>"
                                alt="close"
                                class="mr-2"><?php echo $rightTitle ?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($rows as &$row) { ?>
                    <tr>
                        <td><?php echo $row['section_6_list_unacceptable_item'] ?></td>
                        <td><?php echo $row['section_6_list_acceptable_item'] ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="misc-text"><?php echo $miscText ?></div>
        </div>
    </section>

<?php endif; ?>
