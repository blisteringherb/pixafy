<?php
function set_user_role($new_role, $user_id=null){
    global $wpdb;
    if($user_id==null){
        $user_id=get_current_user_id();
    }
    $roles=get_user_meta($user_id, $wpdb->prefix."capabilities", true);
    if(!is_array($roles)){
        $roles=array();
    }
    $roles[$new_role]=true;
    update_user_meta($user_id, $wpdb->prefix."capabilities", $roles);
}
function remove_user_role($role, $user_id=null){
    global $wpdb;
    if($user_id==null){
        $user_id=get_current_user_id();
    }
    $roles=get_user_meta($user_id, $wpdb->prefix."capabilities", true);
    if(!is_array($roles)){
        return;
    }
    $roles[$role]=false;
    update_user_meta($user_id, $wpdb->prefix."capabilities", $roles);
}
add_filter('script_loader_src', 'agnostic_script_loader_src', 20,2);
function agnostic_script_loader_src($src, $handle) {
    return preg_replace('/^(http|https?):/', '', $src);
}

add_filter('style_loader_src', 'agnostic_style_loader_src', 20,2);
function agnostic_style_loader_src($src, $handle) {
    return preg_replace('/^(http|https?):/', '', $src);
}
remove_action('load-update-core.php','wp_update_plugins');
add_filter('pre_site_transient_update_plugins','__return_null');

function is_user_role($role, $user_id = null) {
    if(is_null($user_id)){
        $user_id = get_current_user_id();
    }
    $roles = get_user_meta($user_id, 'wp_capabilities', false)[0];
    return $roles != '' && array_key_exists($role, $roles) && $roles[$role];
}
add_action( 'init', function() {
    remove_action('rest_api_init', 'wp_oembed_register_route');
    remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_oembed_add_host_js');
}, PHP_INT_MAX - 1 );