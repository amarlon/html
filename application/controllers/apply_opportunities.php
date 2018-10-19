<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* load core scripts */
require_once (APPPATH . 'core/Base_Controller.php');

class apply_opportunities extends Base_Controller {


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



    public function apply_for_job() {

        $opportunity_id = $_POST['opportunityId'];
        $msg = $_POST['message'];
        $user_id = $_POST['userId'];
        $sender_name = $_POST['self_name'];
        $opportunity = $this->account_model->get_opportunity($opportunity_id);

        if( $opportunity['user_id'] == $user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'You cannot apply for an opportunity you created. Please contact Hotshi admin for more details.'));
            exit;
        }

        $user = $this->account_model->get_user_details( $opportunity['user_id'] );

        ////////////
        $receiver_id = $opportunity['user_id'];

/*        if( !trim($msg) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a message.'));
            exit;
        }
*/

        $receiver = $this->account_model->get_user_details($receiver_id);

        if( !$receiver || !$receiver['is_active'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Receiver account is no longer active. Sorry about that.'));
            exit;
        }

        $message_map = array(
            'user_a_id' => $user_id,
            'user_b_id' => $receiver_id
        );

        $message = array(
            'description' => nl2br('RE: <b>'.$opportunity['title'].'</b><br><br>'.$msg),
            'sender_user_id' => $user_id,
            'is_seen' => 0
        );

        $message_map_id = $this->account_model->create_message_thread( $message_map, $message );

        if( !$message_map_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem sending message. Try again in a little bit.'));
            exit;
        }

        ///////////

        /*$this->data['email_data'] = array(

            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'receiver_fullname' => $user['fullname'],
            'opportunity_title' => $opportunity['title'],
            'applicant_fullname' => $this->data['user']['fullname'],
            'applicant_id' => $this->data['user']['id']

        ); $this->sendmail('new_opportunity_application', 'New opportunity application on Hotshi.', $this->data);*/

        echo 'success';
        exit;

    }



    public function apply_for_project() {

        $project_id = $_POST['projectId'];
        $msg = $_POST['message'];
        $user_id = $_POST['userId'];
        $sender_name = $_POST['self_name'];
        $project = $this->account_model->get_project($project_id);

        if( $project['user_id'] == $user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'Our record indicates this project currently belongs to you. Please contact Hotshi admin for more details.'));
            exit;
        }

        //$user = $this->account_model->get_user_details( $project['user_id'] );

        ////////////
        $receiver_id = $project['user_id'];

        /*if( !trim($msg) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a message.'));
            exit;
        }*/

        $receiver = $this->account_model->get_user_details($receiver_id);

        if( !$receiver || !$receiver['is_active'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Receiver account is no longer active. Sorry about that.'));
            exit;
        }

        $message_map = array(
            'user_a_id' => $user_id,
            'user_b_id' => $receiver_id
        );

        $message = array(
            'description' => nl2br('RE: <b>'.$project['title'].'</b><br><br>'.$msg),
            'sender_user_id' => $user_id,
            'is_seen' => 0
        );

        $message_map_id = $this->account_model->create_message_thread( $message_map, $message );

        if( !$message_map_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem sending message. Try again in a little bit.'));
            exit;
        }

        ///////////

        $this->data['email_data'] = array(

            'email' => $receiver['email'],
            'firstname' => $receiver['firstname'],
            'receiver_fullname' => $receiver['fullname'],
            'opportunity_title' => $project['title'],
            'applicant_fullname' => $sender_name,
            'applicant_id' => $user_id

        ); $this->sendmail('new_project_proposal', 'Someone likes your project on Hotshi.', $this->data);

        echo 'success';
        exit;

    }




}