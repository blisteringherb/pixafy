<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package pixafy
 */

get_header();

?>
<?php
	$discussionDesign = false;
	// check if discussion categorys are being called
	if (get_post_type() == "discussion-topics") {
		$discussionDesign = true;
	}
?>

<?php
	/**
	 * Load template for tags listing
	 */
	if (get_post_type() == 'post') : 
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
						if ( have_posts() ) : 
					?>
						
						<div class="pix-category_article_grid">
								
							<?php 
								$counter = 1;
								while ( have_posts() ) : the_post();
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
	/**
	 * load the default functionality
	 * ToDo: go through all archive template examples
	 */
	else: 
?>


<div class="post-wrapper hero-section<?php echo $discussionDesign ? ' pix-discussion_topic_wrapper' : ''?>">
	<div class="pix-container">
		<div class="row">
			<?php if (!$discussionDesign) :?>
			<div class="col-md-8">
			<?php endif; ?>

				<div id="primary" class="content-area">

					<?php pixafy_the_breadcrumb(); ?>

					<main id="main" class="site-main" role="main">

					<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php if ( is_category() ) {
								$title = sprintf( __( 'Category: %s', 'pixafy' ), single_cat_title( '', false ) );
							} elseif ( is_tag() ) {
								$title = sprintf( __( 'Tag: %s', 'pixafy' ), single_tag_title( '', false ) );
							} elseif ( is_author() ) {
								$title = sprintf( __( 'Author: %s', 'pixafy' ), '<span class="vcard">' . get_the_author() . '</span>' );
							} elseif ( is_year() ) {
								$title = sprintf( __( 'Year: %s', 'pixafy' ), get_the_date( _x( 'Y', 'yearly archives date format', 'pixafy' ) ) );
							} elseif ( is_month() ) {
								$title = sprintf( __( 'Month: %s', 'pixafy' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'pixafy' ) ) );
							} elseif ( is_day() ) {
								$title = sprintf( __( 'Day: %s', 'pixafy' ), get_the_date( _x( 'F j, Y', 'daily archives date format', 'pixafy' ) ) );
							} elseif ( is_tax( 'post_format' ) ) {
								if ( is_tax( 'post_format', 'post-format-aside' ) ) {
									$title = _x( 'Asides', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
									$title = _x( 'Galleries', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
									$title = _x( 'Images', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
									$title = _x( 'Videos', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
									$title = _x( 'Quotes', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
									$title = _x( 'Links', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
									$title = _x( 'Statuses', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
									$title = _x( 'Audio', 'post format archive title', 'pixafy' );
								} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
									$title = _x( 'Chats', 'post format archive title', 'pixafy' );
								}
							} elseif ( is_post_type_archive() ) {
								$title = sprintf( __( 'Archives: %s', 'pixafy' ), post_type_archive_title( '', false ) );
							} elseif ( is_tax() ) {
								$tax = get_taxonomy( get_queried_object()->taxonomy );
								/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
								$title = sprintf( __( '%1$s: %2$s', 'pixafy' ), $tax->labels->singular_name, single_term_title( '', false ) );
							} else {
								$title = __( 'Archives', 'pixafy' );
							}
							echo '<h1 class="page-title">'.$title.'</h1>';
							?>
						</header><!-- .page-header -->

						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>

							<?php
								/* Include the Post-Format-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
								 */
								get_template_part( 'content', get_post_format() );
							?>

						<?php endwhile; ?>

						<?php //the_posts_navigation(); ?>
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

					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>

					</main><!-- #main -->
				</div><!-- #primary -->

			<?php if (!$discussionDesign) :?>
			</div><!-- col-md-8 -->
			<?php endif; ?>

			<?php if (!$discussionDesign) :?>
				<div class="col-md-4">
					<?php get_sidebar(); ?>
				</div><!-- col-md-4 -->
			<?php endif ; ?>

		</div><!-- row -->
	</div><!-- container -->
</div><!-- post-wrapper -->

<?php
	/**
	 * end template logic on what kind
	 * of post is being requested
	 */
	endif;
?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>
