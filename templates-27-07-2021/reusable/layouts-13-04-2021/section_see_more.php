<section class="see-more">
	<div class="container my-2">
		<div class="row py-md-2 align-items-end">
			<?php
			if (have_rows('see_more_sections')):
				$i = 1;
				while (have_rows('see_more_sections')) : the_row(); ?>
					<div class="col-md-6 pr-lg-4 pb-5 pt-4 <?php if ($i % 2 === 0): ?>el__border-left-2<?php endif; ?>">
						<div class="row align-items-end pt-5 pb-5">
							<div class="col-md-12 col-lg-12 col-xl-6 text-center text-xl-left">
								<?php $img = get_sub_field('section_image'); ?>
								<img class="img-fluid mb-0 mt-0" src="<?php echo $img['url']; ?>"
									 alt="<?php echo $img['alt']; ?>">
							</div>
							<div class="col-md-12 col-lg-12 col-xl-6 text-center text-xl-left mt-4 mt-lg-0 mb-xl-2">
								<div>
									<span class="font__title--055 font__color--red d-block mb-3 mt-3 text-uppercase">
										<?php the_sub_field('section_heading'); ?>
									</span>
									<span
										class="d-block mb-2 mt-3 mt-md-1 font__subtitle--0222"><?php the_sub_field('section_text'); ?>
									</span>
								</div>
								<div>
									<?php $url = get_sub_field('section_cta'); ?>
									<a class="btn btn--auto btn--red btn-primary btn--calc text-uppercase mt-3 mt-md-5 mt-lg-2 mt-xl-5"
									   href="<?php echo $url['url']; ?>" target="_self">
										<?php echo $url['title']; ?>
									</a>
								</div>
							</div>
						</div>
					</div>
				<?php $i++; endwhile;
			endif;
			?>
		</div>
	</div>
</section>
