<?php
if ( ! defined( 'DB_PRO_PLUGIN_URL' ) ) {
	define( 'DB_PRO_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
function enqueue_scripts() {
    wp_localize_script( 'ctdb-script', 'ajax_object', array(
        'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
        'postid' 	=> get_the_id(),
        'userid'	=> get_current_user_id()
    ) );
        
}

add_action( 'init', 'enqueue_scripts');

function pixafy_capture_answered_and_unanswered_questions(){
    $GLOBALS['wppb_manage_fields'] = isset($GLOBALS['wppb_manage_fields']) ? $GLOBALS['wppb_manage_fields'] : get_option('wppb_manage_fields');
    if(count($_POST) > 0){
        $form_name = isset($_POST['form_name']) ? $_POST['form_name'] : '';
        $total_questions = isset($_POST['total_questions']) ? (int)$_POST['total_questions'] : 0;

        if(isset($form_name) && (preg_match('/assessment-form-page-\d/',$form_name) || preg_match('/post-assessment-form-–-page-–-\d/',$form_name))) {
            $assessment_type = stripos($form_name, 'post') === false ? 'initial' : 'post';
            
            $fields = array_filter($GLOBALS['wppb_manage_fields'], function($field){
                return array_key_exists($field['meta-name'], $_POST) && _checkConditionalStatus($field, $_POST, $GLOBALS['wppb_manage_fields']);
            });

            $mandatory_fields = array_filter($fields, function($mfield){
                return isset($mfield['is-mandatory']);
            });

            $answered_fields = array_filter($fields, function($field){
                return isset($_POST[$field['meta-name']]);
            });

            $answered_mandatory = array_filter($mandatory_fields, function($field){
                return isset($_POST[$field['meta-name']]);
            });

            $answered = count($answered_fields);
            if($answered > $total_questions){
                $answered = $total_questions;
            }
            $unanswered = $total_questions - $answered;
            $_unanswered_mandatory = count($mandatory_fields) - count($answered_mandatory);

            update_user_meta(get_current_user_id(), $form_name.'_unanswered_mandatory', ($_unanswered_mandatory>=0)?$_unanswered_mandatory:0);
            update_user_meta(get_current_user_id(), $form_name.'_unanswered_count', ($unanswered >=0)?$unanswered:0);
            update_user_meta(get_current_user_id(), $form_name.'_answered_count',($answered >=0)?$answered:0);
        }
    }
}
add_action( 'init', 'pixafy_capture_answered_and_unanswered_questions');

function _checkConditionalStatus($field, $request_data, $wppb_manage_fields){
    if($field["conditional-logic-enabled"] != 'yes'){
        return true;
    }

    $field_conditional_logic = json_decode( $field["conditional-logic"], true);
    $logic_type = $field_conditional_logic['logic_type'];
    $conditions_met = $logic_type == 'all' ? true : false;

    foreach($field_conditional_logic['rules'] as $rule ){
        $field_meta_name = get_field_meta_name_by_id($rule['field'], $wppb_manage_fields);
        $cond_field_value = isset($request_data[$field_meta_name]) ? $request_data[$field_meta_name] : null;
        if( is_array($cond_field_value) ){
            $cond_field_value = isset($cond_field_value['value']) ? $cond_field_value['value'] : null;
        }

        if($logic_type == 'any'){
            if($rule['operator'] == 'is' && $cond_field_value == $rule['value']){
                $conditions_met = true;
                break;
            }
            if($rule['operator'] == 'is not' && $cond_field_value != $rule['value']){
                $conditions_met = true;
                break;
            }
        }
        
        if($logic_type == 'all') {
            if($rule['operator'] == 'is' && $cond_field_value != $rule['value'] ){
                $conditions_met = false;
                break;
            }
            if($rule['operator'] == 'is not' && $cond_field_value == $rule['value']){
                $conditions_met = false;
                break;
            }
        }
    }

    return $conditions_met;
}

// function _shouldCheckConditional($field, $request_data, $wppb_manage_fields){
//     if($field["conditional-logic-enabled"] != 'yes'){
//         return true;
//     }
//     else {
//         return !_checkConditionalStatus($field, $request_data, $wppb_manage_fields);
//     }
// }

function get_field_meta_name_by_id($id, $wppb_manage_fields){
    if( !empty( $wppb_manage_fields )  ) {
        $cond_field_key = array_search($id, array_column($wppb_manage_fields, 'id'));

        if(!$cond_field_key){
            return '';
        }
        $cond_field = $wppb_manage_fields[$cond_field_key];

        if( !empty($cond_field['meta-name']) ){
            return $cond_field['meta-name'];
        }
        else{
            switch ( Wordpress_Creation_Kit_PB::wck_generate_slug( $cond_field['field'] ) ){
                case 'default-username':
                    return 'username';
                    break;
                case 'default-display-name-publicly-as':
                    return "display_name";
                    break;
                case 'default-e-mail':
                    return 'email';
                    break;
                case 'default-website':
                    return 'website';
                    break;
            }
        }
    }
    return '';
}

function _get_assessment_type( $atts ){
    if( isset($atts['type']) ){ //this is what should be set
        return $atts['type'];
    }
    else if( isset($atts['assessment']) ){ //this was the old key
        return $atts['assessment'];
    }
    else {
        return stripos($atts['form_name'], 'post') !== false ? 'post' : 'initial'; //last resort
    }
}

function _get_post_meta_by_form_name( $form_name ){
    if(isset($form_name)){
        $post = get_posts(array(
            'name' => $form_name,
            'post_type' => 'wppb-epf-cpt',
            'posts_per_page' => 1
        ));
        $post_meta = isset($post[0]) ? get_post_meta($post[0]->ID, 'wppb_epf_fields', false): null;
        return isset($post_meta[0]) ? $post_meta[0] : null;
    }
    return null;
}

function pixafy_get_updated_form_data( $atts ){
    $user_meta = get_user_meta(get_current_user_id());
    //$wppb_manage_fields = get_option('wppb_manage_fields');
    $GLOBALS['wppb_manage_fields'] = isset($GLOBALS['wppb_manage_fields']) ? $GLOBALS['wppb_manage_fields'] : get_option('wppb_manage_fields');

    $type = _get_assessment_type($atts);

    $fieldArray = _get_post_meta_by_form_name($atts['form_name']);

    $slug = isset($atts['slug']) ? $atts['slug'] : null;
    $page_num = isset($atts['page_num']) ? $atts['page_num'] : -1;

    if(is_null($fieldArray)){
        $fieldArray = array();
    }

    $fieldIds = array_column($fieldArray, 'id');
    if(is_null($fieldIds)){
        $fieldIds = array();
    }

    $i_orders = array_column($fieldArray, "i-order");
    $formNoValues = array();
    foreach ($i_orders as $key => $order) {
        $formNoValues['school_assessment_'.$order] = array('');
    }

    //$_POST data is structured ['key'] => (string) "value"
    // but
    // $user_meta is structured ['key'] => array([0] => (string) "value")
    // this filters all school assessment fields and formats the data the way we need it.
    $new_assessment_data = array();
    if(count($_POST) > 0 && $slug == $page_num){
        foreach ($_POST as $key => $value) {
            if(stripos($key, 'school_assessment') !== false){
                $new_assessment_data[$key] = is_array($value) ? $value : array($value);
            }
        }
    }

    $formDataPlusNew = count($new_assessment_data) > 0 ? array_merge($formNoValues, $new_assessment_data): array();

    $updated_user_meta = array_merge($user_meta, $formDataPlusNew);

    $formData = array();

    foreach ($GLOBALS['wppb_manage_fields'] as $key => $value) {
        if(in_array($value['id'], $fieldIds)){
            $formData[$value['meta-name']] = array(
                'field-title' => $value['field-title'],
                'id' => $value['id'],
                'is-mandatory' => isset($value['is-mandatory']) ? $value['is-mandatory'] : false,
                'conditional-logic-enabled' => $value['conditional-logic-enabled'],
                'conditional-logic' => $value['conditional-logic'],
                'meta-name' => $value['meta-name'],
                'value' => isset($updated_user_meta[$value['meta-name']][0]) ? $updated_user_meta[$value['meta-name']][0] : null
            );
        }
    }

    return $formData;
}

function pixafy_assesment_update_and_save( $http_request, $form_name, $user_id ){
    if(preg_match('/assessment-form-page-\d/',$form_name) || preg_match('/post-assessment-form-–-page-–-\d/',$form_name)) {
        if(isset($http_request['update_and_exit'])){
            echo "<script>window.location='".get_site_url()."/dashboard-campus-assessments-listing/';</script>";
        }
    }
}
add_action( 'wppb_edit_profile_success', 'pixafy_assesment_update_and_save', 20, 3 );

function pixafy_unanswered_questions( $atts ){
    $amount= get_user_meta(get_current_user_id(), $atts['form_name'].'_unanswered_count', true);
    if($amount==''){
        return pixafy_total_section_questions( $atts );
    }
    return $amount;
}
add_shortcode( 'pixafy-unanswered-questions', 'pixafy_unanswered_questions' );

function pixafy_unanswered_mandatory( $atts ){
    $GLOBALS['wppb_manage_fields'] = isset($GLOBALS['wppb_manage_fields']) ? $GLOBALS['wppb_manage_fields'] : get_option('wppb_manage_fields');
    $formData = pixafy_get_updated_form_data($atts);
    $type = _get_assessment_type($atts);

    $unanswered_mandatory = array();
    $all_mandatory = array();

    if(count($formData) == 0){
        return false;
    }

    foreach ($formData as $key => $mfield) {
        if( $mfield['is-mandatory'][$type] === true ){

            if( _checkConditionalStatus($mfield, $formData, $GLOBALS['wppb_manage_fields']) ){

                $all_mandatory[$key] = $mfield;

                if( !isset($mfield['value']) || trim($mfield['value']) == '' ){
                    $unanswered_mandatory[$key] = $mfield;
                }
            }
        }
    }

    return (int)(count($unanswered_mandatory) == 0);
}
add_shortcode( 'pixafy-unanswered-mandatory', 'pixafy_unanswered_mandatory' );

// SECTION FUNCTIONS
/**
 * [pixafy_section_answered_questions description]
 * @param  [type] $atts [description]
 * @return [type]       [description]
 */
function pixafy_section_answered_questions( $atts ){
    $formData = pixafy_get_updated_form_data($atts);
    $parentFields = array();

    foreach ($formData as $key => $mfield) {
        if( preg_match('/(_\d+_?[a-z]*)$/',str_ireplace(array('_post','_initial'),'',$key)) && (isset($mfield['value']) && trim($mfield['value']) != '') ){
            if(strtolower($mfield['conditional-logic-enabled']) !== 'yes'){
                $parentFields[$key] = $mfield;
            }
        }
    }

    return count($parentFields);
}
add_shortcode( 'pixafy-section-answered-questions', 'pixafy_section_answered_questions' );
/**
 * [pixafy_total_section_questions description]
 * @param  [type] $atts [description]
 * @return [type]       [description]
 */
function pixafy_total_section_questions( $atts ){
    $post_meta = _get_post_meta_by_form_name($atts['form_name']);
    $GLOBALS['form_ids'] = array_column($post_meta, 'id');
    $GLOBALS['wppb_manage_fields'] = isset($GLOBALS['wppb_manage_fields']) ? $GLOBALS['wppb_manage_fields'] : get_option('wppb_manage_fields');

    $fieldArray = array_filter($GLOBALS['wppb_manage_fields'], function($item){
        $id = $item['id'];
        if(array_search($id, $GLOBALS['form_ids']) !== false){
            if( preg_match('/(_\d+_?[a-z]*)$/', str_ireplace(array('_post','_initial'),'',$item['meta-name'])) && strtolower($item['conditional-logic-enabled']) != 'yes'){
                return true;
            }
        }
        return false;
    });

    return count($fieldArray);
}
add_shortcode( 'pixafy-total-section-questions', 'pixafy_total_section_questions');

// END SECTION FUNCTIONS

function is_field_conditional($managedfields,$field){
    foreach($managedfields as $field_array){
        if(preg_match('/school_assessment_\d{1,4}_[a-z]/',$field_array['meta-name'])){
            return true;
        }else if($field_array['id']==$field['id'] && $field_array['conditional-logic-enabled']==''){
            return false;
        }else if($field_array['id']==$field['id'] && $field_array['conditional-logic-enabled']=='yes'){
            return true;
        }
    }
    return false;
}

function pixafy_total_unanswered_questions( $atts ){
    $amount = 0;
    //$managedfields = get_option('wppb_manage_fields');
    $GLOBALS['wppb_manage_fields'] = isset($GLOBALS['wppb_manage_fields']) ? $GLOBALS['wppb_manage_fields'] : get_option('wppb_manage_fields');
    $_prefix = ($atts['assessment']=='post')? 'post-assessment-form-page-':'assessment-form-page-';

    foreach(range(1,10) as $page) {

        $tempamount = get_user_meta(get_current_user_id(), $_prefix.$page.'_unanswered_count', true);

        if($tempamount!=''){
            $amount+=$tempamount;
        }else{
            $post = get_posts(array(
                'name' => 'assessment-form-page-'.$page,
                'post_type' => 'wppb-epf-cpt',
                'posts_per_page' => 1
            ))[0];
            if(!is_null($post)){
                $tempfieldarray=get_post_meta($post->ID,  'wppb_epf_fields', false);
                if(isset($tempfieldarray[0]) && is_array($tempfieldarray[0])){
                    foreach($tempfieldarray[0] as $field) {
                        if(!is_field_conditional($GLOBALS['wppb_manage_fields'],$field)) {
                            $amount++;
                        }
                    }
                }
            }
        }
    }
    if($amount==0){
        return pixafy_total_questions_assessments($atts);
    }
    return $amount;
}
add_shortcode( 'pixafy-total-unanswered-questions', 'pixafy_total_unanswered_questions' );

function pixafy_total_questions_assessments($atts){
    $type = $atts['assessment'];
    $GLOBALS['form_type'] = !isset($type) && isset($atts['assessment']) ? $atts['assessment']: 'initial';
    $GLOBALS['wppb_manage_fields'] = isset($GLOBALS['wppb_manage_fields']) ? $GLOBALS['wppb_manage_fields'] : get_option('wppb_manage_fields');
    //$managedfields = get_option('wppb_manage_fields');

    $fieldArray = array_filter($GLOBALS['wppb_manage_fields'], function($item){
        $meta_name = $item['meta-name'];
        if(pixafy_ends_with($meta_name, $GLOBALS['form_type'])){
            if( preg_match('/(_\d+_?[a-z]*)$/', $meta_name) && strtolower($item['conditional-logic-enabled']) != 'yes'){
                return true;
            }
        }
        return false;
    });

    return count($fieldArray);
}
add_shortcode( 'pixafy-total-questions', 'pixafy_total_questions_assessments' );

function pixafy_total_answered_questions_assesments($atts){
    $top_parent_questions = '/(_\d+)$/';
    $type = _get_assessment_type($atts);

    $user_meta = get_user_meta(get_current_user_id());

    $school_assessment_data = array();
    $formNoValues = array();
    $new_assessment_data = array();

    $post_count = count($_POST);

    if( isset($atts['form_name']) && $post_count > 0 ){
        $fieldArray = _get_post_meta_by_form_name($atts['form_name']);

        if(is_null($fieldArray)){
            $fieldArray = array();
        }

        $i_orders = !is_null($fieldArray) ? array_column($fieldArray, "i-order") : array();
        foreach ($i_orders as $key => $order) {
            if( preg_replace('/(^\d+_)/', '', $order) == $type ){
                $new_assessment_data['school_assessment_'.$order] = '';
            }
        }
    }

    foreach ($user_meta as $key => $value) {

        if(stripos($key, 'school_assessment') !== false && stripos($key, $type) !== false){
            $key_no_type = str_replace('_'.$type, '', $key);

            if( isset($value) && preg_match($top_parent_questions, $key_no_type) ){
                $_value = is_array($value) ? trim($value[0]) : trim($value);

                if($_value != ''){
                    $school_assessment_data[$key] = $_value;
                }
            }
        }
    }
    
    if($post_count > 0){ //$_POST data won't contain questions that have had their answers removed.

        foreach ($_POST as $key => $value) {
            $key_no_type = str_replace('_'.$type, '', $key);
            $_value = is_array($value) ? trim($value[0]) : trim($value);

            if(stripos($key, 'school_assessment') !== false && preg_match($top_parent_questions, $key_no_type) ){
                $new_assessment_data[$key] = $_value;
            }
        }
    }
    $updated_user_meta = count($new_assessment_data) > 0 ? array_merge($formNoValues, $school_assessment_data, $new_assessment_data): $school_assessment_data;
    $updated_user_meta = array_filter($updated_user_meta, function($val){ return $val !== ''; });
    
    // ksort($updated_user_meta);
    // echo '<pre style="display:none;width:800px;position:relative;">';
    // var_dump($updated_user_meta);
    // echo '</pre>';
    
    return count($updated_user_meta);
}
add_shortcode( 'pixafy-total-answered-questions', 'pixafy_total_answered_questions_assesments' );

function pixafy_check_questions($display_field, $field){
    if(preg_match('/school_assessment_\d/',$field['meta-name'])) {
        $disallowedquestions=explode(',',get_user_meta(get_current_user_id(), 'assessment_questions',true));
        if(in_array($field['id'],$disallowedquestions)) {
            return false;
        }
    }
    return true;
}
add_filter('wppb_output_display_form_field', 'pixafy_check_questions',10,2);

function get_feedback($attr){
    $title = get_the_title();
    $type = stripos($title, "post") !== false ? "post-" : "";
    $page=get_posts(array('name' => $type.'assessment-form-page-'.$attr['id'],'post_type' => 'wppb-epf-cpt'));
    $page=$page[0];
    if(!$page || $page==null){
        return false;       
    }
    
    //echo 'school_assessment_feedback_'.$page->ID.' | '.$type.'assessment-form-page-'.$attr['id'];
    $feedback=get_user_meta(get_current_user_id(), 'school_assessment_feedback_'.$page->ID,true);
    if($feedback=='' || $feedback==null){
        return false;
    }
    return $feedback;
}
add_shortcode('feedback', 'get_feedback');

function is_mandatory_missing($managedfields, $field, $type){
    $key = array_search($field['id'], array_column($managedfields, 'id'));
    if($key == false){
        return false;
    }
    else {
        $field_array = $managedfields[$key];
        $is_mandatory = $field_array['is-mandatory'][$type];
        $field_value = get_user_meta(get_current_user_id(), $field_array['meta_name'], true);
        
        if($field_array['conditional-logic-enabled'] == 'yes' || $is_mandatory == false){
            return false;
        }
        else if($is_mandatory && empty($field_value)) {
            return true; // the field is mandatory
        }
    }
    return false;
}

/**
 * check_user_answered_all_mandatory description
 * @param  Array $atts      attributes from the shortcode
 * @param  String $form_name - Optionally pass in the for_name
 * @return int     always a 1 or 0, 1 for all in the range are complete, 0 if any are not.
 */
function check_user_answered_all_mandatory($atts = array(), $form_name = ''){
    $type = isset($atts['assessment']) ? $atts['assessment']: 'initial';

    if(!isset($form_name) || empty($form_name)){
        if(isset($atts['form_name'])){
            $form_name = $atts['form_name'];
        }
        else {
            $form_name = isset($type) && $type != 'initial' ? $type.'-assessment-form-page-':'assessment-form-page-';
        }
    }

    $min = isset($atts['min']) ? (int) $atts['min'] : 1; //lower bound of range (pages) to check
    $max = isset($atts['max']) ? (int) $atts['max'] : 10; //upper bound of range (pages) to check

    $all_fields_completed = 0; //false
    $current_page = 1;
    foreach (range($min,$max) as $page_num) {
        $atts = array(
            'form_name' => $form_name.$page_num,
            'type' => $type,
        );

        $current_page = $page_num;
        
        $form_status = pixafy_unanswered_mandatory($atts);

        if( $form_status == 0 ){
            $all_fields_completed = 0;
            break; //don't contiue the loop if a page is found to be incomplete
        }
        elseif( $form_status == 1 ){
            $all_fields_completed = $form_status;
        }
    }

    return $all_fields_completed; //json_encode(array('status' => $all_fields_completed, 'form_name' => $form_name, 'last_page' => $current_page));
}
add_shortcode('user-answered-all-mandatory', 'check_user_answered_all_mandatory');

/**
 * pixafy_ajax_check_form_status 
 * Gather the $_POST data from the AJAX and apply it to the shortcode.
 * @return int - returns value of shortcode or 0 is the assessment type is not set.
 */
function pixafy_ajax_check_form_status(){
    $type = $_POST['assessment'];
    $max = isset($_POST['max']) ? $_POST['max'] : 10;

    if(isset($type)){
        echo check_user_answered_all_mandatory(array('assessment' => $type, 'max' => $max));
        //do_shortcode('[user-answered-all-mandatory assessment="'.$type.'" max="'.$max.'"');
    }
    else {
        echo false; //return false if type was not passed.
    }
    wp_die();
}

if ( is_admin() ) {
    //add_action( 'wp_ajax_nopriv_pixafy_ajax_check_form_status', 'pixafy_ajax_check_form_status' );
    add_action( 'wp_ajax_pixafy_ajax_check_form_status', 'pixafy_ajax_check_form_status'); //logged in users don't need nopriv
}

function pixafy_check_assesments_closed($http_request,$form_name,$user_id){
    if(isset($_POST['form_name']) && (preg_match('/assessment-form-page-\d/',$form_name) || preg_match('/post-assessment-form-–-page-–-\d/',$form_name)) && $_POST['pix-is_last_page_submit']=='close-access' && !isset($_POST['update_and_exit'])){
        $form_type = _get_assessment_type($_POST);
        if($form_type == "post")
        {
            set_user_role('campus_post_assessment_complete',$user_id);
        }
        else
        {
            set_user_role('campus_assessment_intro_complete',$user_id);
        }
    }
}
add_action('wppb_edit_profile_success','pixafy_check_assesments_closed',10,3);

function pixafy_ends_with($haystack, $needle){
    $length = strlen($needle);
    return $length === 0 || (substr($haystack, -$length) === $needle);
}
add_action('pixafy-string-ends-withs','pixafy_ends_with');

//URL: wp-json/pixafy/feedback/print
//parameters: feedback_ids
function feedback_print(){
    if(strtok($_SERVER["REQUEST_URI"],'?')!='/pixafy/feedback/print'){
        return;
    }
    $post=get_posts( array(
        'post_title' => 'Dashboard – Campus Assessment – Page '.$_GET['page'],
        'post_type' => 'page',
        'status' => 'published',
        'posts_per_page' => 1));
    $post=$post[0];
    $output=do_shortcode('[wppb-edit-profile form_name="assessment-form-page-'.$_GET['page'].'"]');
    echo str_ireplace('<input name="edit_profile" type="submit" id="edit_profile" class="submit button" value="Update">', '',$output);
    exit();
}
add_action('init','feedback_print');

/**
 * Filter the CSS class for a nav menu based on a condition.
 *
 * @param array  $classes The CSS classes that are applied to the menu item's <li> element.
 * @param object $item    The current menu item.
 * @return array (maybe) modified nav menu class.
 */
function pixafy_add_assessment_nav_class( $classes, $item ) {
    //not the best but with the data available on $item it's what I can do quickly
    if ( stripos($item->title, 'assessment') != false ) {
        $classes[] = "pix-assessments_menu_row";
    }
    return $classes;
}
add_filter( 'nav_menu_css_class' , 'pixafy_add_assessment_nav_class' , 10, 2 );
