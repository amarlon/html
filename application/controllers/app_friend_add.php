<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 16/11/15
 * Time: 11:58 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load core scripts */
require_once (APPPATH . 'core/Base_Controller.php');

class app_friend_add extends Base_Controller {


    ////////////////////////////////////////////////////////
    // HANDLE AJAX CALLS IN RELATION TO USER ACCOUNTS     //
    ////////////////////////////////////////////////////////

    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();

        if( !$this->is_logged_in() ) {
              
        }
}


        public function friend_add_action() {

        $user_id = $_POST['userId'];
        $sender_name = $_POST['name'];        
        $msg = $sender_name.' just added you to his contacts';
        $receiver_id = $_POST['destId'];

        $receiver = $this->account_model->get_user_details($receiver_id);
        if( !$receiver || !$receiver['is_active'] ) {
            //echo json_encode(array('status' => 'error', 'message' => 'User account is no longer active.'));
            echo 'Invalid receiver or user account is no longer active';
            exit;
        }


        $message_map = array(
            'user_a_id' => $user_id,
            'user_b_id' => $receiver_id
        );

        $message = array(
            'description' => nl2br($msg),
            'sender_user_id' => $user_id,
            'is_seen' => 0
        );


        $message_map_id = $this->account_model->create_message_thread($message_map,$message);

                if( !$message_map_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem sending message. Try again in a little bit.'));
            exit;
        }

        echo "success";

        /* notify user by email */
        $this->data['email_data'] = array(
            'email' => $receiver['email'],
            'firstname' => $receiver['firstname'],
            'receiver_fullname' => $receiver['fullname'],
            'sender_fullname' => $sender_name,
            'sender_id' => $user_id,
            'message' => $message['description']

        ); $this->sendmail('message', 'New message', $this->data);

        $this->send_android_push_notification($receiver, $sender_name, $msg );

        exit;

}                





}



