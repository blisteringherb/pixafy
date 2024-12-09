<?php
/*
  Template Name: School Testimonials Page
 */
?>

<?php
	// Begin template rendering
	// 
	// school_testimonial_feature_image
	// school_testimonial_title
	// school_testimonial_blurb
	// school_testimonial_excerpt_length
	get_header();
?>

<div class="pix-mast_section">

	<?php
		// @admin_acf_plugin: School Testimonials - Testimonial Video and Copy Module
		if (get_field('enable_school_testimonial_video_and_copy_module')):
	?>
		<section id="pix-school_testimonials_video_module_section" class="pix-school_testimonials_video_module_section">
			<div class="pix-school_testimonials_video_wrapper">
				<div class="pix-school_testimonials_video_half_col video_left_col">
					<div class="pix-school_testimonial"><?php echo get_field('school_testimonial_video_blurb'); ?></div>
				</div>
				<div class="pix-school_testimonials_video_half_col video_right_col">
					<?php if(get_field('is_image_url')) :?>
						<img src="<?php echo get_field('school_testimonial_video_embed_url'); ?>" alt="" title="" />
					<?php else :?>
						<iframe src="<?php echo get_field('school_testimonial_video_embed_url'); ?>?html5=1&output=embed" frameborder="0" allowfullscreen></iframe>
					<?php endif; ?>
				</div>
				<div class="pix-school_testimonials_video_half_col mobile_content">
					<div class="pix-school_testimonial"><?php echo get_field('school_testimonial_video_blurb'); ?></div>
				</div>
				<div class="pix-clearfix"></div>
			</div>
		</section>
	<?php endif; ?>

	<section class="pix-container">
		<div class="row">
			<div class="pix-register-wrapper">
				<div id="primary" class="content-area">
					<main id="main" class="site-main pix-hide_wp_breadcrumbs" role="main">
							<?php
								the_post();

								get_template_part( 'content', 'page' );
							?>
					</main>
				</div>
			</div>
		</div>
	</section>

	<?php 
		// @admin_acf_plugin: School Testimonials - Testimonial Listing
		if (get_field('enable_school_testimonials_module')):
	?>
		<section id="pix-school_testimonials_module_section" class="pix-school_testimonials_module_section">
			<div class="pix-school_testimonials_wrapper">
				<ul class="pix-school_listing_items">
					<?php
						$counter = 1;
				
						if(have_rows('school_testimonial_collection')):
							while (have_rows('school_testimonial_collection')):
								the_row();
					?>
							<li class="pix-school_testimonial_item">
								<div class="pix-school_testimonial_item_wrapper">
									<?php 
										$isImageActive = get_sub_field('school_testimonial_feature_image');
										if ( !empty($isImageActive) ): ?>
										<div class="pix-school_image_wrapper">
											<img src="<?php echo the_sub_field('school_testimonial_feature_image'); ?>" alt="" title="" />
										</div>
										<h3 class="pix-school_testimonial_title"><?php echo the_sub_field('school_testimonial_title'); ?></h3>
										<div class="pix-school_testimonial_blurb excerpt">
											<?php 
												$blurb = get_sub_field('school_testimonial_blurb');
												$wordCount = get_sub_field('school_testimonial_excerpt_length'); 
												$excerpt = substr($blurb, 0, $wordCount);

												echo $excerpt . '...'; 
											?>
										</div>
										<div class="pix-school_testimonial_blurb full_text"><?php echo $blurb?></div>
										<a class="pix-school_testimonial_blurb_toggle"></a>
									<?php else: ?>
										<h3 class="pix-school_testimonial_title no-image-styling">
											<?php 
												$testimonialTitle = get_sub_field('school_testimonial_title'); 
												$firstChar = substr($testimonialTitle, 0, 1);
												$restOfTitle = substr($testimonialTitle, 1);
											?>
											<span><?php echo $firstChar; ?></span><?php echo $restOfTitle; ?>
										</h3>
										<div class="pix-school_testimonial_blurb excerpt">
											<?php 
												$blurb = get_sub_field('school_testimonial_blurb');
												$wordCount = get_sub_field('school_testimonial_excerpt_length'); 
												$excerpt = substr($blurb, 0, $wordCount);

												echo $excerpt . '...'; 
											?>
										</div>
										<div class="pix-school_testimonial_blurb full_text"><?php echo $blurb?></div>
										<a class="pix-school_testimonial_blurb_toggle"></a>
									<?php endif; ?>
								</div>
							</li>
					<?php
								$counter++;
							endwhile;
						endif;
					?>
					<li class="pix-clearfix"></li>
				</ul>
			</div>
		</section>
	<?php endif; ?>

</div>

<?php
	get_footer();
	// End template rendering
?>