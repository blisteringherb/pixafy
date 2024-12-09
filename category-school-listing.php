<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pixafy
 */
?>

<?php 

	get_header();

	$taxonomyData = get_category(get_query_var( 'cat' ));
	$termId = $taxonomyData->term_id;
?>
<script>
window.onpopstate = function(event)
{
	window.location.href = document.location;
};
</script>

<div class="pix-mast_section">


	<?php
		// @admin_acf_plugin: Page – Banner and Copy Module
		// 
		
		
		$fieldOption = 'category_' . $termId;

		if (get_field('enable_banner_module', $fieldOption)):
			$copyPosition = 'pix-copy_left_aligned';
			
			if (get_field('banner_copy_position', $fieldOption) === 'center'){
				$copyPosition = 'pix-copy_center_aligned';
			} elseif (get_field('banner_copy_position', $fieldOption) === 'right'){
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
		style="background-image:url(<?php echo get_field('banner_image', $fieldOption); ?>);  <?php echo $isOffsetHor ? $offsetValueHor : '' ?> <?php echo $isOffsetVert ? $offsetValueVert : '' ?>">
			<div class="featured-text pix-banner_module_wrapper">
				<!--<img class="pix-banner_module_image" src="<?php //echo get_field('banner_image'); ?>" title="<?php ?>" alt="<?php  ?>" />-->
				<h1 class="pix-banner_module_header <?php echo $copyPosition; ?>">
					<?php echo get_field('banner_copy', $fieldOption); ?>
				</h1>
			</div>
		</section>
	<?php endif; ?>


	<section class="pix-container">
		<div class="row">

			<div class="pix-category_toolbar">
				<!--<span class="pix-category_toolbar_title">Search by School Name or School Location.</span>-->
				<?php pixafy_the_breadcrumb(); ?>
				<div class="pix-category_toolbar_options_wrapper">
					<?php echo do_shortcode('[searchandfilter slug="school-listing"]'); ?>
				</div>
				<div class="pix-clearfix"></div>
			</div>

			<div id="primary" class="content-area">
				<?php //pixafy_the_breadcrumb(); ?>
				<main id="main" class="site-main" role="main">
						<?php
							$args = array(
                                'post_type' => 'jed_school_member',
                                'orderby' => 'title',
                                'order' => 'ASC',
                                'nopaging' => true,
                                'category_name'=>(isset($_GET['_sft_category'])? $_GET['_sft_category']:''),
                                'tag' =>(isset($_GET['_sft_post_tag'])? $_GET['_sft_post_tag']:'')
                            );
							$postLoop = new WP_Query($args);
							if ( $postLoop->have_posts() ) : 
						?>

						<?php /* Start the Loop */ ?>
						<?php while ( $postLoop->have_posts() ) : $postLoop->the_post(); ?>

							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'content', 'jed_school_member' );
							?>

						<?php endwhile; ?>

						<?php //the_posts_navigation(); ?>
						<div class="clear"></div>

					<?php else : ?>

						<?php get_template_part( 'content', 'jed_school_members_empty' ); ?>

					<?php endif; ?>


				</main>
			</div>

		</div>
	</section>

</div>

<?php
	get_footer();
?>
