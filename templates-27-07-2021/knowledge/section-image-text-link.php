<section>
    <div class="container mt-5 mb-5">
        <div class="row pt-md-5 pb-md-5 align-items-end">
            <?php
            $link = get_field('link__section');
            if ($link): ?>
            <div class="col-md-6 pr-lg-4 pb-5 pt-4">
                <div class="row align-items-end pt-5 pb-5">
                    <div class="col-md-12 col-lg-12 col-xl-6 text-center text-xl-left">
                        <img class="img-fluid" src="<?php echo esc_url($link['image']['url']); ?>"
                             alt="<?php echo esc_attr($link['image']['alt']); ?>">
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-6 text-center text-xl-left mt-4 mt-lg-0 mb-xl-2">
                        <span class="font__title--055 font__color--red d-block mb-3 mt-3"><?php echo $link['title']; ?></span>
                        <span class="d-block mb-2 mt-3 mt-md-1 font__subtitle--0222"><?php echo $link['description']; ?></span>
                        <?php
                        $button = $link['button'];
                        if ($button): ?>
                            <?php $link_url = $button['url'];
                            $link_title = $button['title'];
                            $link_target = $button['target'] ? $button['target'] : '_self';
                            ?>
                            <a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase mt-3 mt-md-5 mt-lg-2 mt-xl-5"
                                   href="<?php echo esc_url($link_url); ?>"
                                   target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php
            $link = get_field('link__2_section');
            if ($link): ?>
            <div class="col-md-6 pl-lg-4 pb-5 pt-4 el__border-left-2">
                <div class="row align-items-end pt-5 pb-5">
                    <div class="col-md-12 col-lg-12 col-xl-6 text-center text-xl-left">
                        <img class="img-fluid" src="<?php echo esc_url($link['image']['url']); ?>"
                             alt="<?php echo esc_attr($link['image']['alt']); ?>">
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-6 text-center text-xl-left mt-4 mt-lg-0 mb-xl-2">
                        <span class="font__title--055 font__color--red d-block mb-3 mt-3"><?php echo $link['title']; ?></span>
                        <span class="d-block mb-4 pb-2 mt-3 mt-md-1 font__subtitle--0222"><?php echo $link['description']; ?></span>
                        <?php
                        $button = $link['button'];
                        if ($button): ?>
                            <?php $link_url = $button['url'];
                            $link_title = $button['title'];
                            $link_target = $button['target'] ? $button['target'] : '_self';
                            ?>
                            <a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase mt-3 mt-md-5 mt-lg-3 mt-xl-5"
                                   href="<?php echo esc_url($link_url); ?>"
                                   target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>