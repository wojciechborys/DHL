<?php wp_tag_cloud( array(
   'smallest' => 10,
   'largest'  => 22,
   'unit'     => 'px',
   'number'   => 15,
   'orderby'  => 'name',
   'order'    => 'ASC',
   'taxonomy' => 'post_tag'
) );

dynamic_sidebar('sidebar-front');

dynamic_sidebar('sidebar-banner');