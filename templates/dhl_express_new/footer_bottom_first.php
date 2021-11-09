<?php
$nav = wp_get_nav_menu_object('Footer bottom first new dhlexpress');
?>
<footer class="container">
    <div class="row">
        <div class="col-9">
            <?php wp_nav_menu(array('theme_location' => 'footer_nav_new_first')); ?>
        </div>
        <div class="col-3">
            <h3><?php echo get_field('footer_first_title', $nav); ?></h3>
            <?php
            $phone = get_field('footer_first_phone', $nav);
            if ($phone):
                ?>
                <p><?php echo $phone['number']; ?></p>
                <p><?php echo $phone['desc']; ?></p>
            <?php endif; ?>
        </div>
    </div>
</footer>
