<?php
/**
 * The template for displaying all single posts.
 *
 * @package pixafy
 */

	if(!is_user_logged_in()){
        header('Location: /login');
        exit();
    }
    $user = wp_get_current_user();
	$allowed_roles = array('register_complete_and_paid', 'administrator');

	if( !array_intersect($allowed_roles, $user->roles ) ) {
		header('Location: /login');
        exit();
	}


	// show/hide breadcrumbs for this template
	$displayBreadcrumbs = 'pix-display_wp_breadcrumbs';
	if (!get_field('display_wp_breadcrumbs')){
		$displayBreadcrumbs = 'pix-hide_wp_breadcrumbs';
	}

get_header(); ?>


<div class="pix-mast_section pix-single_topic_wrapper">

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

	<section class="pix-container">
		<div class="row">

			<div class="pix-fullwidth_wrapper">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'single' ); ?>

						<?php //the_post_navigation(); ?>
						<div class="clear"></div>

						<?php /*
						<nav class="navigation posts-navigation pix-topic_navigation" role="navigation">

							<div class="nav-links">
								<span class="nav-previous pix-topic_navigation_previous">
	                                <?php previous_post_link('%link'); ?>
	                            </span>
	                            <span class="nav-next pix-topic_navigation_next">
	                                <?php next_post_link('%link'); ?>
	                            </span>
							</div>
						</nav>
						*/?>

						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						?>

					<?php endwhile; // end of the loop. ?>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div>

		</div><!-- row -->
	</section><!-- container -->

</div>

<?php get_footer(); ?>
