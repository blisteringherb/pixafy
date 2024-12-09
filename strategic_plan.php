<?php

/**
 * strat_plan_redirect 
 * Check the request uri to know if we are on the strat plan page.
 * If we are AND the user has a google sheet link, redirec to the google sheet.
 * Otherwise do nothing.
 */
function strat_plan_redirect() {
  $SLUG = 'dashboard-strategic-plan';
  $DASHBOARD = '/dashboard-campus-resource-documents';

  $current_page_path = filter_input(INPUT_SERVER, 'REQUEST_URI');
  $current_user_id = get_current_user_id();

  $url = $current_user_id > 0  ? get_field('google_sheet_link', 'user_'.$current_user_id) : null;

  $strat_page_id = url_to_postid( site_url($SLUG) );
  $current_page_id = url_to_postid(site_url( $current_page_path ));
  $grantedStratRole = is_user_role('granted_strategic_plan', $current_user_id);

  if(function_exists('is_user_role')){
    if($current_page_id == $strat_page_id && !$grantedStratRole){
      wp_redirect($DASHBOARD);
      exit();
    }
  }

  if($grantedStratRole &&
    !empty($url) &&
    !is_null($url) &&
    !empty($strat_page_id) &&
    $current_page_id == $strat_page_id
  ){
    wp_redirect($url); 
    exit();
  }
}
add_action('init', 'strat_plan_redirect', 10, 0);
