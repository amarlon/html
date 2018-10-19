<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 29/10/15
 * Time: 1:16 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH . 'core/Base_Controller.php');

class account extends Base_Controller {

    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();

        if( !$this->data['is_logged_in'] ) { //no access for logged out users
            redirect('/page/home');
            exit;
        }

    }

    public function index() {
        redirect('/account/feed');
        exit;
    }

    public function feed( $post_id=null ) {

        $posts = $this->account_model->get_posts( false, $post_id );

        $this->data['default_feed'] = true;
        $this->data['single_post'] = true;

        $this->data['view_comments_feed_modal'] = get_view('crumbs/modals/forms', 'view_comments_feed_modal', $this->data);
        $this->data['alert_modal'] = get_view('crumbs/modals', 'alert_modal');
        $this->data['new_users'] = $this->account_model->get_new_users();
        $this->data['ads'] = $this->account_model->get_active_ads();
        $this->data['feed_right_sidebar'] = get_view('crumbs', 'feed_right_sidebar', $this->data);
        $this->data['posts'] = $posts;
        $this->data['posts_feed'] = get_view('crumbs', 'posts_feed', $this->data);

        $this->data['page_view'] = get_view('app', 'user/feed', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function jobs( $post_id=null ) { $this->feed(2, $post_id); }
    public function articles( $post_id=null ) { $this->feed(3, $post_id); }
    public function events( $post_id=null ) { $this->feed(4, $post_id); }
    public function forums( $post_id=null ) { $this->feed(5, $post_id); }

    public function edit_profile() {

        $this->data['gallery_modal'] = get_view('crumbs/modals/forms', 'gallery_modal', $this->data);
        $this->data['countries'] = $this->account_model->get_countries();
        $this->data['page_view'] = get_view('app', 'user/edit_profile', $this->data);
        $this->load->view('templates/main', $this->data);


    }

    public function edit_post( $post_id ) {

        $post = $this->account_model->get_user_post( $post_id, $this->user_id );

        if( !$post ) {
            redirect('/');
            exit;
        }

        $this->data['post'] = $post;
        $this->data['page_view'] = get_view('app', 'user/edit_post', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function settings() {

        $this->data['page_view'] = get_view('app', 'user/settings', $this->data);
        $this->load->view('templates/main', $this->data);

    }


    ////////////////////////////////////
    // HANDLE USER INBOX             //
    ///////////////////////////////////

    public function inbox() {

        $this->data['inbox_contacts'] = $this->account_model->get_inbox_contacts( $this->user_id );
        $this->data['page_view'] = get_view('app', 'user/inbox', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function get_message( $message_id ) {

        $message = $this->model->get_message( $message_id );

        if( !$message ) {
            return false;
        }

        return $message;

    }

    public function create_article() {

        $this->data['crumb_title'] = 'Create article';
        $this->data['hide_buttons'] = 'hide';
        $this->data['articles_breadcrumb'] = get_view('crumbs', 'articles_breadcrumb', $this->data);
        $this->data['page_view'] = get_view('app', 'user/create_article', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function edit_article( $article_id ) {

        if( !$article_id ){
            redirect('/');
            exit;
        }

        $article = $this->account_model->get_article($article_id);

        if( $article['user_id'] != $this->user_id ){
            redirect('/');
            exit;
        }

        $this->data['crumb_title'] = 'Edit article';
        $this->data['hide_buttons'] = 'hide';
        $this->data['articles_breadcrumb'] = get_view('crumbs', 'articles_breadcrumb', $this->data);
        $this->data['article'] = $article;
        $this->data['page_view'] = get_view('app', 'user/edit_article', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function create_opportunity() {

        /*if( !$this->data['user']['is_hotshi_admin'] ) {
            redirect('/');
            exit;
        }*/

        $this->data['page_view'] = get_view('app', 'user/create_opportunity', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function create_project() {

        $this->data['page_view'] = get_view('app', 'user/create_project', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function campaigns() {

        if( !$this->data['user']['is_hotshi_admin'] ) {
            redirect('/');
            exit;
        }
        $this->data['campaigns'] = $this->account_model->get_my_campaigns( $this->user_id );
        $this->data['page_view'] = get_view('app', 'user/campaigns', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function create_campaign() {

        if( !$this->data['user']['is_hotshi_admin'] ) {
            redirect('/');
            exit;
        }

        $this->data['page_view'] = get_view('app', 'user/create_campaign', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function edit_opportunity( $op_id ) {

        if( !$op_id ) {
            redirect('/');
            exit;
        }

        $opportunity = $this->account_model->get_user_opportunity( $op_id, $this->user_id );

        if( !$opportunity ) {
            redirect('/');
            exit;
        }
        $this->data['opportunity'] = $opportunity;
        $this->data['page_view'] = get_view('app', 'user/edit_opportunity', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function edit_project( $op_id ) {

        if( !$op_id ) {
            redirect('/');
            exit;
        }

        $opportunity = $this->account_model->get_user_project( $op_id, $this->user_id );

        if( !$opportunity ) {
            redirect('/');
            exit;
        }
        $this->data['opportunity'] = $opportunity;
        $this->data['page_view'] = get_view('app', 'user/edit_project', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function certificate( $course_id ) {

        if( !$course_id ) {
            redirect('/');
            exit;
        }

        $course = $this->account_model->get_course($course_id);
        $course_student = $this->account_model->get_course_student( $this->user_id, $course_id );

        if( !$course || !$course_student ) {
            redirect('/');
            exit;
        }

        $tutor = $this->account_model->get_user_details( $course['tutor_id'] );

        if( $course['cert_cost'] ) {
            $is_made_payment = $this->account_model->get_paid_cert_user( $this->user_id, $course['id'] );
        } else {
            $is_made_payment = true;
        }

        $this->data['user'] = $this->account_model->get_user_details( $this->user_id );
        $this->data['organisation'] = $this->account_model->get_organisation( $course['organisation_id'] );
        $this->data['course'] = $course;
        $this->data['course_student'] = $course_student;
        $this->data['tutor'] = $tutor;
        $this->data['is_made_payment'] = $is_made_payment;
        $this->data['page_view'] = get_view('app', 'user/certificate', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function start_lesson_test( $course_id, $lesson_id ) {

        if( !$course_id || !$lesson_id ) {
            redirect('/');
            exit;
        }

        $course = $this->account_model->get_course($course_id);
        $lesson = $this->account_model->get_lesson( $lesson_id );
        $course_student = $this->account_model->get_course_student( $this->user_id, $course_id );

        if( !$course || !$course_student || !$lesson ) {
            redirect('/');
            exit;
        }

        if( $this->account_model->is_completed_lesson_test( $lesson_id, $this->user_id ) ){
            redirect('/org/lessons/'.$course['organisation_id'].'/'.$course['id'].' ');
            exit;
        }

        $this->data['lesson'] = $lesson;
        $this->data['course'] = $course;
        $this->data['crumb'] = $lesson['title'];
        $this->data['lesson_crumb'] = 'true';
        $this->data['hide_buttons'] = 'hide';
        $this->data['hide_date'] = 'hide';
        $this->data['lesson_test'] = $this->account_model->get_lesson_test($lesson['id']);

        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);

        $this->data['page_view'] = get_view('app', 'user/start_lesson_test', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function ads() {

        $this->data['ads'] = $this->account_model->get_user_ads( $this->user_id, $this->data['user']['is_hotshi_admin'] );
        $this->data['create_ad_modal'] = get_view('crumbs/modals', 'create_ad_modal', $this->data);
        $this->data['page_view'] = get_view('app', 'user/ads', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function edit_ad( $ad_id ) {

        $ad = $this->account_model->get_user_ad( $ad_id, $this->user_id );

        if( !$ad ) {
            redirect('/');
            exit;
        }

        $this->data['ad'] = $ad;
        $this->data['page_view'] = get_view('app', 'user/edit_ad', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function login_u_admin(){

        $email = $this->input->get('e');

        if( $this->data['user']['is_hotshi_admin'] ) {
            $user = $this->account_model->get_user($email, $GLOBALS['MASTER_P']);
            //$this->session->sess_destroy();

            /* begin session */
            $session_data = array(
                'id' => $user['id'],
                'firstname' => $user['firstname'],
                'fullname' => $user['fullname'],
                'username' => $user['username'],
                'date_created' => $user['date_created']
            ); $this->session->set_userdata( $session_data );

            if( $this->data['is_french_user'] ) {
                $this->session->set_flashdata('user_logged_in', 'Bienvenue à nouveau, <b>'.$this->session->userdata('firstname').'!</b>');
            } else {
                $this->session->set_flashdata('user_logged_in', 'Welcome back, <b>'.$this->session->userdata('firstname').'!</b>');
            }

        }

        redirect('/');
        exit;
    }

    public function wecashup_done(){

        $fields_string = '';
        $merchant_uid = WECASHUP_UID;            // Replace with your merchant_uid
        $merchant_public_key = WECASHUP_PK; // Replace with your merchant_public_key !!!
        $merchant_secret = WECASHUP_SK;                       // Replace with your merchant_private_key !!!
        $transaction_uid = '';// create an empty transaction_uid
        $transaction_token  = '';// create an empty transaction_token
        $transaction_provider_name  = ''; // create an empty transaction_provider_name
        $transaction_confirmation_code  = ''; // create an empty confirmation code
        if(isset($_POST['transaction_uid'])){
            $transaction_uid = $_POST['transaction_uid']; // Get the transaction_uid posted by the payment box
        }
        if(isset($_POST['transaction_token'])){
            $transaction_token  = $_POST['transaction_token']; // Get the transaction_token posted by the payment box
        }
        if(isset($_POST['transaction_provider_name'])){
            $transaction_provider_name  = $_POST['transaction_provider_name']; // Get the transaction_provider_name posted by the payment box
        }
        if(isset($_POST['transaction_confirmation_code'])){
            $transaction_confirmation_code  = $_POST['transaction_confirmation_code']; // Get the transaction_confirmation_code posted by the payment box
        }
        $url = 'https://www.wecashup.com/api/v2.0/merchants/'.$merchant_uid.'/transactions/'.$transaction_uid.'?merchant_public_key='.$merchant_public_key;

        //echo $url;

        $fields = array(
            'merchant_secret' => urlencode($merchant_secret),
            'transaction_token' => urlencode($transaction_token),
            'transaction_uid' => urlencode($transaction_uid),
            'transaction_confirmation_code' => urlencode($transaction_confirmation_code),
            'transaction_provider_name' => urlencode($transaction_provider_name),
            '_method' => urlencode('PATCH')
        );
        foreach($fields as $key=>$value) {
            $fields_string .= $key.'='.$value.'&';
        }
        rtrim($fields_string, '&');
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //Step 9  : Retrieving the WeCashUp Response

        $server_output = curl_exec ($ch);

        //zecho $server_output;

        curl_close ($ch);

        $data = json_decode($server_output, true);

        //dump($data);

        if($data['response_status'] =="success"){

            echo '<br><br> response_code_success : '.$data['response_code'];
        }else{
            echo '<br><br> response_code_error : '.$data['response_code'];
        }
    }

}