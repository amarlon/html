<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 29/11/14
 * Time: 19:14
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'config/hotshi.php' );
require_once( APPPATH . 'libraries/phpmailer/Email.php');

require_once( APPPATH . 'libraries/cloudinary2/Cloudinary.php');
require_once( APPPATH . 'libraries/cloudinary2/Uploader.php');
require_once( APPPATH . 'libraries/cloudinary2/Api.php');
require_once( APPPATH . 'libraries/stripe/lib/Stripe.php');

class Base_Controller extends CI_Controller {

    public $data = array();
    public $user_id;

    /* declare constructor to initialize */
    public function __construct() {

        parent::__construct ();

        date_default_timezone_set('Europe/Dublin');

        \Cloudinary::config(array(
            "cloud_name" => "hotshi",
            "api_key" => "799482993175479",
            "api_secret" => "8rrprwB6OJsJbBgctUOQpFyOTb4"
        ));

        $this->user_id = $this->session->userdata('id');

        $this->load->model('account_model');
        $this->load->model('analytics_model');

        //user data. always $this user, but can be overridden by extended controllers
        $this->data['user'] = $this->account_model->get_user_details( $this->user_id );
        $this->data['thisuser'] = $this->data['user']; //copy it here for when user array gets overridden in other controllers, then we can use "thisuser"
        $this->data['invite_friends_modal'] = get_view('crumbs/modals/forms', 'invite_friends_modal', $this->data);

        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
        $this->data['is_french_user'] = false;
        if( isset($_COOKIE['user_lang'])  ) {
            if( $_COOKIE['user_lang'] == 'fr' ) {
                $this->data['is_french_user'] = true;
            } else {
                $this->data['is_french_user'] = false;
            }
        } else if( $lang == 'fr' ) {
            $this->data['is_french_user'] = true;
        }

        if ($this->is_android_device()) {
            $this->data['is_android_web_view'] = true;
        } else {
            $this->data['is_android_web_view'] = false;
        }


        $this->data['stripe_pk'] = STRIPE_PK;
        $this->data['ad_charge_per_day'] = AD_CHARGE_PER_DAY;

        $this->data['is_logged_in'] = $this->is_logged_in();

        $this->data['active_home'] = ( $this instanceof account && $this->router->method == 'feed' ) ? 'active' : '';
        $this->data['active_org_profile'] = ( $this->router->method == 'org_profile' ) ? 'active' : '';
        $this->data['active_course'] = ( $this->router->method == 'course' ) ? 'active' : '';
        $this->data['active_certify'] = ( $this->router->method == 'certify' ) ? 'active' : '';
        $this->data['active_courses'] = ( $this->router->method == 'courses' ) ? 'active' : '';
        $this->data['active_lessons'] = ( $this->router->method == 'lessons' ) ? 'active' : '';
        $this->data['active_forums'] = ( $this->router->method == 'discussions' ) ? 'active' : '';
        $this->data['active_articles'] = ( $this->router->method == 'articles' || $this->router->method == 'organisations' ) ? 'active' : '';
        $this->data['active_opportunities'] = ( $this->router->method == 'jobs' || $this->router->method == 'projects' ) ? 'active' : '';
        $this->data['active_profile'] = ( $this->router->method == 'profile' ) ? 'active' : '';
        $this->data['active_inbox'] = ( $this->router->method == 'inbox' ) ? 'active' : '';
        $this->data['active_course_students'] = ( $this->router->method == 'course_students' ) ? 'active' : '';

        $this->data['page_css'] = $this->get_page_css();
        $this->data['page_title'] = $this->get_page_title();
        $this->data['header'] = get_view('layout/header', 'header', $this->data);

        $this->data['course_categories'] = $this->account_model->get_course_categories();

        $this->data['is_organisation_member'] = $this->account_model->is_organisation_member( $this->user_id );

        if( $this->is_logged_in() ) {

            if( $this->data['is_organisation_member'] ) {
                $this->data['user_organisations'] = $this->account_model->get_user_organisations( $this->user_id );
                $this->data['tutor_courses'] = $this->account_model->get_tutor_courses( $this->user_id );
            }
            $this->data['organisation_admin_user'] = $this->account_model->is_organisation_admin_user( $this->user_id );
            $this->data['enrolled_courses'] = $this->account_model->get_my_enrolled_courses( $this->user_id );
            $this->data['unread_comments'] = $this->account_model->get_unread_post_comments($this->user_id);
            $this->data['notifications'] = $this->account_model->get_inbox_contacts_notifications($this->user_id);
            $this->data['nav'] = get_view('layout/nav', 'nav_user', $this->data);
        } else {
            $this->data['nav'] = get_view('layout/nav', 'nav_default', $this->data);
            $this->data['signup_modal'] = get_view('crumbs/modals', 'signup_modal');
            $this->data['fb_login_btn'] = get_view('crumbs', 'fb_login_btn');
            $this->data['forgot_password_modal'] = get_view('crumbs/modals/forms', 'forgot_password_modal', $this->data);
            $this->data['fb_user_modal'] = get_view('crumbs/modals/forms', 'fb_user_modal', $this->data);

        }

        $this->data['page_js'] = $this->get_page_js();
        $this->data['footer'] = get_view('layout/footer', 'footer', $this->data);
        $this->data['flash_data'] = get_view('crumbs/flashdata', 'flash_data');

        $this->data['global_search_input'] = get_view('crumbs', 'global_search_input');
        $this->data['search_modal'] = get_view('crumbs/modals/forms', 'search_modal', $this->data);

        $this->load->library ( 'template' );

    }

