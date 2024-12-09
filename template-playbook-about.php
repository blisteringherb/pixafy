<?php
/*
  Template Name: Playbook About Page
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
		<div class="pix-search_module_wrapper">
			<?php echo do_shortcode('[searchandfilter slug="playbook-search-only"]'); ?>
			<?php //echo do_shortcode('[searchandfilter slug="playbook"]'); ?>
		</div>
	</section>

	<section class="pix-container">
		<div class="row">
			<div class="pix-playbook_about_wrapper">
				<div id="primary" class="content-area">
					<main id="main" class="site-main <?php echo $displayBreadcrumbs; ?>" role="main">

						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

							<?php get_template_part( 'content', 'page' ); ?>

							<?php endwhile; // end of the loop. ?>
							
						<?php endif; ?>

					</main>
				</div>
			</div>
		</div>
	</section>

	<?php
		// @admin_acf_plugin: Page – Framework of Success Module
		if (get_field('enable_framework_module')):
			//$frameworkData = json_encode(get_field('circle_content_creator'));
	?>
		<section id="pix-framework_module_section" class="pix-framework_module_section">
			<div id="pix-framework_wrapper" class="pix-framework_wrapper">
				<?php if(get_field('enable_framework_helper_text')) :?>
				<span class="pix-framework_helper_copy"><?php echo get_field('framework_helper_text'); ?></span>
				<?php endif; ?>
				<div class="pix-framework">
					<map name="Framework" id="Framework">
						<?php
						$frameworkJsonData = array();
						// data generated @http://imagemap-generator.dariodomi.de/ with a framework image of 700px width
						$coordinateData = array(
								1 => "409,518,294,516,234,645,351,673,470,644",
								2 => "266,503,194,416,58,446,110,556,205,630",
								3 => "214,273,102,184,50,288,51,415,189,384",
								4 => "335,56,213,84,124,158,236,248,336,196",
								5 => "471,248,367,198,369,54,485,82,579,157",
								6 => "657,415,654,286,601,184,489,270,514,383",
								7 => "647,444,506,414,437,502,498,632,595,559",
								8 => "195,60,278,33,351,26,439,38,516,66,526,42,411,1,282,2,186,37"
							);
						if(have_rows('circle_content_creator')):
							while (have_rows('circle_content_creator')):
								the_row();

								$position = get_sub_field('framework_content_position');
								$title = get_sub_field('framework_content_title');
								$content = get_sub_field('framework_content');
								$link = get_sub_field('framework_content_link');

								if ($position == '8'){
						?>
							<area id="img_area-<?php echo $position; ?>" <?php echo !empty($link) ? 'href="' . $link . '"' : '';?> class="pix-framework_area" shape="poly" alt="<?php echo $title?>" coords="<?php echo $coordinateData[$position]; ?>">
							</area>
							<div class="pix-tooltip pix-tooltip_id-<?php echo $position; ?>" id="pix-tooltip_id-<?php echo $position; ?>" >
								<?php echo $content; ?>
								<span class="tooltip-pointer"></span>
							</div>
						<?php
								}
								$frameworkJsonData[get_sub_field('framework_content_position')] = array(
										'title' => get_sub_field('framework_content_title'),
										'text' => get_sub_field('framework_content'),
										'icon' => get_sub_field('framework_content_icon'),
										'link' => get_sub_field('framework_content_link')
									);
							endwhile;
						endif;
						?>
					</map>
					<div class="pix-framework_shapes_wrapper">
					<?php
						if(count($frameworkJsonData) > 0):
							foreach ($frameworkJsonData as $key => $frameworkContent):
								if ($key == '8'){ continue; }
								$shapeId = str_replace(' ', '-', $frameworkContent['title']);
					?>
								<?php if (!empty($frameworkContent['link']) ): ?>
								<a href="<?php echo $frameworkContent['link']; ?>">
								<?php endif; ?>
									<div id="pix-shape_<?php echo $key; ?>" class="pix-shape pix-shape_<?php echo $key; ?>">
										<div class="pix-shape_content_wrapper">
											<i class="pix-shape_icon <?php echo $frameworkContent['icon']; ?>"></i>
											<div class="pix-framework_content_text"><?php echo $frameworkContent['title']; ?></div>
											<div class="pix-tooltip pix-tooltip_id-<?php echo $key; ?>" id="pix-tooltip_id-<?php echo $key; ?>" >
												<?php echo $frameworkContent['text']; ?>
												<span class="tooltip-pointer"></span>
											</div>
										</div>
									</div>
								<?php if (!empty($frameworkContent['link']) ): ?>
								</a>
								<?php endif; ?>
					<?php
							endforeach;
						endif;
					?>
						<img id="pix-framework_graphic" usemap="#Framework" class="pix-framework_graphic" src="<?php echo get_field('circle_content_background'); ?>" />
						<img class="pix-framework_graphic mobile_framework_graphic" src="<?php echo get_field('mobile_circle_content_background'); ?>" />
					</div>
				</div>
			</div>
			<article class="pix-article">
				<div class="pix-content_block"><?php echo get_field('circle_content_summary'); ?></div>
			</article>
			<div class="pix-framework_content_mobile">
				<article class="pix-article pix-framework_content_blurb framework-mobile_content_8">
					<?php if (!empty($frameworkJsonData[8]['link']) ): ?>
					<a href="<?php echo $frameworkJsonData[8]['link']; ?>">
					<?php endif; ?>
					<i class="pix-framework_content_icon <?php echo $frameworkJsonData[8]['icon']; ?>"></i>
					
						<h3 class="pix-framework_content_title"><?php echo $frameworkJsonData[8]['title']; ?></h3>
					<?php if (!empty($frameworkJsonData[8]['link']) ): ?>
					</a>
					<?php endif; ?>
					<div class="pix-framework_content_text"><?php echo $frameworkJsonData[8]['text']; ?></div>
				</article>
				<?php
					if(count($frameworkJsonData) > 0):

						foreach ($frameworkJsonData as $key => $frameworkContent):
							if ($key == '8'){ continue; }
				?>
							<article class="pix-article pix-framework_content_blurb framework-mobile_content_<?php echo $key; ?>">
								<?php if (!empty($frameworkContent['link']) ): ?>
								<a href="<?php echo $frameworkContent['link']; ?>">
								<?php endif; ?>
								<i class="pix-framework_content_icon <?php echo $frameworkContent['icon']; ?>"></i>
									<h3 class="pix-framework_content_title"><?php echo $frameworkContent['title']; ?></h3>
								<?php if (!empty($frameworkContent['link']) ): ?>
								</a>
								<?php endif; ?>
								<div class="pix-framework_content_text"><?php echo $frameworkContent['text']; ?></div>
							</article>
				<?php
						endforeach;
					endif;
				?>
			</div>
		</section>
	<?php endif; ?>

</div>

<?php
	get_footer();
	// End Template rendering
?>
