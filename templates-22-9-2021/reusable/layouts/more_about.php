<?php if (get_row_layout() == 'more_about'):
    $title = get_sub_field('more_about_title');
    $description = get_sub_field('more_about_description');
    $linkButton = get_sub_field('more_about_button');
    $backgroundColor = get_sub_field('more_about_background_color');
    $image = get_sub_field('more_about_background_image');
    if ($image) {
        $image = $image['url'];
        $style = 'background: linear-gradient(to right, rgba(255,255,255,0.5), rgba(255,255,255,0.55)),url(' . $image . '); 
                 -webkit-background-size: cover;
                 -moz-background-size: cover;
                 -o-background-size: cover;
                 background-size: cover;
             ';
    } else {
        $style = 'background: ' . $backgroundColor;
    }
    ?>

    <section class="<?php echo get_row_layout() ?>" style="<?php echo $style ?>">
        <div class="container">
            <div class="section_cta">
                <h2 class="section_cta--title"><?php echo $title ?></h2>
                <div class="section_cta--subtitle"><?php echo $description ?></div>
                <div class="section_cta--btn">
                    <a href="<?php echo $linkButton; ?>"
                       class="btn btn--auto btn--red btn-primary btn--calc text-uppercase btn--express"
                       style="margin-bottom: 40px"
                       target="">
                        Dowiedz sie wiecej
                    </a>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>
