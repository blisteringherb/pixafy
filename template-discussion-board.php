<?php
/*
  Template Name: Discussion Board Page
 */
?>
<?php
	if(!is_user_logged_in()){
        header('Location: /login');
        exit();
    }
    $restrict_role=array();
    if(get_field( "restrict_role" )!=null && get_field( "restrict_role" )!=''){
        $restrict_role=explode(',',get_field( "restrict_role" ));
    }
    $current_user_roles=array_keys(get_user_meta(get_current_user_id(),'wp_capabilities', false)[0]);
    if(sizeof($restrict_role)>0 && sizeof($restrict_role)>0 && sizeof(array_intersect($current_user_roles,$restrict_role))==0){
        header('Location: /login');
        exit();
    }

	// show/hide breadcrumbs for this template
	$displayBreadcrumbs = 'pix-display_wp_breadcrumbs';
	if (!get_field('display_wp_breadcrumbs')){
		$displayBreadcrumbs = 'pix-hide_wp_breadcrumbs';
	}

	// Begin Template rendering
	get_header();
?>

<div class="pix-mast_section pix-discussion_listing_wrapper">

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

	<section class="pix-container">
		<div class="row">

			<div class="pix-discussion_board_table_wrapper">
				<header class="ctdb-topic-table-mastheader">Discussion Board</header>
				<li class="ctdb-topic-table-header">
					<ul class="ctdb-topic-table-row ctdb-topic-table-header-row">
						<li class="ctdb-topic-table-item ctdb-topic-table-topic">Discussion</li>
						<li class="ctdb-topic-table-item ctdb-topic-table-replies">Topics</li>
					</ul>
				</li>
				<li class="ctdb-topic-table-body">
					<?php
						// $posts = get_posts(array(
						//   'post_type' => 'discussion-topics',
						//   'numberposts' => -1,
						//   'tax_query' => array(
						//     array(
						//       'taxonomy' => 'board',
						//       'field' => 'id',
						//       'terms' => $randall[0]->term_id
						//     )
						//   )
						// ));
						$boards = get_terms( array(
						    'taxonomy' => 'board',
						    'orderby' => 'count',
						    'order' => 'DESC',
						    'hide_empty' => false
						));

						//$ra = get_term_children($randall[0]->term_id, 'board');

						// echo '<pre>';
						// var_dump($posts);
						// var_dump($boards);
						// echo '</pre>';

						$counter = 0;
						foreach ($boards as $board):
							$alternateClass = ($counter % 2) ? 'odd' : 'even';
					?>
							<ul class="ctdb-topic-table-row ctdb-topic-table-header-row <?php echo $alternateClass;?>">
								<li class="ctdb-topic-table-item ctdb-topic-table-topic">
									<p><a href="<?php echo get_permalink() . $board->slug; ?>"><?php echo $board->name; ?></a></p>
									<div class="ctdb-topic-table-excerpt"><?php echo $board->description; ?></div>
									<div class="pix-topic_mobile_data">
										<span class="pix-topic_comments_mobile_data">Topics: <?php echo $board->count; ?></span>
									</div>
								</li>
								<li class="ctdb-topic-table-item ctdb-topic-table-replies">
									<p><?php echo $board->count; ?></p>
								</li>
							</ul>

					<?php
							$counter++;
						endforeach;
					?>
				</li>
			</div>

			<div id="primary" class="content-area">
				<main id="main" class="site-main <?php echo $displayBreadcrumbs; ?>" role="main">

					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

						<?php get_template_part( 'content', 'page' ); ?>

						<?php endwhile; // end of the loop. ?>
						
					<?php endif; ?>

				</main>
			</div>
		</div>
	</section>

	<?php 
		// @admin_acf_plugin: Page – Accordion Module
		if (get_field('enable_accordion_module')):
	?>
		<section id="pix-accordion_module_section" class="pix-accordion_module_section">
			<ul id="pix-accordion_wrapper" class="pix-accordion_list">
				<?php
					$counter = 1;
					if(have_rows('item_collection')):
						while (have_rows('item_collection')):
							the_row();
				?>
							<li id="pix-accordion_block-<?php echo $counter; ?>" class="pix-accordion_block">
								<h2 class="pix-accordion_block_title"><?php echo the_sub_field('item_title'); ?></h2>
								<div class="pix-accordion_block_content"><?php echo the_sub_field('item_content'); ?></div>
							</li>
				<?php
							$counter++;
						endwhile;
					endif;
				?>
				<li class="pix-clearfix"></li>
			</ul>
		</section>
	<?php endif; ?>


</div>

<?php
	get_footer();
	// End Template rendering
?>
