<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 30/11/15
 * Time: 9:01 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH . 'core/Base_Controller.php');

class emails extends Base_Controller {

    ///////////////////////////////////////////
    // ADMIN USER ONLY. USE TO TEST EMAILS   //
    ///////////////////////////////////////////

    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();

        if( !$this->is_admin() ) {
            redirect('/');
            exit;
        }

        $this->data['email_data'] = array(

            'email' => 'test@user.com',
            'firstname' => 'Ben'

        );

        $this->data['email_header'] = get_view('layout/header', 'header_email', $this->data);
        $this->data['email_footer'] = get_view('layout/footer', 'footer_email', $this->data);

    }

    // --------------------------------------------------------------------

    public function index() {
        redirect('/');
        exit;
    }

    public function campaign( $campaign_id ) {

        $campaign = $this->account_model->get_campaign( $campaign_id );
        $this->data['email_data']['firstname'] = $this->data['user']['firstname'];

        $this->data['email_header'] = get_view('layout/header', 'header_email', $this->data);
        $this->data['email_footer'] = get_view('layout/footer', 'footer_email', $this->data);

        $this->data['email_title'] = $campaign['subject'];
        $this->data['email_data']['content'] = $campaign['description'];
        $this->data['email_data']['cta_link'] = $campaign['cta_link'];
        $this->data['email_content'] = $this->load->view( 'emails/campaign', $this->data, true );
        $this->load->view('templates/email', $this->data);

    }

    public function get_email( $email ) {

        switch( $email ) {

            case 'admin':
                $this->data['email_title'] = 'Server message...';
                $this->data['email_data']['message'] = 'Message for admin.';
                $this->data['email_content'] = $this->load->view( 'emails/admin', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'welcome':
                $this->data['email_title'] = 'Final step...';
                $this->data['email_data']['activate_token'] = generate_unique_val();
                $this->data['email_content'] = $this->load->view( 'emails/welcome', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'password_reset':
                $this->data['email_title'] = 'Reset your password...';
                $this->data['email_data']['reset_token'] = generate_unique_val();
                $this->data['email_content'] = $this->load->view( 'emails/password_reset', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'comment':
                $this->data['email_title'] = 'New comment...';
                $this->data['email_data']['sender_id'] = '1';
                $this->data['email_data']['sender_fullname'] = 'Jon Doe';
                $this->data['email_data']['post_title'] = 'Some opportunities';
                $this->data['email_data']['post_category_id'] = '1';
                $this->data['email_data']['post_id'] = '2';
                $this->data['email_data']['comment'] = 'This is a test comment.';
                $this->data['email_content'] = $this->load->view( 'emails/comment', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'message':
                $this->data['email_title'] = 'New message...';
                $this->data['email_data']['sender_id'] = '1';
                $this->data['email_data']['sender_fullname'] = 'Jon Doe';
                $this->data['email_data']['message'] = 'This is a test message.';
                $this->data['email_content'] = $this->load->view( 'emails/message', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'certified':
                $this->data['email_title'] = 'Congratulations!';
                $this->data['email_data']['course_title'] = 'Introduction to Java';
                $this->data['email_data']['course_id'] = 1;
                $this->data['email_content'] = $this->load->view( 'emails/certified', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'failed':
                $this->data['email_title'] = 'We\'re sorry';
                $this->data['email_data']['course_title'] = 'Introduction to Java';
                $this->data['email_data']['course_id'] = 1;
                $this->data['email_data']['organisation_id'] = 1;
                $this->data['email_content'] = $this->load->view( 'emails/failed', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'tutor_invitation':
                $this->data['email_title'] = 'Hotshi invitation';
                $this->data['email_data']['organisation_name'] = 'TCD';
                $this->data['email_data']['organisation_id'] = 1;
                $this->data['email_data']['activate_token'] = 'sss333444';
                $this->data['email_content'] = $this->load->view( 'emails/tutor_invitation', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'org_user_added':
                $this->data['email_title'] = 'You were added';
                $this->data['email_data']['organisation_name'] = 'TCD';
                $this->data['email_data']['organisation_id'] = 1;
                $this->data['email_content'] = $this->load->view( 'emails/org_user_added', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'friend_invite':
                $this->data['email_title'] = 'Hotshi Invitation';
                $this->data['email'] = 'newuser@hotshi.com';
                $this->data['email_data']['sender_fullname'] = 'Ben Shittu';
                $this->data['email_content'] = $this->load->view( 'emails/friend_invite', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'new_follower':
                $this->data['email_title'] = 'New follower on Hotshi';
                $this->data['email'] = 'newfollower@hotshi.com';
                $this->data['email_data']['follower_fullname'] = 'Rick Ross';
                $this->data['email_data']['follower_id'] = 88;
                $this->data['email_content'] = $this->load->view( 'emails/new_follower', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

            case 'new_opportunity_application':
                $this->data['email_title'] = 'New opportunity application on Hotshi';
                $this->data['email'] = 'newop@hotshi.com';
                $this->data['email_data']['opportunity_title'] = 'Head of Analytics';
                $this->data['email_data']['applicant_fullname'] = 'Rick Roll';
                $this->data['email_data']['applicant_id'] = 88;
                $this->data['email_content'] = $this->load->view( 'emails/new_opportunity_application', $this->data, true );
                $this->load->view('templates/email', $this->data);
                break;

        }

    }
}