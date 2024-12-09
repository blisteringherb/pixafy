<?php
/**
 * The template for displaying all single posts.
 *
 * @package pixafy
 */

// hide default breadcrumbs for this template
$displayBreadcrumbs = 'pix-hide_wp_breadcrumbs';

// Begin Template rendering
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
	?>
		<section id="pix-banner_module_section" class="pix-banner_module_section hero-section parallax-section-1<?php echo ' ' . $disableParallax; ?>" style="background-image:url(<?php echo get_field('banner_image'); ?>);">
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
	      <p class="pix-content_block"><?php echo $content; ?></p>
	    </article>
	  </section>
	<?php endif; ?>

	<section class="pix-container pix-toolbar_header">
		<div class="pix-breadcrumbs_wrapper">
			<?php pixafy_the_breadcrumb(); ?>
		</div>
		<div class="pix-search_module_wrapper">
			<?php echo do_shortcode('[searchandfilter slug="playbook-search-only"]'); ?>
		</div>
	</section>

	<section class="pix-container playbook_detail_layout">
		<div class="row">
			<div class="pix-playbook_about_wrapper">
				<div id="primary" class="content-area">
					<main id="main" class="site-main <?php echo $displayBreadcrumbs; ?>" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php get_template_part( 'content', 'single-detail' ); ?>

							<?php endwhile; // end of the loop. ?>
							
						<?php endif; ?>

					</main>
				</div>
			</div>
		</div>
	</section>
</div>

<?php 
	get_footer();
?>
