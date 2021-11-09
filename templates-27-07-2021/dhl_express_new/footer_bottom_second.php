<?php
$nav = wp_get_nav_menu_object('Footer bottom second new dhlexpress');
?>
<footer class="container">
    <div class="row">
        <div class="col-6">
            <img src="<?php echo (get_field('footer_logo', $nav))['url']; ?>"
                 alt="<?php echo (get_field('footer_logo', $nav))['alt']; ?>">
        </div>
        <div class="col-6">
            <?php
            $nav2 = wp_get_nav_menu_items($nav->term_id);
           // var_dump($nav2);
            foreach( $nav2 as $item ){
                var_dump($item->url);
            }
            wp_nav_menu(array('theme_location' => 'footer_nav_new_second')); ?>
        </div>
    </div>
</footer>
