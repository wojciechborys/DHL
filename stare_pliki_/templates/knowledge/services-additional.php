<?php

use MintMedia\PolylangT9n\Polylang;

$title = get_field('services_additional__title');
$text = get_field('services_additional__text');
$id = get_field('services_additional__ID');
?>
<section class="services_accordion">
    <div class="container">
        <span id="<?php echo $id; ?>" class="font__title--04 font__color--red text-uppercase d-block text-center text-sm-left mb-3"><?php echo $title; ?></span>
        <span class="font__subtitle--16-2 d-block mb-4 pb-2"><?php echo $text; ?></span>

        <div class="rowfff">
            <?php if (have_rows('services_additional__repeat')):
                $i = 1;
                while (have_rows('services_additional__repeat')) : the_row(); ?>
                    <div class="pt-1">
                        <div class="services_accordion--section-item">
                            <div class="row d-flex align-items-center services_accordion--item-height">
                                <div class="col-12 col-sm-7 text-center text-sm-left">
                                    <span class="font__title--06 font__color--gray"><?php echo get_sub_field('title') ?></span>
                                </div>
                                <div class="col-12 col-sm-5 text-center text-sm-right">
                                    <a data-id="ts<?php echo $i; ?>"
                                        data-text-close="<?= Polylang\t9n('ZAMKNIJ'); ?>"
                                        data-text-open="<?= Polylang\t9n('ZOBACZ WIĘCEJ'); ?>"
                                        href="#" class="show_section d-inline-block font__title--07 font__color-red mt-2 mt-sm-0"><?= Polylang\t9n('ZOBACZ WIĘCEJ'); ?></a>
                                </div>
                            </div>
                        </div>
                        <div id="ts<?php echo $i; ?>" style="display: none;">
                        <?php if (have_rows('accordion')): ?>
                            <?php $j = 1; ?>
                            <?php while (have_rows('accordion')) : the_row(); ?>
                                <div class="services_accordion--item">

                                    <div class="services_accordion--item-height row d-flex align-items-center">
                                        <div class="col-12 col-sm-10 col-md-8 col-lg-4">
                                            <span class="font__subtitle--0002 d-block"><?php echo get_sub_field('text_left') ?></span>
                                            <span class="pl-lg-3 font__subtitle--0002 d-lg-none"><?php echo get_sub_field('text_right') ?></span>
                                        </div>
                                        <div class="col-5 col-lg-5 el__border-left d-none d-lg-flex">
                                            <span class="pl-lg-3 font__subtitle--0002"><?php echo get_sub_field('text_right') ?></span>
                                        </div>
                                        <div class="col-12 col-sm-2 col-md-4 col-lg-3 el__border-left text-center text-sm-right">
                                            <a data-id="sss<?php echo $i.$j; ?>"
                                                data-text-close="<?= Polylang\t9n('ZAMKNIJ'); ?>"
                                                data-text-open="<?= Polylang\t9n('CZYTAJ WIĘCEJ'); ?>"
                                                class="show_section d-inline-block font__title--07 font__color-red mt-2 mt-sm-0" href="#"><?= Polylang\t9n('CZYTAJ WIĘCEJ'); ?></a>
                                        </div>
                                    </div>

                                    <div id="sss<?php echo $i.$j; ?>" class="services_accordion--content" style="display: none;">
                                        <div class="content font__subtitle--16-3">
                                            <?php echo get_sub_field('description') ?>
                                        </div>
                                    </div>
                                </div>
                                <?php $j++; ?>
                            <?php endwhile; ?>

                        <?php endif; ?>
                        </div>
                    </div>
                    <div class="pt-1 pb-5 text-center text-sm-left">
                        <span class="font__title--06 font__color--dark-gray d-block d-sm-inline-block"><?php echo get_sub_field('text_bottom') ?></span>
                        <?php
                        $button = get_sub_field('button');
                        $document = get_sub_field('document');
                        if ( $document ) {
                            $doc_id = $document->ID;
                            echo '<a class="d-inline-block btn--red-mini ml-sm-3 mt-3 mt-sm-0" href="'.esc_url(get_field('rest__file', $doc_id)).'" target="_blank">' . Polylang\t9n('SPRAWDŹ') . '</a>';
                        }
                       /* if ($button):
                            echo '<a class="d-inline-block btn--red-mini ml-sm-3 mt-3 mt-sm-0" href="' . esc_url($button['url']) . '" target="' . $button['target'] . '">' . $button['title'] . '</a>';
                        endif; */
                        ?>
                    </div>
                    <?php $i++; ?>
                <?php endwhile;
            endif; ?>
        </div>
    </div>
</section>