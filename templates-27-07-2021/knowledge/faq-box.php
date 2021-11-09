<?php

//the_post();

?>
<div class="card">
    <div class="card-header" id="heading<?php echo get_the_ID(); ?>">
        <h2 class="mb-0">
            <button class="card-header--btn btn btn-link d-block font__title--06 text-uppercase font__color--red collapsed"
                    type="button" data-toggle="collapse"
                    data-target="#c<?php echo get_the_ID(); ?>" aria-expanded="false"
                    aria-controls="c<?php echo get_the_ID(); ?>">
                <?php the_title() ?>
            </button>
        </h2>
    </div>
    <div id="c<?php echo get_the_ID(); ?>" class="collapse show"
         aria-labelledby="heading<?php echo get_the_ID(); ?>" data-parent="#accordion">
        <div class="card-body font__subtitle--0222">
            <p><?php  echo get_the_content(); ?></p>
        </div>
    </div>
</div>