    protected function is_logged_in() {
        return isset( $this->session->userdata['id'] );
    }

    protected function encrypt( $password ) {
        $this->load->library('encrypt');
        return $this->encrypt->encode($password);
    }

     //Added by Bonaveture DOSSOU 10/04/2018
     public function decrypt( $password ) {
        $this->load->library('encrypt');
        return $this->encrypt->decode($password);
    }

    //return true for organisation admin or course tutor
    public function is_course_owner( $course_id ) {

        return $this->account_model->is_course_owner( $this->user_id, $course_id, $this->data['user']['organisations']  );

    }

    protected function is_admin() {
        return $this->account_model->is_admin( $this->user_id  );
    }

    protected function is_super_admin() {
        return $this->account_model->is_super_admin( $this->user_id  );
    }

    public function sendmail_campaign( $emailType, $subject, $data, $campaign ) {

        $this->send_ses_email($emailType, $subject, $data, $campaign);

    }

    public function sendmail( $emailType, $subject, $data ) {

        $this->send_ses_email($emailType, $subject, $data);

    }

    public function send_admin_email( $subject, $data ) {
        if( IS_LIVE_SERVER ) {
            $this->send_ses_email('admin', $subject, $data);
        }

    }

    public function is_android_device() {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == "mgks.infeeds.hotshi") {
            return true;
        }

