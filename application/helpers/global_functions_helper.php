<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 29/11/14
 * Time: 19:31
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('generateUniqueVal')) {

    function generate_unique_val() {
        $val = uniqid(rand(), true);
        $val .= uniqid(rand(), true);
        return $val;
    }
}//end if

if(!function_exists('dump')) {
    function dump($array) {
        echo '<pre>';
        print_r($array);
        echo '</pre>';
    }
}

if(!function_exists('mysql_date')) {

    /* pass in str format - DD-MM-YYYY */
    function mysql_date($str) {
        $timestamp = strtotime($str);
        return date("Y-m-d", $timestamp);
    }
}

if(!function_exists('eu_date_format')) {

    /* pass in str format - YYYY-MM-DD */
    function eu_date_format($str) {
        $timestamp = strtotime($str);
        return date("d-m-Y", $timestamp);
    }
}

if(!function_exists('mysql_date_time')) {

    /* str format - DD-MM-YYYY */
    function mysql_date_time($str) {
        $timestamp = strtotime($str);
        return date("Y-m-d H:i:s", $timestamp);
    }
}

if(!function_exists('n_days_left')) {

    function n_days_left($date){
        return (isset($date)) ? floor((strtotime($date) - time())/60/60/24) : FALSE;
    }

}

if(!function_exists('time_elapsed_string')) {

    function time_elapsed_string($timestamp){
        //type cast, current time, difference in timestamps
        $timestamp      = (int) $timestamp;
        $current_time   = time();
        $diff           = $current_time - $timestamp;

        //intervals in seconds
        $intervals      = array (
            'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
        );

        //now we just find the difference
        if ($diff == 0)
        {
            return 'just now';
        }

        if ($diff < 60)
        {
            return $diff == 1 ? $diff . ' sec' : $diff . ' secs';
        }

        if ($diff >= 60 && $diff < $intervals['hour'])
        {
            $diff = floor($diff/$intervals['minute']);
            return $diff == 1 ? $diff . ' min' : $diff . ' mins';
        }

        if ($diff >= $intervals['hour'] && $diff < $intervals['day'])
        {
            $diff = floor($diff/$intervals['hour']);
            return $diff == 1 ? $diff . ' hr' : $diff . ' hrs';
        }

        if ($diff >= $intervals['day'] && $diff < $intervals['week'])
        {
            $diff = floor($diff/$intervals['day']);
            return $diff == 1 ? $diff . ' day' : $diff . ' days';
        }

        if ($diff >= $intervals['week'] && $diff < $intervals['month'])
        {
            $diff = floor($diff/$intervals['week']);
            return $diff == 1 ? $diff . ' wk' : $diff . ' wks';
        }

        if ($diff >= $intervals['month'] && $diff < $intervals['year'])
        {
            $diff = floor($diff/$intervals['month']);
            return $diff == 1 ? $diff . ' month' : $diff . ' months';
        }

        if ($diff >= $intervals['year'])
        {
            $diff = floor($diff/$intervals['year']);
            return $diff == 1 ? $diff . ' yr' : $diff . ' yrs';
        }
    }

}//end if

if(!function_exists('isLocalServer')) {

    function isLocalServer() {
        $whitelist = array('127.0.0.1', '::1');
        if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            return true;
        }

        return false;
    }

}

if(!function_exists('is_mobile_device')) {

    function is_mobile_device(){

        require_once (APPPATH . 'libraries/Mobile_Detect.php');
        $detect = new Mobile_Detect;

        if( $detect->isTablet() || $detect->isMobile() ) {
            return true;
        }

        return false;

    }

}

if(!function_exists('get_css')) {

    function get_css( $filename, $data=null ){
        $CI =& get_instance();
        $css_path = 'layout/include/css/';
        if( !file_exists(APPPATH.'views/'.$css_path.$filename.'.php') ) {
            return '';
        }
        return $CI->load->view($css_path.$filename, $data, true);
    }

}

if(!function_exists('get_js')) {

    function get_js( $filename, $data=null ){
        $CI =& get_instance();
        $js_path = 'layout/include/js/';
        if( !file_exists(APPPATH.'views/'.$js_path.$filename.'.php') ) {
            return '';
        }
        return $CI->load->view($js_path.$filename, $data, true);
    }

}

if(!function_exists('get_nav')) {

    function get_nav( $filename, $data=null ){
        $CI =& get_instance();
        return $CI->load->view('layout/nav/'.$filename, $data, true);
    }

}

if(!function_exists('get_view')) {

    function get_view($path, $filename, $data=null ){
        $CI =& get_instance();
        return $CI->load->view($path.'/'.$filename, $data, true);
    }

}

if(!function_exists('is_super_admin')) {

    function is_super_admin(){
        $CI =& get_instance();
        return $CI->session->userdata('is_super_admin');
    }

}

if(!function_exists('is_sponsor_admin')) {

    function is_sponsor_admin(){
        $CI =& get_instance();
        return $CI->session->userdata('is_sponsor_admin');
    }

}

if(!function_exists('limit_str')) {

    function limit_str( $str, $max, $min ){

        $string = (strlen($str) > $max) ? substr($str,0,$min).'...' : $str;

        return $string;

    }
}

if(!function_exists('decimal')) {

    //returns number to x decimal places
    function decimal( $trail, $num ){

        return number_format((float)$num, $trail, '.', '');

    }
}

if(!function_exists('curr_url')) {

    function curr_url() {
        $CI =& get_instance();
        $url = $CI->config->site_url($CI->uri->uri_string());
        return $_SERVER['QUERY_STRING'] ? $url.'?'.$_SERVER['QUERY_STRING'] : $url;
    }
}

if(!function_exists('stripe_charge')) {

    function stripe_charge( $amount ) {
        return floatval(decimal(2, (($GLOBALS['STRIPE_PERCENT_CHARGE']/100) * $amount) + $GLOBALS['STRIPE_CENTS_CHARGE']));
    }
}

if(!function_exists('reject_empty')) {

    function reject_empty( $field, $fieldname ) {

        if( !trim($field) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a valid '.$fieldname.'.'));
            exit;
        }

    }
}

if(!function_exists('get_default_avatar')) {

    function get_default_avatar() {

        return '/assets/global/img/default-avatar.jpg';

    }
}

if(!function_exists('get_default_org_avatar')) {

    function get_default_org_avatar() {

        return '/assets/global/img/default-org-avatar.jpg';

    }
}

if(!function_exists('get_default_post_img')) {

    function get_default_post_img() {

        return '/assets/global/img/default-post-img.jpg';

    }
}

if(!function_exists('get_default_opportunity_img')) {

    function get_default_opportunity_img() {

        return '/assets/global/img/default-opportunity-img.jpg';

    }
}