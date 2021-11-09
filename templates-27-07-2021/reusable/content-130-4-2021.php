<?php

use Roots\Sage\Assets;
use MintMedia\PolylangT9n\Polylang;

?>

<?php if (have_rows('layouts_reusable')): ?>
    <?php while (have_rows('layouts_reusable')) : the_row(); ?>
        <?php $layout = get_row_layout(); ?>
        <?php get_template_part('templates/reusable/layouts/'.$layout); ?>
    <?php endwhile; ?>
<?php endif; ?>