        return false;
    }

    protected function create_vanity_url( $user_id ) {
        $this->account_model->create_vanity_url( $user_id );
    }

    public function send_ses_email( $emailType, $subject, $data, $campaign=null ) {

        if( IS_LIVE_SERVER ) {

            $sender = ucfirst(COMPANY_NAME).' '.'<'.SE_EM.'>';

            require_once '/usr/share/php/Mail.php';
            require_once '/usr/share/php/Mail/mime.php';

            $data['email_header'] = $this->load->view('layout/header/header_email', $data, true);
            $data['email_footer'] = $this->load->view('layout/footer/footer_email', $data, true);

            switch ($emailType) {

                case 'admin':
                    $data['email_title'] = 'Server message...';
                    $data['email_content'] = $this->load->view( 'emails/admin', $data, true );
                    break;

                case 'welcome':
                    $data['email_title'] = 'Final step...';
                    $data['email_content'] = $this->load->view( 'emails/welcome', $data, true );
                    break;

                case 'resend_verify_email':
                    $data['email_title'] = 'Verify email...';
                    $data['email_content'] = $this->load->view( 'emails/welcome', $data, true ); //re-use welcome email template
                    break;

                case 'password_reset':
                    $data['email_title'] = 'Reset your password...';
                    $data['email_content'] = $this->load->view( 'emails/password_reset', $data, true );
                    break;

                case 'comment':
                    $data['email_title'] = 'New comment...';
                    $data['email_content'] = $this->load->view( 'emails/comment', $data, true );
                    break;

                case 'comment_reply':
                    $data['email_title'] = 'Comment response...';
                    $data['email_content'] = $this->load->view( 'emails/comment_reply', $data, true );
                    break;

                case 'message':
                    $data['email_title'] = 'New message...';
                    $data['email_content'] = $this->load->view( 'emails/message', $data, true );
                    break;

                case 'certified':
                    $data['email_title'] = 'Congratulations!';
                    $data['email_content'] = $this->load->view( 'emails/certified', $data, true );
                    break;

                case 'failed':
                    $data['email_title'] = 'We\'re sorry!';
                    $data['email_content'] = $this->load->view( 'emails/failed', $data, true );
                    break;

                case 'tutor_invitation':
                    $data['email_title'] = 'Hotshi invitation';
                    $data['email_content'] = $this->load->view( 'emails/tutor_invitation', $data, true );
                    break;

                case 'org_user_added':
                    $data['email_title'] = 'You were added';
                    $data['email_content'] = $this->load->view( 'emails/tutor_invitation', $data, true );
                    break;

                case 'ad_approved':
                    $data['email_title'] = 'Congrats! You Ad was approved.';
                    $data['email_content'] = $this->load->view( 'emails/ad_approved', $data, true );
                    break;

                case 'job_posting_approved':
                    $data['email_title'] = 'Congrats! You Job Posting was approved.';
                    $data['email_content'] = $this->load->view( 'emails/job_posting_approved', $data, true );
                    break;

                case 'project_approved':
                    $data['email_title'] = 'Congrats! You project was approved.';
                    $data['email_content'] = $this->load->view( 'emails/project_approved', $data, true );
                    break;

                case 'friend_invite':
                    $data['email_title'] = 'Hotshi Invitation';
                    $data['email_content'] = $this->load->view( 'emails/friend_invite', $data, true );
                    break;

                case 'new_follower':
                    $data['email_title'] = 'New follower on Hotshi';
                    $data['email_content'] = $this->load->view( 'emails/new_follower', $data, true );
                    break;

                case 'new_enrollment':
                    $data['email_title'] = 'You are enrolled';
                    $data['email_content'] = $this->load->view( 'emails/new_enrollment', $data, true );
                    break;

                case 'new_opportunity_application':
                    $data['email_title'] = 'New opportunity application on Hotshi';
                    $data['email_content'] = $this->load->view( 'emails/new_opportunity_application', $data, true );
                    break;

                case 'new_project_proposal':
                    $data['email_title'] = 'Someone likes your project on Hotshi';
                    $data['email_content'] = $this->load->view( 'emails/new_project_proposal', $data, true );
                    break;

                case 'campaign':
                    $data['email_title'] = $campaign['subject'];
                    $data['email_content'] = $this->load->view( 'emails/campaign', $data, true );
                    break;

                default:
                    # code...
                    break;
            }

            $email_html = $this->load->view( 'templates/email', $data, true );

            if( $emailType == 'admin' ) {
                $receiver = 'hotshidac@hotshi.com';
            } else {
                $receiver = $data['email_data']['email'];
            }

            $recipient = $receiver;
            $headers['From'] = $sender;
            $headers['To'] = $receiver;
            $headers['Subject'] = $subject;

            $message = new Mail_mime(array(
                "text_encoding" => "7bit",
                "text_charset" => "utf-8",
                "html_charset" => "utf-8",
                "head_charset" => "UTF-8",
                "eol" => "\n"));

            $message->setHTMLBody($email_html);

            $smtpParams = array (
                'host' => SE_HO,
                'port' => SE_PO,
                'auth' => true,
                'username' => SE_U,
                'password' => SE_P
            );

            $mail = Mail::factory('smtp', $smtpParams);
            $result = $mail->send($recipient, $message->headers($headers), $message->get());

            /*if (PEAR::isError($result)) {
                echo json_encode(array('status' => 'error', 'message' => $result->getMessage()));
            } else {
                echo json_encode(array('status' => 'success', 'message' => 'Message sent!'));
            }*/

        }

    }

    public function process_stripe_payment( $token, $amount, $description ) {

        $stripe_sk = STRIPE_SK;
        Stripe::setApiKey($stripe_sk);
        $amountInCents = $amount * 100;

        try{

            Stripe_Charge::create(array(
                    "amount" => $amountInCents, // amount in cents
                    "currency" => 'eur',
                    "card" => $token,
                    "description" => $description,
                    "receipt_email" => $this->data['user']['email']
                )

            );

            return 'success';

        }catch(Stripe_CardError $e) {

            $body = $e->getJsonBody();
            $err  = $body['error'];

            if($err['type'] == "api_error") {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem processing your payment. Don\'t worry, we haven\'t deducted anything. Please try again.'));
            }else{
                echo json_encode(array('status' => 'error', 'message' => $err['message']));

            }

            exit;
        }

    }

    /* load additional css for individual pages here */
    private function get_page_css() {

        $page = $this->router->method;

        switch( $page ) {
            case 'home':
                return get_css('landing_css');
                break;
            case 'signup':
                return get_css('landing_css');
                break;
            case 'signup_invite':
                return get_css('landing_css');
                break;
            case 'login':
                return get_css('landing_css');
                break;
            case 'courses':
                return get_css('landing_css');
                break;
            case 'lessons':
                return get_css('landing_css');
                break;
            case 'course':
                return get_css('landing_css');
                break;
            case 'ads':
                return get_css('landing_css');
                break;
            case 'edit_ad':
                return get_css('landing_css');
                break;
            case 'discussions':
                return get_css('landing_css');
                break;
            case 'articles':
                return get_css('landing_css');
                break;
            case 'article':
                return get_css('landing_css');
                break;
            case 'opportunities':
                return get_css('landing_css');
                break;
            case 'opportunity':
                return get_css('landing_css');
                break;
            case 'projects':
                return get_css('landing_css');
                break;
            case 'project':
                return get_css('landing_css');
                break;
            case 'jobs':
                return get_css('landing_css');
                break;
            case 'campaigns':
                return get_css('landing_css');
                break;
            case 'about':
                return get_css('landing_css');
                break;
            case 'logout':
                return get_css('landing_css');
                break;
            case 'privacy':
                return get_css('landing_css');
                break;
            case 'contact':
                return get_css('landing_css');
                break;
            case 'organisations':
                return get_css('landing_css');
                break;
            case 'users':
                return get_css('landing_css');
                break;
            /*case 'create_article':
                return get_css('landing_css');
                break;*/
            case 'search':
                return get_css('landing_css');
                break;
            case 'faqs':
                return get_css('landing_css');
                break;
            case 'reset_password':
                return get_css('landing_css');
                break;
            case 'verify_email':
                return get_css('landing_css');
                break;
            case 'profile':
                return get_css('profile_css');
                break;
            case 'org_profile':
                return get_css('profile_css');
                break;
            case 'user':
                return get_css('profile_css');
                break;
            case 'add_course':
                return get_css('edit_page_css');
                break;
            case 'feed':
                return get_css('feed_css');
                break;
            case 'inbox':
                return get_css('inbox_css');
                break;
            case 'edit_profile':
                return get_css('edit_page_css');
                break;
            case 'create_opportunity':
                return get_css('edit_page_css');
                break;
            case 'create_project':
                return get_css('edit_page_css');
                break;
            case 'create_campaign':
                return get_css('edit_page_css');
                break;
            case 'edit_opportunity':
                return get_css('edit_page_css');
                break;
            case 'edit_article_item':
                return get_css('edit_page_css');
                break;
            case 'edit_event_item':
                return get_css('edit_page_css');
                break;
            case 'settings':
                return get_css('edit_page_css');
                break;
            default:
                return '';
        }
    }

    /* load additional js for individual pages here */
    private function get_page_js() {

        $page = $this->router->method;

        switch( $page ) {
            case 'feed':
                return get_js('feed_js');
                break;
            case 'inbox':
                return get_js('inbox_js');
                break;
            case 'profile':
                return get_js('user_profile_js');
                break;
            case 'edit_profile':
                return get_js('edit_page_js');
                break;
            case 'create_opportunity':
                return get_js('process_job_opportunity_payment');
                break;
            case 'create_project':
                return get_js('process_project_payment');
                break;
            case 'create_campaign':
                return get_js('edit_page_js');
                break;
            case 'edit_opportunity':
                return get_js('edit_page_js');
                break;
            case 'edit_article_item':
                return get_js('edit_page_js');
                break;
            case 'edit_event_item':
                return get_js('edit_page_js');
                break;
            case 'create_test':
                return get_js('create_test_js');
                break;
            case 'add_test_questions':
                return get_js('create_test_js');
                break;
            case 'add_test_question_answers':
                return get_js('create_test_js');
                break;
            case 'ads':
                return get_js('process_ad_payment_js');
                break;
            case 'course':
                return get_js('process_cert_payment');
                break;
            default:
                return '';
        }

    }

    private function get_page_title() {

        $page = $this->router->method;

        switch( $page ) {
            case 'home':
                if( $this->data['is_french_user'] ) {
                    return 'Le plus grand réseau mondial des professionnels et entreprises engagés dans le développement de l\'Afrique et de ses diasporas.';
                } else {
                    return 'The largest global network of professionals and companies engaged in the development of Africa and its diasporas.';
                }
                break;
            case 'signup':
                return 'Register';
                break;
            case 'signup_invite':
                return 'Register';
                break;
            case 'ads':
                return 'My Ads';
                break;
            case 'edit_ad':
                return 'Edit Ad';
                break;
            case 'login':
                return 'Register';
                break;
            case 'add_course':
                return 'Add Course';
                break;
            case 'courses':
                return 'Courses';
                break;
            case 'add_lesson':
                return 'Add lesson';
                break;
            case 'add_lectures':
                return 'Add lectures';
                break;
            case 'create_test':
                return 'Create test';
                break;
            case 'add_test_questions':
                return 'Add questions';
                break;
            case 'add_test_question_answers':
                return 'Add answers';
                break;
            case 'update_lesson':
                return 'Update lesson';
                break;
            case 'create_article':
                return 'Create article';
                break;
            case 'edit_article':
                return 'Edit article';
                break;
            case 'course_students':
                return 'Course students';
                break;
            case 'edit_course':
                return 'Edit course';
                break;
            case 'edit_org':
                return 'Edit organisation';
                break;
            case 'search':
                return ucfirst($this->input->get('q'));
                break;
            case 'faqs':
                return 'FAQs';
                break;
            case 'feed':
                return 'Welcome!';
                break;
            case 'jobs':
                return 'Jobs';
                break;
            case 'articles':
                return 'Hotshi Articles';
                break;
            case 'opportunities':
                return 'Opportunities';
                break;
            case 'create_opportunity':
                return 'Create Opportunity';
                break;
            case 'projects':
                return 'Projects';
                break;
            case 'create_project':
                return 'Create Project';
                break;
            case 'campaigns':
                return 'Email Campaigns';
                break;
            case 'create_campaign':
                return 'Create Email Campaign';
                break;
            case 'edit_opportunity':
                return 'Edit Opportunity';
                break;
            case 'edit_project':
                return 'Edit Project';
                break;
            case 'organisations':
                return 'Organisations';
                break;
            case 'events':
                return 'Events';
                break;
            case 'forums':
                return 'Forums';
                break;
            case 'inbox':
                return 'Messaging';
                break;
            case 'edit_profile':
                return 'Edit Profile';
                break;
            case 'edit_post':
                return 'Edit Post';
                break;
            case 'reset_password':
                return 'Reset Password';
                break;
            case 'verify_email':
                return 'Verify Your Email';
                break;
            case 'settings':
                return 'Account Settings';
                break;
            case 'about':
                return 'About';
                break;
            case 'logout':
                return 'Log Out';
                break;
            case 'privacy':
                return 'Privacy';
                break;
            case 'contact':
                return 'Contact Us';
                break;
            case 'users':
                return 'Users';
                break;
            case 'certificate':
                return 'Certificate';
                break;
            case 'start_lesson_test':
                return 'Start test';
                break;
            case 'grade_lesson_test':
                return 'Grade test';
                break;
            case 'discussions':
                return 'Grade test';
                break;
            default:
                return '';
        }

    }

}