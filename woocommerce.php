<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package pixafy
 */

get_header(); ?>

<div class="post-wrapper hero-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8">

				<div id="primary" class="content-area">

						<?php while ( have_posts() ) : the_post(); ?>

							<?php woocommerce_content(); ?>

							<?php
								// If comments are open or we have at least one comment, load up the comment template
								if ( comments_open() || get_comments_number() ) :
									comments_template();
								endif;
							?>

						<?php endwhile; // end of the loop. ?>
				</div><!-- #primary -->

			</div><!-- col-md-8 -->

			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div><!-- col-md-4 -->

		</div><!-- row -->
	</div><!-- container -->
</div><!-- post-wrapper -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
