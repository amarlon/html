<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 29/11/14
 * Time: 19:07
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load core scripts */
require_once (APPPATH . 'core/Base_Controller.php');

/* load FB libraries */
require_once( APPPATH . 'libraries/Facebook/autoload.php' );

class auth extends Base_Controller {


    ////////////////////////////////////////////////////////
    // HANDLE AJAX CALLS IN RELATION TO USER ACCOUNTS     //
    ////////////////////////////////////////////////////////


    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();

        if( !$this->input->is_ajax_request() ){

            echo json_encode( array('status' => 'error', 'message' => 'Bad request') );
            redirect('/');
            exit;

        }

    }

    // --------------------------------------------------------------------

    /*
     * Start session: Sign up new user, and create session upon successful signup
     */
    public function signup( $is_fb=null ) {

        //$is_fb = false;

        $fullname = $this->input->post('fullname');
        $email = trim($this->input->post('email'));

        $image = null;
        $is_fb_user = 0;
        $is_verified = 0;
        $password = '';
        $e_password = null;
        $fb_user_id = '';
        $is_organisation_user = $this->input->post('is_organisation_user');
        $username = $this->input->post('username');

        if( $is_organisation_user ) {
            $fullname = $username;
        }

        if( $GLOBALS['SERVER'] == 'dev' ) {
            $is_verified = 1;
        }

        if (strpos(strtolower($username),'hotshi') !== false) {
            echo json_encode(array('status' => 'error', 'message' => 'Your username cannot contain the word <b>hotshi</b>.'));
            exit;
        }

        if( $is_fb ) {


            $fb_token = $this->input->post('fb_access_token');

            try {

                $fb = new \Facebook\Facebook([
                    'app_id' => $GLOBALS['FB_APP_ID_PUB'],
                    'app_secret' => $GLOBALS['FB_APP_ID_SEC'],
                    'default_graph_version' => 'v2.4'
                    //'default_graph_version' => 'v2.10'
                ]);
                $response = $fb->get('/me?fields=id,name,email', $fb_token );
                $me = $response->getGraphUser();
                $fullname = $me->getName();
                $email = $me->getEmail();
                $fb_user_id = $me->getId();
                $fb_image = 'https://graph.facebook.com/'.$fb_user_id.'/picture?type=large';

                if( !$email ) {
                    echo json_encode(array('status' => 'error', 'message' => 'Error. Unable to access your Facebook email. Please use regular login/signup, or try again shortly.'));
                    exit;
                }

                /*echo 'Yes!!!!! - '.$me->getEmail();
                exit;*/


                $user = $this->account_model->get_user($email, $GLOBALS['MASTER_P']);

                if( $user ) { //login, and begin session
                    $session_data = array(
                        'id' => $user['id'],
                        'firstname' => $user['firstname'],
                        'fullname' => $user['fullname'],
                        'username' => $user['username'],
                        'date_created' => $user['date_created']
                    ); $this->session->set_userdata( $session_data );

                    $this->session->set_flashdata('user_logged_in', 'Welcome back, <b>'.$this->session->userdata('firstname').'!</b>');

                    //get latest fb profile photo
                    $this->account_model->update_details(array( 'image' => $fb_image, 'last_login' => date('Y-m-d H:i:s') ), $user['id']);

                    $response = array('status' => 'success');
                    echo json_encode( $response );
                    exit;

                } else {

                    //proceed signup and begin session.
                    $image = $fb_image;
                    $is_fb_user = 1;
                    $is_verified = 1;
                    $password = $fb_token;
                    $e_password = $fb_token; //access token

                }

            } catch(\Facebook\Exceptions\FacebookResponseException $e) {
                // When Graph returns an error
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(\Facebook\Exceptions\FacebookSDKException $e) {
                // When validation fails or other local issues
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }


        } else {
            $password = $this->input->post('password');
            $e_password = $this->encrypt($password);
        }

        if( $is_organisation_user ) {
            $firstname = $username;
        } else {
            $firstname = explode(' ', $fullname);
            $firstname = $firstname[0];
        }

        $data = array(
            'fullname' => $fullname,
            'firstname' => $firstname,
            'email' => trim($email),
            'username' => $username,
            'password' => $e_password,
            'last_login' => date('Y-m-d H:i:s'),
            'country_id' => 0, //Column in DB uses FK with no constraints - the only exception. Users can later select their country in settings
            'notify_email_comments' => 1,
            'notify_email_on_follow' => 1,
            'notify_email_newsletter' => 1,
            'is_active' => 1,
            'image' => $image,
            'is_verified' => $is_verified,
            'is_fb_user' => $is_fb_user,
            'is_organisation_user' => $is_organisation_user,
            'fb_id' => $fb_user_id

        );

        if( !valid_email( $data['email'] ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a valid email.'));
            exit;
        }

        if (strpos(strtolower($data['email']), 'hotshi') !== false) {
            echo json_encode(array('status' => 'error', 'message' => 'Email at Hotshi not allowed.'));
            exit;
        }

        if (strpos(strtolower($data['fullname']), '@') !== false) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a valid full name.'));
            exit;
        }

        if( $this->account_model->exists_email($data['email']) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Yikes! Email address already in use.'));
            exit;
        }

        if( $data['is_organisation_user'] && !trim($data['username']) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a username.'));
            exit;
        }

        if( $data['is_organisation_user'] && $this->account_model->exists_username($data['username']) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Yikes! Username already in use.'));
            exit;
        }

        if( strlen( $password ) < 5 ) {
            if( $this->data['is_french_user'] ) {
                echo json_encode(array('status' => 'error', 'message' => 'Choisissez un mot de passe fort (fiable)'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Weak password. Pick a stronger one.'));
            }

            exit;
        }

        $invitation_token = $this->input->post('invitation_token');
        $invited_user = $this->account_model->get_tutor_invitation_token( $invitation_token );

        if( $invited_user ) {
            $data['is_verified'] = 1;
        }

        $user_id = $this->account_model->signup( $data );

        if( !$user_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'An error occurred while creating your account. Try again in a little bit.'));
            exit;
        }

        $this->create_vanity_url($user_id);

        if( $invited_user ) {

            //add user to organisation that invited them
            $data_invited_user = array(
                'organisation_id' => $invited_user['organisation_id'],
                'user_id' => $user_id,
                'is_organisation_admin' => 0
            );

            $this->account_model->add_organisation_user( $data_invited_user );

        }

        if( $is_organisation_user ) {

            //create organisation account
            $org = array(
                'name' => $data['username'],
                'is_active' => 1
            );

            $organisation_id = $this->account_model->create_organisation( $org );

            $tut = array(
                'organisation_id' => $organisation_id,
                'user_id' => $user_id,
                'is_organisation_admin' => 1
            );

            $tutor_id = $this->account_model->create_tutor( $tut );

        }

        /* begin session */
        $session_data = array(
            'id' => $user_id,
            'firstname' => $firstname,
            'fullname' => $data['fullname'],
            'username' => $data['username']
        ); $this->session->set_userdata( $session_data );

        if( $is_fb || $invited_user ) {
            if( $this->data['is_french_user'] ) {
                $this->session->set_flashdata('user_created', 'Bienvenue, <b>'.$this->session->userdata('firstname').'!</b>');
            } else {
                $this->session->set_flashdata('user_created', 'Welcome, <b>'.$this->session->userdata('firstname').'!</b>');
            }
        } else {
            if( $this->data['is_french_user'] ) {
                $this->session->set_flashdata('user_created', 'Bienvenue, <b>'.$this->session->userdata('firstname').'!</b> Nous vous avons envoyé un courrier électronique d\'activation. Veuillez vérifier votre adresse e-mail.');
            } else {
                $this->session->set_flashdata('user_created', 'Welcome, <b>'.$this->session->userdata('firstname').'!</b> We\'ve sent you an activation email. Please verify your email address.');
            }
        }

        $this->session->keep_flashdata('message');

        $response = array('status' => 'success', 'redirect' => '/account/feed');
        echo json_encode( $response );

        if( $is_fb ) {

            //$this->add_log($user_id, 'Signed up via Facebook.');

        } else {

            /* send welcome email */
            $token = generate_unique_val();
            $this->data['email_data'] = array(

                'email' => $data['email'],
                'firstname' => $data['firstname'],
                'receiver_fullname' => $data['fullname'],
                'activate_token' => $token

            ); $this->sendmail('welcome', 'Welcome to '.ucfirst($GLOBALS['COMPANY_NAME']).'', $this->data);

            $this->account_model->add_email_verification_token( $user_id, $token );

        }

        /* notify admin */
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'page/profile/'.$user_id.'">'.$data['fullname'].'</a> just joined.'
        ); $this->send_admin_email('New User', $this->data);


    }

    // --------------------------------------------------------------------

    /*
     * Handle login form
     */
    public function login() {

        $this->load->library('form_validation');

        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_get_user['. $this->input->post('password') .']');

        if( $this->form_validation->run() === false ) {
            $response = array('status' => 'error', 'message' => 'Email or password incorrect.');
        } else {
            $response = array('status' => 'success', 'redirect' => '/account/feed');
        }

        echo json_encode( $response );
        exit;

    }

    // --------------------------------------------------------------------

    /*
     * login callback: Get user details, and create session upon successful login
     */
    public function get_user($email, $password, $is_fb=null){

        $e_password = $password == $GLOBALS['MASTER_P'] ? $GLOBALS['MASTER_P'] : $password;
        $user = $this->account_model->get_user($email, $e_password);

        if(!$user){

            $this->form_validation->set_message(__FUNCTION__,'Email and/or password are incorrect.');
            return false;

        }

        if(!$user['is_active']){

            $this->form_validation->set_message(__FUNCTION__, ACC_DISABLED_MSG);
            return false;

        }

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

        $this->account_model->update_details(array('last_login' => date('Y-m-d H:i:s')), $user['id']);

        return true;
    }


    public function get_fb_user($fb_id, $password){

        $user = $this->account_model->get_fb_user($fb_id, $password);

        if(!$user){
            echo json_encode( array('status' => 'error', 'message' => 'Login error. Try again in a little bit, or contact help@hotshi.com') );
            exit;
        }

        if(!$user['is_active']){
            echo json_encode( array('status' => 'error', 'message' => ACC_DISABLED_MSG) );
            exit;
        }

        /* begin session */
        $session_data = array(
            'id' => $user['id'],
            'firstname' => $user['firstname'],
            'fullname' => $user['fullname'],
            'username' => $user['username'],
            'date_created' => $user['date_created']
        ); $this->session->set_userdata( $session_data );

        $this->session->set_flashdata('user_logged_in', 'Welcome back, <b>'.$this->session->userdata('firstname').'!</b>');

        //get latest fb profile photo
        $fb_image = 'https://graph.facebook.com/'.$fb_id.'/picture?type=large';
        $this->account_model->update_details(array( 'image' => $fb_image, 'last_login' => date('Y-m-d H:i:s') ), $user['id']);

        $response = array('status' => 'success', 'redirect' => '/account/feed');
        echo json_encode( $response );

        exit;
    }

    // --------------------------------------------------------------------
    public function get_cities_counties() {

        $cities_counties = $this->account_model->get_cities_counties();
        echo json_encode( $cities_counties );

    }

    // --------------------------------------------------------------------
    public function get_city_county_areas() {

        $city_county_id = $this->input->post('city_county_id');
        $areas = $this->account_model->get_city_county_areas( $city_county_id );
        echo json_encode( $areas );

    }

    public function exists_fb_id() {

        $fb_id = $this->input->post('fb_id');
        $fb_image = 'https://graph.facebook.com/'.$fb_id.'/picture?type=large';
        $exists = $this->account_model->exists_fb_id( $fb_id );

        if( $exists ) {
            echo json_encode(array('exists_fb_id' => true));
        } else {
            echo json_encode(array('exists_fb_id' => false, 'fb_image' =>  $fb_image));
        }

    }

    public function forgot_password() {

        $email = $this->input->post('email');

        if( !$this->account_model->exists_email($email) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Unable to locate account under that email address.'));
            exit;
        }

        if( !valid_email( $email ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Enter a valid email.'));
            exit;
        }

        $user = $this->account_model->get_user( $email, $GLOBALS['MASTER_P'] );
        $token = generate_unique_val();

        $data = array(
            'email' => $email,
            'token' => $token
        );

        if( !$this->account_model->forgot_password( $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! We\'re having some technical difficulties. Try again in a little bit.'));
            exit;
        }

        $this->data['email_data'] = array(

            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'receiver_fullname' => $user['fullname'],
            'reset_token' => $token

        ); $this->sendmail('password_reset', 'Reset your '.ucfirst($GLOBALS['COMPANY_NAME']).' password', $this->data);

        echo json_encode(array('status' => 'ok', 'hideform' => 'true', 'message' => 'An email is on its way to you. Please check your email inbox.'));
        exit;

    }

    public function reset_password() {

        $token = $this->input->post('reset_token');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');

        if( $password != $password_confirm ) {
            echo json_encode(array('status' => 'error', 'message' => 'The password confirm field does not match your new password.'));
            exit;
        }

        $result = $this->account_model->get_password_reset_token( $token );

        if( !$result ) { //will only execute if someone is trying to hack the frontend
            echo json_encode(array('status' => 'error', 'message' => 'Server error. Try again in a little bit.'));
            exit;
        }

        if( !$this->account_model->reset_password( $result['email'], $this->encrypt($password) ) ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Something went wrong. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Your password has been reset. <a href="/page/login">Login</a> '));

    }

    public function search_users_dynamic() {
        $query = $this->input->post('query');
        $users = $this->account_model->get_users_dynamic($query);
        if( $users ) {
            echo json_encode(array('status' => 'success', 'users' => $users));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No results'));
        }

    }

}