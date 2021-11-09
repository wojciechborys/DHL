<?php
use Roots\Sage\Assets;
use SD\Options\OptionsHelper;

$optionsHelper = OptionsHelper::getInstance();
?>
<section class="prizes" id="prizes">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="prizes__title"><?= $optionsHelper->get('prizes::title'); ?></h1>
                <p class="prizes__text"><?= $optionsHelper->get('prizes::text'); ?></p>
            </div>
        </div>

        <div class="prizes__prize-wrapper">

            <div class="prizes__row row justify-content-center">
                <?php
            $prizes = $optionsHelper->get('prizes::prizes');

            foreach ($prizes as $prize) :
                if (!$prize['image']) {
                    continue;
                }

                ?><div class="col-12 col-sm-4 col-md-3 col-lg prizes__col">
					<div class="prizes__prize">
						<img class="prizes__figure img-fluid" src="<?= esc_url($prize['image']); ?>"<?php if ($prize['title']) : ?> alt="<?= esc_attr($prize['title']); ?>" title="<?= esc_attr($prize['title']); ?>"<?php endif; ?> />
					</div>
                </div><?php
            endforeach;
                ?>

            </div>

        </div>
    </div>
</section>
