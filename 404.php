<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package pixafy
 */

get_header(); ?>

<div class="pix-section">
	<div class="pix-container">
		<div class="row">
			<div class="pix-404_wrapper">

				<div id="primary" class="content-area">
					<?php // pixafy_the_breadcrumb(); ?>
					<main id="main" class="site-main" role="main">

						<section class="error-404 not-found">
							<div class="pix-404_col_wrapper left">
								<header class="page-header pix-page_header">
									<h1 class="page-title"><?php _e("We couldn't find that page.", 'pixafy'); ?></h1>
								</header>

								<div class="page-content">
									<p>Here are some helpful links instead:</p>
									<ul>
										<li><a href="<?php get_site_url();?>/about">About</a></li>
										<li><a href="<?php get_site_url();?>/framework">Framework</a></li>
										<li><a href="<?php get_site_url();?>/register">Register</a></li>
										<li><a href="<?php get_site_url();?>/contact-us">Contact Us</a></li>
									</ul>

									<?php // get_search_form(); ?>

									<?php //the_widget( 'WP_Widget_Recent_Posts' ); ?>

									<?php /* if ( pixafy_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
									<div class="widget widget_categories">
										<h2 class="widget-title"><?php _e( 'Most Used Categories', 'pixafy' ); ?></h2>
										<ul>
										<?php
											wp_list_categories( array(
												'orderby'    => 'count',
												'order'      => 'DESC',
												'show_count' => 1,
												'title_li'   => '',
												'number'     => 10,
											) );
										?>
										</ul>
									</div><!-- .widget -->
									<?php endif;*/ ?>

									<?php
										/* translators: %1$s: smiley */
										/*
										$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'pixafy' ), convert_smilies( ':)' ) ) . '</p>';
										the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
										*/
									?>

									<?php// the_widget( 'WP_Widget_Tag_Cloud' ); ?>

								</div>
							</div>
							<div class="pix-404_col_wrapper right">
								<?php get_sidebar('404-image'); ?>
							</div>
							<div class="pix-clearfix"></div>
						</section>

					</main>
				</div>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
