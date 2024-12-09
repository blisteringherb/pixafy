<?php
/*
  Template Name: Register Page
 */
?>

<?php
	// Begin template rendering
	get_header();
?>

<div class="pix-mast_section">

	<?php
		// @admin_acf_plugin: Page – Banner and Copy Module
		if (get_field('enable_banner_module')):
			$copyPosition = 'pix-copy_left_aligned';
			
			if (get_field('banner_copy_position') === 'center'){
				$copyPosition = 'pix-copy_center_aligned';
			} elseif (get_field('banner_copy_position') === 'right'){
				$copyPosition = 'pix-copy_right_aligned';
			}

			if (get_field('disable_parallax')){
				$disableParallax = 'no-fixed';
			}

			$isOffsetVert = false;
			if (get_field('vertical_offset_banner_position')) {
			  $isOffsetVert = true;
			  $offsetValueVert = 'background-position-y:' . get_field('vertical_offset_banner_position') . 'px;';
			}
			$isOffsetHor = false;
			if (get_field('horizontal_offset_banner_position')) {
			  $isOffsetHor = true;
			  $offsetValueHor = 'background-position-x:' . get_field('horizontal_offset_banner_position') . 'px;';    
			}
	?>
		<section id="pix-banner_module_section" class="pix-banner_module_section hero-section parallax-section-1<?php echo ' ' . $disableParallax; ?>" 
		style="background-image:url(<?php echo get_field('banner_image'); ?>); <?php echo $isOffsetHor ? $offsetValueHor : '' ?> <?php echo $isOffsetVert ? $offsetValueVert : '' ?>">
			<div class="featured-text pix-banner_module_wrapper">
				<!--<img class="pix-banner_module_image" src="<?php //echo get_field('banner_image'); ?>" title="<?php ?>" alt="<?php  ?>" />-->
				<h1 class="pix-banner_module_header <?php echo $copyPosition; ?>">
					<?php echo get_field('banner_copy'); ?>
				</h1>
			</div>
		</section>
	<?php endif; ?>

	<?php
	  // @admin_acf_plugin: Page – Branded Content Module
	  if (get_field('enable_branded_content_module')):
	    $content = get_field('content');
	?>
	  <section id="pix-branded_content_module_section" class="pix-branded_content_module_section">
	    <article class="pix-article">
	      <div class="pix-content_block"><?php echo $content; ?></div>
	    </article>
	  </section>
	<?php endif; ?>

	
	<?php
		// @admin_acf_plugin: Register Page – Form Breadcrumbs Helper
		if (get_field('enable_form_breadcrumbs_module')):
			$numberOfSteps = count(get_field('register_form_step_collection'));
	?>
	  <section id="pix-form_breadcrumbs_module_section" class="pix-form_breadcrumbs_module_section">
	    <ul class="pix-form_breadcrumbs_list_wrapper pix-<?php echo $numberOfSteps; ?>_step_list">
	    	<?php 
	    		$counter = 1;
	    		if(have_rows('register_form_step_collection')):
					while (have_rows('register_form_step_collection')):
						the_row();

						$isActive = get_sub_field('register_step_is_active') ? ' current_breadcrumb' : '';
						$isLastChild = $counter === $numberOfSteps ? '  last-child' : '';
			?>
	    		<li class="pix-form_breadcrumb_step<?php echo $isActive; echo $isLastChild; ?>" data-form-step="<?php echo the_sub_field('register_step_number'); ?>">
	    			<?php if (!empty(get_sub_field('register_step_url'))) : ?>
	    			<a class="pix-form_breadcrumb_link" href="<?php echo the_sub_field('register_step_url'); ?>" >
	    				<i class="pix-form_breadcrumb_icon <?php echo the_sub_field('register_step_icon'); ?>"></i>
	    				<p class="pix-form_breadcrumb_name"><?php echo the_sub_field('register_step_title'); ?></p>
	    			</a>
	    			<?php else : ?>
	    			<span class="pix-form_breadcrumb_link">
	    				<i class="pix-form_breadcrumb_icon <?php echo the_sub_field('register_step_icon'); ?>"></i>
	    				<p class="pix-form_breadcrumb_name"><?php echo the_sub_field('register_step_title'); ?></p>
	    			</span>
	    			<?php endif; ?>
	    		</li>

	    	<?php
	    				$counter++;
	    			endwhile;
	    		endif;
	    	?>
	    	<div class="pix-clearfix"></div>
	    </ul>
	  </section>
	<?php endif; ?>

	<?php
	  // @admin_acf_plugin: Register Page – Two Column Image and Copy
	  if (get_field('enable_two_column_image_and_copy_module')):
	   
	?>
	<section id="pix-two_column_register_section" class="pix-two_column_register_section">
		<div class="pix-half_wrapper_background"></div>
		<div class="pix-two_column_register_wrapper">
			<div class="pix-half_column_container left">
				<img class="desktop" src="<?php echo get_field('register_left_column_image'); ?>">
				<img class="mobile" src="<?php echo get_field('register_left_column_image_mobile'); ?>">
			</div>
			<article class="pix-half_column_container right">
				<div class="pix-content_block"><?php echo get_field('register_right_column_content'); ?></div>
			</article>
		</div>
	</section>
	<?php endif; ?>

	<section class="pix-container register_wrapper">
		<div class="row">
			<div class="pix-register_wrapper">
				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">
							<?php
								the_post();

								get_template_part( 'content', 'page' );
							?>
					</main>
				</div>
			</div>
		</div>
	</section>

</div>

<?php
	get_footer();
	// End template rendering
?>