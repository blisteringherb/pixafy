<?php
/*
  Template Name: Playbook Search Page
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

	<section class="pix-container two-column_layout">
		<div class="row">
			<div class="col-md-8 pix-col_content_wrapper">

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
							</div>
						</nav>

					<?php else : ?>

						<?php get_template_part( 'content', 'none' ); ?>

					<?php endif; ?>

					</main>
				</div>

			</div>

			<aside class="col-md-4 pix-col_aside_wrapper">
				<?php $slug = get_the_category()[0]->slug; ?>
				<script type="text/javascript">
					jQuery(document).on('ready', function(){
						if(!!window.history && !!window.history.replaceState){
							window.history.replaceState(null, null, '?_sft_category=<?php echo $slug; ?>');
						}
					});
				</script>
				<?php echo do_shortcode('[searchandfilter slug="playbook-search"]'); ?>
				<?php get_sidebar(); ?>
				<?php get_sidebar('social-media'); ?>
			</aside>

		</div>
	</section>

</div>

<?php
	get_footer();
?>
