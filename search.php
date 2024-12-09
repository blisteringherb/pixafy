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
?>

<div class="pix-mast_section">

	<?php
		// @admin_acf_plugin: Page – Banner and Copy Module
		// 
		$taxonomyData = get_the_category();
		$termId = $taxonomyData[0]->term_id;
		$fieldOption = 'category_' . $termId;

		if (get_field('enable_banner_module', $fieldOption)):
			$copyPosition = 'pix-copy_left_aligned';
			
			if (get_field('banner_copy_position', $fieldOption) === 'center'){
				$copyPosition = 'pix-copy_center_aligned';
			} elseif (get_field('banner_copy_position', $fieldOption) === 'right'){
				$copyPosition = 'pix-copy_right_aligned';
			}
	?>
		<section id="pix-banner_module_section" class="pix-banner_module_section hero-section parallax-section-1" style="background-image:url(<?php echo get_field('banner_image', $fieldOption); ?>);">
			<div class="featured-text pix-banner_module_wrapper">
				<!--<img class="pix-banner_module_image" src="<?php //echo get_field('banner_image'); ?>" title="<?php ?>" alt="<?php  ?>" />-->
				<h1 class="pix-banner_module_header <?php echo $copyPosition; ?>">
					<?php echo get_field('banner_copy', $fieldOption); ?>
				</h1>
			</div>
		</section>
	<?php endif; ?>

	<section class="pix-container two-column_layout playbook-category">
		<div class="row">
			<div class="col-md-8 pix-col_content_wrapper">

				<div id="primary" class="content-area">
					<div class="pix-category_breadcrumbs">
						<?php pixafy_the_breadcrumb(); ?>
					</div>

					<main id="main" class="site-main pix-category_main_wrapper" role="main">

					<?php 
						$args = array(
                            'post_type' => 'post',
                            's' => (isset($_GET['_sf_s'])? $_GET['_sf_s']:''),
                            'category_name'=>(isset($_GET['_sft_category'])? $_GET['_sft_category']:''),
                            'tag' =>(isset($_GET['_sft_post_tag'])? $_GET['_sft_post_tag']:'')
                        );
						$postLoop = new WP_Query($args);

						if ( $postLoop->have_posts() ) : 
					?>
						
						<div class="pix-category_article_grid">

							<?php 

								$counter = 1;
								while ( $postLoop->have_posts() ) : $postLoop->the_post();

									$alternateClass = ($counter % 3) ? '' : 'third-article'; 
							?>

								<div class="pix-playbook_article_wrapper <?php echo $alternateClass; ?>">
									<?php
										get_template_part( 'content', 'playbook-article' );
									?>
								</div>

							<?php 
									$counter++;
								endwhile;
							?>

							<div class="pix-clearfix"></div>
						</div>

						<?php //the_posts_navigation(); ?>

						<nav class="navigation posts-navigation" role="navigation">
							<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'pixafy' ); ?></h2>
							<div class="nav-links">
								<span class="nav-previous">
	                                <?php previous_post_link('%link'); ?>
	                            </span> <span class="nav-next">
	                                <?php next_post_link('%link'); ?>
	                            </span>
							</div>
						</nav>

					<?php else : ?>

						<?php get_template_part( 'content', 'category-article-none' ); ?>

					<?php endif; ?>

					</main>
				</div>

			</div>

			<aside class="col-md-4 pix-col_aside_wrapper">
				<?php echo do_shortcode('[searchandfilter slug="playbook-search"]'); ?>
				<?php //get_sidebar('social-media'); ?>
			</aside>

		</div>
	</section>
	
</div>

<?php
	get_footer();
?>
