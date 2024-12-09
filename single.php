<?php
/**
 * The template for displaying all single posts.
 *
 * @package pixafy
 */

get_header(); ?>

<div class="post-wrapper hero-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'content', 'single' ); ?>

						<?php //the_post_navigation(); ?>
						<div class="clear"></div>

						<nav class="navigation posts-navigation" role="navigation">
							<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'pixafy' ); ?></h2>
							<div class="nav-links">
								<span class="nav-previous">
	                                <?php previous_post_link('%link'); ?>
	                            </span> <span class="nav-next">
	                                <?php next_post_link('%link'); ?>
	                            </span>
							</div><!-- .nav-links -->
						</nav><!-- .navigation -->            

						<?php
							// If comments are open or we have at least one comment, load up the comment template
							if ( comments_open() || get_comments_number() ) :
								comments_template();
							endif;
						?>

					<?php endwhile; // end of the loop. ?>

					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- col-md-8 -->

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div><!-- col-md-4 -->

		</div><!-- row -->
	</div><!-- container -->
</div><!-- post-wrapper -->
<?php get_footer(); ?>
