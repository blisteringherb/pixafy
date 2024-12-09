<?php
add_filter( 'ctdb_author_name', 'pixafy_filter_author_name', 101 );
function pixafy_filter_author_name( $author ) {
    $options = get_option( 'ctdb_user_settings' );
    if( isset( $options['display_user_name'] ) ) {
        return get_the_author_meta('first_name').' '.get_the_author_meta('last_name').' ('.get_the_author_meta('user_login').')';
    }
    return $author;
}
remove_all_actions('wp_login_failed');