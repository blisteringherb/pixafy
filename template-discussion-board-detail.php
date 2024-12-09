<?php
/*
  Template Name: Discussion Board Detail Page
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

	// show/hide breadcrumbs for this template
	$displayBreadcrumbs = 'pix-display_wp_breadcrumbs';
	if (!get_field('display_wp_breadcrumbs')){
		$displayBreadcrumbs = 'pix-hide_wp_breadcrumbs';
	}

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

	<?php 
		// @admin_acf_plugin: Page – School Listing
		if (get_field('enable_school_listing_module')):
	?>
		<section id="pix-school_listing_section">
			<div class="pix-school_listing_wrapper">
				<ul class="pix-school_listing_items">
					<?php
						$counter = 1;
						$hasListItems = have_rows('school_collection');
				
						if($hasListItems):
							while ($hasListItems):
								the_row();
					?>
							<li class="pix-school_listing_item">
								<div class="pix-school_listing_item_wrapper">
									<img src="<?php echo the_sub_field('school_logo'); ?>" alt="" title="" />
									<a href="<?php echo the_sub_field('school_url'); ?>">
										<p class="pix-school_listing_title"><?php echo the_sub_field('school_title'); ?></p>
									</a>
								<div >
							</li>
					<?php
							$counter++;
							endwhile;
						endif;
					?>
					<li class="pix-clearfix"></li>
				</ul>
			</div>
		</section>
	<?php endif; ?>

	<section class="pix-container">
		<div class="row">
			<div class="pix-fullwidth_wrapper">
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

	<?php 
		// @admin_acf_plugin: Campus Journey Module
		if (get_field('enable_campus_journey_module')):
	?>
		<section id="pix-campus_journey_module_section" class="pix-campus_journey_module_section awsm-alternate awsm-date-opposite">
			<div class="pix-section_wrapper">
				<?php
					
					if(have_rows('campus_journey_timeline')):
						while (have_rows('campus_journey_timeline')):
							the_row();
				?>
							<div class="pix-campus_journey_year awsm-timeline-block awsm-timeline-label-block pix-journey_<?php echo $counter; ?>" data-animation="slideInUp">
							    <div class="awsm-labels awsm-start-label">
						        	<span><?php echo get_sub_field('campus_journey_year'); ?></span>
						        </div>
							</div>
							<?php
								$counter = 1;
								if(have_rows('campus_year_events')):
									while (have_rows('campus_year_events')):
										the_row();
										$rowClass = $counter % 2 == 0 ? 'even' : 'odd';
						    ?>
										<div class="pix-campus_journey_event awsm-timeline-block awsm-<?php echo $rowClass; ?>-item" data-animation="slideInUp">
									        <div class="awsm-timeline-img">
									        	<span><i class="pix-timeline_icon <?php echo get_sub_field('campus_event_icon'); ?>" aria-hidden="true"></i></span>
									        </div>
									        <div class="awsm-timeline-content">
									        	<div class="awsm-timeline-content-inner">
									            	<h2><?php echo get_sub_field('campus_event_title'); ?></h2>
									            	<span class="awsm-date"><?php echo get_sub_field('campus_event_date'); ?></span>
									            	<p><?php echo get_sub_field('campus_event_blurb'); ?></p>
									        	</div>
									        </div>
									    </div>
						    <?php
						    			$counter++;
									endwhile;
								endif;
						    ?>
				<?php
						endwhile;
					endif;
				?>			
			</div>
		</section>
	<?php endif; ?>

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
					<i class="pix-framework_content_icon <?php echo $frameworkJsonData[8]['icon']; ?>"></i>
					<?php if (!empty($frameworkJsonData[8]['link']) ): ?>
					<a href="<?php echo $frameworkJsonData[8]['link']; ?>">
					<?php endif; ?>
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
								<i class="pix-framework_content_icon <?php echo $frameworkContent['icon']; ?>"></i>
								<?php if (!empty($frameworkContent['link']) ): ?>
								<a href="<?php echo $frameworkContent['link']; ?>">
								<?php endif; ?>
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
