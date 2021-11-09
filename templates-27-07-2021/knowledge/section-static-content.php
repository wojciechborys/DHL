<?php
if(get_field('section_static_display')) :
?>
<div class="container article--page pt-0 pb-5">
    <section class="editor">
        <?php the_field('static_section_text'); ?>
    </section>
</div>
<?php endif; ?>