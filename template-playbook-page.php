<?php
/*
  Template Name: Playbook Topic Page
 */
?>
<?php 
/**
 * @modules: [
 * Page - Banner and Copy, 
 * Page - Breadcrumbs Helper, 
 * Page - Framework of Success, 
 * ]
 * 
 * @pages: [School Listing,]
 *  
 */
?>
<?php
    $restrict_role=array();
    if(get_field( "restrict_role" )!=null && get_field( "restrict_role" )!=''){
        $restrict_role=explode(',',get_field( "restrict_role" ));
    }
    if(!can_user_see_playbook($restrict_role)){
        header('Location: /login');
        exit();
    }

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
	      <p class="pix-content_block"><?php echo $content; ?></p>
	    </article>
	  </section>
	<?php endif; ?>

	<section class="pix-container pix-toolbar_header">
		<div class="pix-breadcrumbs_wrapper">
			<?php pixafy_the_breadcrumb(); ?>
		</div>
	</section>

	<section class="pix-container two-column_layout playbook-category">
		<div class="row">
			<div class="col-md-8 pix-col_content_wrapper">
				<div id="primary" class="content-area">
					<main id="main" class="site-main <?php echo $displayBreadcrumbs; ?>" role="main">
						<?php $slug = ''; ?>
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php get_template_part( 'content', 'page' ); ?>
							<?php $slug = get_post_field( 'post_name', get_post() ); ?>
							<?php endwhile; // end of the loop. ?>
							
						<?php endif; ?>

					</main>
				</div>
			</div>
			<aside class="col-md-4 pix-col_aside_wrapper">
				<script type="text/javascript">
					jQuery(document).on('ready', function(){
						if(!!window.history && !!window.history.replaceState){
							window.history.replaceState(null, null, '?_sft_category=<?php echo $slug; ?>');
						}
					});
				</script>
				<?php echo do_shortcode('[searchandfilter slug="playbook-search"]'); ?>
				<?php //get_sidebar('social-media'); ?>
			</aside>
		</div>
	</section>
</div>

<?php
	get_footer();
	// End Template rendering
?>
