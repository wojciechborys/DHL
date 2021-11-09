<?php
$testimonial = get_field('testimonial_slider', $post->ID);
?>
<div class="container" id="<?php echo str_replace(' ', '-',$testimonial['id']); ?>">
    <div class="row">
        <div class="col-12">
            <div class="testimonial-slider mb-0">
                <?php foreach ($testimonial['slide'] as $slide): ?>
                    <div class="container-fluid">
                        <div class="row testimonial-slide">
                            <div class="col-12 col-md-6 d-flex justify-content-center align-items-center testimonial-slide__left">
                                <img class="mw-100" src="<?php echo $slide['logo']['url']; ?>"
                                     alt="<?php echo $slide['logo']['alt']; ?>">
                            </div>
                            <div class="col-12 col-md-6 col-lg-5 offset-lg-1 testimonial-slide__right">
                                <h2 class="testimonial-slide__title">
                                    <?php echo $slide['title']; ?>
                                </h2>
                                <div class="testimonial-slide__desc">
                                    <?php echo $slide['desc']; ?>
                                </div>
                                <div class="testimonial-slide__dots-container"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>