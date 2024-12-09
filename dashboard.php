<?php
add_filter('wppb_check_form_field_html', 'pixafy_check_password', 10, 4 );
function pixafy_check_password($message, $field, $request_data, $form_location){
    if($field['field-title']=='Current Password' && $form_location=='edit_profile'){
        $user = wp_get_current_user();
        if(!$user || !wp_check_password($request_data['current_password'], $user->data->user_pass, $user->ID)){
            return __('Invalid Password');
        }
    }
}