<?php

use Roots\Sage\Assets;
use MintMedia\PolylangT9n\Polylang;

$dh_express_ID = get_the_ID();
?>

<div class="container-fluid py-5" style="background-image:url('<?php echo (get_field("header__image", $dh_express_ID))['url'] ?>');">
    <div class="row">
        <div class="col-12">
            <h3>
                <?php echo get_field('header__title', $dh_express_ID) ?>
            </h3>
            <p> <?php echo get_field('header__desc', $dh_express_ID) ?></p>
        </div>
    </div>
</div>
