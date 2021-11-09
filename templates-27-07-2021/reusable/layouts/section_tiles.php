<div class="container">
	<section class="services_table mb-4 pb-4">
		<div class="container pb-2">
			<div class="row d-flex justify-content-center">
				<?php if (have_rows('kafel')):
					while (have_rows('kafel')) :
						the_row(); ?>
						<div class="col-12 col-md-6 col-lg-4 mb-5">
							<div
								class="services_table--item services_table--item--bf services_table--item--bf--<?php echo get_row_index(); ?> bg__color--gray-light text-center text-md-left text-center d-flex flex-column bd-highlight">
								<span
									class="services_table--item--bf--title text-uppercase font__title--0555 font__color--default-head text-center"><?php echo get_sub_field('title'); ?></span>
								<p class="font__subtitle--16-2 text-center"><?php echo get_sub_field('text'); ?></p>
								<?php if (get_sub_field('enbale__button')):
									$link = get_sub_field('button');
									if ($link): ?>
										<?php $link_url = $link['url'];
										$link_title     = $link['title'];
										$link_target    = $link['target'] ? $link['target'] : '_self';
										?>
										<p class="text-center">
											<a class="btn--yellow-big d-block mb-4 mt-2"
											   href="<?php echo esc_url($link_url); ?>"
											   target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
										</p>
									<?php endif; ?>
								<?php endif; ?>
								<?php if (get_sub_field('enable__tooltip')): ?>
									<p class="text-center mt-4">
										<img src="<?php echo esc_url((get_sub_field('tooltip__icon'))['url']); ?>"
											 alt="<?php echo (get_sub_field('tooltip__icon'))['alt']; ?>">

										<a href="#" class="infoTooltip" data-toggle="tooltip"
										   title="<?php echo get_sub_field('tooltip__text'); ?>">?</a>

									</p>
								<?php endif; ?>
								<p class="font__subtitle--16-2 text-center"><?php echo get_sub_field('text_bottom'); ?></p>
								<?php $link = get_sub_field('bottom_button');
								if ($link): ?>
									<?php $link_url = $link['url'];
									$link_title     = $link['title'];
									$link_target    = $link['target'] ? $link['target'] : '_self';
									?>
									<div class="text-center">
										<a class="btn btn--auto btn--red btn-primary btn--calc"
										   href="<?php echo esc_url($link_url); ?>"
										   target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
									</div>
								<?php endif; ?>
							</div>
						</div>
					<?php endwhile;
				endif; ?>
			</div>
            <div>
                <?php echo get_field('tiled_2__text'); ?>
            </div>
        </div>
	</section>
</div>
