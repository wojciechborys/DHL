<?php if (get_field('prefooter__enable', get_the_ID())) :
    $prefooter_bg_link = (get_field('prefooter_bg'))['url'];
    $button_link = get_field('prefooter_button', get_the_ID());
    $prefooter_button_title = $button_link['title'];
    $prefooter_button_link = $button_link['url'];
    $prefooter_button_target = $button_link['target'] ? $button_link['target'] : '_self';
    ?>
    <div class="container-fluid" style="background-image: url('<?php echo $prefooter_bg_link ?>')">
        <div class="row">
            <div class="col-12">
                <h4><?php echo get_field('prefooter_title', get_the_ID()); ?></h4>
                <p>
                    <?php echo get_field('prefooter_desc', get_the_ID()); ?>
                </p>
                <a href="<?php echo $prefooter_button_link; ?>"
                   target="<?php echo $prefooter_button_target; ?>"><?php echo $prefooter_button_title; ?></a>
            </div>
        </div>
    </div>
<?php endif; ?>
