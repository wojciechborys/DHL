<?php

/**
 * Template name: Elastyczny layout
 */

?>

<?php while (have_posts()) : the_post(); ?>
	<div class="header_clearfix pb-5 mb-sm-1"></div>
	<section class="blog_category mb-0 mt-5">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 mx-auto">
					<h1 class="font__title--022 font__color--gray text-uppercase text-center d-block mb-3"><?php the_title(); ?></h1>
				</div>
			</div>
		</div>
	</section>
	<div class="article article--page pt-3">
		<div class="container-fluid p-0">
			<?php if (have_rows('landing_layouts')): ?>
				<?php while (have_rows('landing_layouts')) : the_row(); ?>
					<?php include(sprintf('%s/templates/reusable/layouts/section_%s.php', get_template_directory(), get_row_layout())); ?>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
	</div>
	<?php get_template_part('templates/knowledge/prefooter'); ?>
<?php endwhile; ?>
