<?php

use SD\Restricted;
use MintMedia\PolylangT9n\Polylang;
//the_post();

?>

<div class="file_post--item row">
    <div class="col-sm-9 col-lg-10 font__title--06 text-uppercase font__color--red d-flex align-items-center">
        <?php if (get_field('rest__icon_file')) : ?>
        <span class="file_post--file-ico" style="background-image: url(<?php echo esc_url(get_field('rest__icon_file')); ?>);"><?php the_title() ?></span>
        <?php else : ?>
            <span class="file_post--file-ico"><?php the_title() ?></span>
        <?php endif; ?>
    </div>
    <div class="col-sm-3 col-lg-2 d-flex align-items-center justify-content-sm-end">
        <a href="<?php echo esc_url(get_field('rest__file'));  ?>" download class="btn--yellow font__subtitle--0222 d-block d-sm-inline text-center w-100 mt-3 mt-sm-0"><?= Polylang\t9n('Pobierz'); ?></a>
    </div>
</div>