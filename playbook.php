<?php
// Optimized function to fetch multiple posts by title
function get_multiple_posts_by_title($title, $limit = 10) {
    global $wpdb;

    // Use a prepared statement to fetch the post IDs and titles in one go
    $sql = $wpdb->prepare(
        "SELECT ID, post_title FROM $wpdb->posts WHERE post_title LIKE %s AND post_type = 'post' AND post_status = 'publish' LIMIT %d", 
        '%' . $wpdb->esc_like($title) . '%', 
        $limit
    );

    // Get all posts matching the search query
    $posts = $wpdb->get_results($sql, OBJECT);

    // Pre-fetch the permalinks to reduce the number of queries
    $post_ids = wp_list_pluck($posts, 'ID');
    $post_urls = array_map('get_permalink', $post_ids);

    // Combine post titles and URLs
    $posts_titles = array_map(function($post, $url) {
        return array('title' => $post->post_title, 'url' => $url);
    }, $posts, $post_urls);

    return $posts_titles;
}

// URL: /wp-json/pixafy/playbook/autocomplete
// parameters: search
function find_post_titles_autocomplete($data) {
    $post_titles = array();

    // Sanitize the search parameter
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search_query = sanitize_text_field($_GET['search']);
        $post_titles = get_multiple_posts_by_title($search_query);
    }

    // Return the post titles in JSON format
    wp_send_json($post_titles);
    exit();
}

add_action('rest_api_init', function () {
    register_rest_route('pixafy', '/playbook/autocomplete', array(
        'methods'  => 'GET',
        'callback' => 'find_post_titles_autocomplete',
    ));
});

// Function to check if the user can see the playbook based on roles
function can_user_see_playbook($restrict_roles = array()) {
    if (is_user_logged_in()) {
        $current_user_roles = wp_get_current_user()->roles;

        // Check if the user has any of the restricted roles
        if (!empty($restrict_roles) && !empty(array_intersect($current_user_roles, $restrict_roles))) {
            return true;
        }
    } elseif (isset($_SESSION['team_member'])) {
        // If the session contains a valid team member, allow access
        return true;
    }

    return false;
}