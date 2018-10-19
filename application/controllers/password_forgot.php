<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load core scripts */
require_once (APPPATH . 'core/Base_Controller.php');

class password_forgot extends Base_Controller {


	   public function __construct() {

        parent::__construct ();
        if( !$this->is_logged_in() ) {
        }

    }


   public function forgot_password() {

        $email = $_POST['email'];

        if( !$this->account_model->exists_email($email) ) {
            echo "Unable to locate account under that email address.";
            exit;
        }

        if( !valid_email( $email ) ) {
            echo "Enter a valid email.";
            exit;
        }

        $user = $this->account_model->get_user( $email, $GLOBALS['MASTER_P'] );
        $token = generate_unique_val();

        $data = array(
            'email' => $email,
            'token' => $token
        );

        if( !$this->account_model->forgot_password( $data ) ) {
            echo "Oops! We\'re having some technical difficulties. Try again in a little bit.";
            exit;
        }

        $this->data['email_data'] = array(

            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'receiver_fullname' => $user['fullname'],
            'reset_token' => $token

        ); $this->sendmail('password_reset_app', 'Reset your '.ucfirst($GLOBALS['COMPANY_NAME']).' password', $this->data);

        echo "success";
        exit;

    }





}