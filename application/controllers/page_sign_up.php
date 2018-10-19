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

class page_sign_up extends Base_Controller {


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
            //redirect('/');
            exit;

        }

    }
    

    // --------------------------------------------------------------------

    /*
     * Start session: Sign up new user, and create session upon successful signup
     */
    public function sign_up() {
        
        $fullname = $_POST['fullname'];
        $email = trim($_POST['email']);

echo $email;
        //$is_fb = false;
    /*    
        $fullname = $_POST['fullname'];
        $email = trim($_POST['email']);

        $image = null;
        $is_fb_user = 0;
        $is_verified = 0;
        $password = '';
        $e_password = null;
        $fb_user_id = '';
        $is_organisation_user = $_POST['is_organisation_user'];
        $username = $_POST['fullname'];
        $password = $_POST['password'];
        $e_password = $this->encrypt($password);

        if( $GLOBALS['SERVER'] == 'dev' ) {
            $is_verified = 1;
        }

        if (strpos(strtolower($username),'hotshi') !== false) {
            echo json_encode(array('status' => 'error', 'message' => 'Your username cannot contain the word <b>hotshi</b>.'));
            exit;
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


            $last_login = date('Y-m-d H:i:s');
            $country_id = 0; //Column in DB uses FK with no constraints - the only exception. Users can later select their country in settings
            $notify_email_comments = 1;
            $notify_email_on_follow = 1;
            $notify_email_newsletter = 1;
            $is_active = 1;


        $sql = "INSERT INTO users(fullname,firstname,email,username,password,last_login,country_id,notify_email_comments,notify_email_on_follow,notify_email_newsletter,is_active,image,is_verified,is_fb_user,is_organisation_user,fb_id) VALUES ('$fullname','$firstname','$email','$username','$e_password','$last_login','$country_id','$notify_email_comments','$notify_email_on_follow','$notify_email_newsletter','$is_active','$image','$is_verified','$is_fb_user','$is_organisation_user','$fb_id')";


        if (!($db->query($sql))) {
            echo json_encode(array('status' => 'error', 'message' => 'An error occurred while creating your account. Try again in a little bit.'));
    }

    else{
            echo "success";
        }
*/


}

}