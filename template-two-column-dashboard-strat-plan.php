<?php
/*
  Template Name: Two Column Dashboard Stat Plan Page
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

<div class="pix-mast_section <?php echo get_field('dashboard_webinar_design') ? 'pix-dashboard_webinar_design' : ''; ?>">

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

	<section class="pix-container two-column_layout">
		<div class="row">
			<div class="pix-col_aside_wrapper">
				<div id="pix-nav_aside_toggle_wrapper" class="pix-nav_aside_toggle_wrapper">
					<div id="pix-nav_aside_toggle_button" class="pix-nav_aside_toggle_button">
						<div class="slicknav_menu">
							<a id="pix-dashboard_nav_aside_toggle_button" aria-haspopup="true" tabindex="0" class="slicknav_btn slicknav_collapsed slicknav_open" style="outline: none;">
								<span class="slicknav_icon">
									<span class="slicknav_icon-bar"></span>
									<span class="slicknav_icon-bar"></span>
									<span class="slicknav_icon-bar"></span>
									<div class="pix-clearfix"></div>
								</span>
								<div class="pix-clearfix"></div>
							</a>
						</div>
					</div>
				</div>
				<?php dynamic_sidebar('sidebar-6'); ?>
			</div>
			<div class="pix-mobile_col_aside_wrapper">
				<div class="pix-mobile_navigation">
					<div class="slicknav_menu">
						<a id="pix-mobile_nav_aside_toggle_button" aria-haspopup="true" tabindex="0" class="slicknav_btn slicknav_collapsed" style="outline: none;">
							<span class="slicknav_icon">
								<span class="slicknav_icon-bar"></span>
								<span class="slicknav_icon-bar"></span>
								<span class="slicknav_icon-bar"></span>
								<div class="pix-clearfix"></div>
							</span>
							<div class="pix-clearfix"></div>
						</a>
					</div>
					<span class="pix-mobile-dashboard-text">Dashboard</span>
					<?php dynamic_sidebar('sidebar-6'); ?>
				</div>
			</div>
			<div class="pix-col_content_wrapper">
				<div id="primary" class="content-area pix-dashboard_wrapper">
					<?php
						$assessmentClassRequired = '';
						if(get_field('enable_breadcrumbs_module')) {
							$assessmentClassRequired = ' pix-assessment_design';
						}
					?>
					<main id="main" class="site-main <?php echo $displayBreadcrumbs; echo $assessmentClassRequired; ?>" role="main">
						<?php if ( filter_input( INPUT_GET, 'status' ) === 'error' ) : ?>
						    <div class="pix-jed_error_wrapper">
						    	<p>There was an error updating the user. Please try again.</p>
						    </div>
						<?php endif ?>

						<?php
							// @admin_acf_plugin: Register Page – Form Breadcrumbs Helper
							if (get_field('enable_breadcrumbs_module')):
								$numberOfSteps = count(get_field('breadcrumb_step_collection'));
						?>
						 	<section id="pix-form_breadcrumbs_module_section" class="pix-form_breadcrumbs_module_section">
						    <ul class="pix-form_breadcrumbs_list_wrapper pix-<?php echo $numberOfSteps; ?>_step_list">
						    	<?php 
						    		$counter = 1;
						    		if(have_rows('breadcrumb_step_collection')):
										while (have_rows('breadcrumb_step_collection')):
											the_row();

											$isActive = get_sub_field('is_breadcrumb_active') ? ' current_breadcrumb' : '';
											$isLastChild = $counter === $numberOfSteps ? ' last-child' : '';
											$stepNumber = get_sub_field('breadcrumb_step_number');

											$stepStatus = do_shortcode('[pixafy-unanswered-questions form_name="assessment-form-page-' . $stepNumber . '"]');
								?>
						    		<li class="pix-form_breadcrumb_step<?php echo $isActive; echo $isLastChild; ?>" data-form-step="<?php echo $stepNumber; ?>">
						    			<span class="pix-step_status fa <?php echo intval($stepStatus) > 0 ? 'fa-close' : 'fa-check' ; ?>"></span>
						    			<?php if (!empty(get_sub_field('breadcrumb_step_url'))) : ?>
						    			<a class="pix-form_breadcrumb_link" href="<?php echo the_sub_field('breadcrumb_step_url'); ?>" >
						    				<p class="pix-form_breadcrumb_name"><?php echo the_sub_field('breadcrumb_step_number'); ?></p>
						    			</a>
						    			<?php else : ?>
						    			<span class="pix-form_breadcrumb_link">
						    				<p class="pix-form_breadcrumb_name"><?php echo the_sub_field('breadcrumb_step_number'); ?></p>
						    			</span>
						    			<?php endif; ?>
						    			<span class="crumb-separator">-</span>
						    		</li>

						    	<?php
						    				$counter++;
						    			endwhile;
						    		endif;
						    	?>
						    	<div class="pix-clearfix"></div>
						    </ul>
						  	</section>
						<?php endif; ?>

						<?php 
							//@admin_acf_plugin: Dashboard - Team Members
							if(get_field('enable_add_team_member_module')):
						?>
							<div class="pix-add_team_member_button_wrapper">
								<button id="add_team_member" class="pix-init_modal_button add_team_member">
									<?php echo get_field('team_member_button_copy'); ?>
								</button>
							</div>
						<?php endif; ?>
						
						<?php
							// @admin_acf_plugin: Dashboard - Webinar Video and Copy Module
							if (get_field('enable_webinar_module')):
						?>
							<section id="pix-school_testimonials_video_module_section" class="pix-school_testimonials_video_module_section">
								<div class="pix-school_testimonials_video_wrapper <?php echo get_field('dashboard_webinar_design') ? 'pix-dashboard_webinar_wrapper' : ''; ?>">
									<div class="pix-school_testimonials_video_half_col video_left_col">
										<div class="pix-school_testimonial"><?php echo get_field('dashboard_webinar_video_blurb'); ?></div>
									</div>
									<div class="pix-school_testimonials_video_half_col video_right_col">
										<?php if(get_field('is_image_url')) :?>
											<img src="<?php echo get_field('dashboard_webinar_url'); ?>" alt="" title="" />
										<?php else :?>
											<iframe src="<?php echo get_field('dashboard_webinar_url'); ?>?html5=1&output=embed" frameborder="0" allowfullscreen></iframe>
										<?php endif; ?>
									</div>
									<div class="pix-school_testimonials_video_half_col mobile_content">
										<div class="pix-school_testimonial"><?php echo get_field('dashboard_webinar_video_blurb'); ?></div>
									</div>
									<div class="pix-clearfix"></div>
								</div>
							</section>
						<?php endif; ?>

						<?php
							// @admin_acf_plugin: Dashboard - Campus Resource Documents Module
							if (get_field('enable_dashboard_campus_resources_module')):
						?>
							<section id="pix-campus_resources_module_section" class="pix-campus_resources_module_section">
								<?php
									$counter = 1;
									if(have_rows('dashboard_cr_collection')):
										while (have_rows('dashboard_cr_collection')):
											the_row();
								?>
 									    <article class="pix-article">
									    	<h3 class="pix-article_header"><?php echo the_sub_field('cr_header_title'); ?></h3>
									    	<ul class="pix-article_items_grid <?php echo get_sub_field('cr_hide_document_titles') ? 'pix-hide_titles' : '' ; ?>">
												<?php
											
													if(have_rows('cr_collection_listing')):
														while (have_rows('cr_collection_listing')):
															the_row();
												?>
														<li class="pix-article_item pix-dashboard_campus_resource_document_wrapper">
															<div class="pix-article_item_wrapper">
																<a target="_blank" href="<?php echo wp_get_attachment_url(the_sub_field('cr_document')); ?>"><img src="<?php echo the_sub_field('cr_document_image'); ?>" alt="" title="" />
																</a>
																<a target="_blank" href="<?php echo wp_get_attachment_url(the_sub_field('cr_document')); ?>">
																 	<p class="pix-article_item_title"><?php echo the_sub_field('cr_document_name'); ?></p>
																</a>
															</div>
														</li>
												<?php
														$counter++;
														endwhile;
													endif;
												?>
												<li class="pix-clearfix"></li>
									    	</ul>
									    </article>
					    		<?php
										$counter++;
										endwhile;
									endif;
								?>
							</section>
						<?php endif; ?>

						<?php 
							//$current_users = psp_get_project_users($post->ID);
							//echo do_shortcode('[pixafy_current_user_projects type="all" allowed_users="1" access="user" status="all" sort="start"]');
							//echo do_shortcode('[pixafy_project_list type="all" access="user" status="all"]');
							//if (have_posts()) : while (have_posts()) : the_post();
						?>

							<?php get_template_part( 'content', 'page' ); ?>

							<?php //endwhile; // end of the loop. ?>
							
						<?php
							//endif; 
						?>

					</main>
				</div>
			</div>
		</div>
	</section>


</div>

<?php
	get_footer();
	// End Template rendering
?>
