<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 26/12/14
 * Time: 19:45
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( 'phpmailer.php' );

class Email  {

    var $CI;

    public function __construct() {

        $this->CI = &get_instance();

    }

    /**
     * @param  string $emailType
     * @param  string $subject
     * @param  array $data
     * @return bool
     */
    public function send( $emailType, $subject, $data ) {

        $data['email_header'] = $this->CI->load->view('layout/header/header_email', $data, true);
        $data['email_footer'] = $this->CI->load->view('layout/footer/footer_email', $data, true);

        switch ($emailType) {

            case 'admin':
                $data['email_title'] = 'Server message...';
                $data['email_content'] = $this->CI->load->view( 'emails/admin', $data, true );
                break;

            case 'welcome':
                $data['email_title'] = 'Final step...';
                $data['email_content'] = $this->CI->load->view( 'emails/welcome', $data, true );
                break;

            case 'resend_verify_email':
                $data['email_title'] = 'Verify email...';
                $data['email_content'] = $this->CI->load->view( 'emails/welcome', $data, true ); //re-use welcome email template
                break;

            case 'password_reset':
                $data['email_title'] = 'Reset your password...';
                $data['email_content'] = $this->CI->load->view( 'emails/password_reset', $data, true );
                break;

            case 'comment':
                $data['email_title'] = 'New comment...';
                $data['email_content'] = $this->CI->load->view( 'emails/comment', $data, true );
                break;

            case 'comment_reply':
                $data['email_title'] = 'Comment response...';
                $data['email_content'] = $this->CI->load->view( 'emails/comment_reply', $data, true );
                break;

            case 'message':
                $data['email_title'] = 'New message...';
                $data['email_content'] = $this->CI->load->view( 'emails/message', $data, true );
                break;

            case 'certified':
                $data['email_title'] = 'Congratulations!';
                $data['email_content'] = $this->CI->load->view( 'emails/certified', $data, true );
                break;

            case 'failed':
                $data['email_title'] = 'We\'re sorry!';
                $data['email_content'] = $this->CI->load->view( 'emails/failed', $data, true );
                break;

            case 'tutor_invitation':
                $data['email_title'] = 'Hotshi invitation';
                $data['email_content'] = $this->CI->load->view( 'emails/tutor_invitation', $data, true );
                break;

            case 'org_user_added':
                $data['email_title'] = 'You were added';
                $data['email_content'] = $this->CI->load->view( 'emails/tutor_invitation', $data, true );
                break;

            default:
                # code...
                break;
        }

        $email_html = $this->CI->load->view( 'templates/email', $data, true );

        /*
         * Use PHP Mailer library
         */

        $mail = new PHPMailer;

        $mail->Host = $GLOBALS['SMTP_SERVER'];
        $mail->Username = $GLOBALS['SMTP_USER'];
        $mail->Password = $GLOBALS['EMAIL_PASS'];

        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->From = $GLOBALS['FROM_ADDRESS'];
        $mail->FromName = $GLOBALS['FROM_NAME'];

        if( $GLOBALS['SERVER'] == 'dev' ) {

            $mail->addAddress($GLOBALS['DEV_EMAIL'], $data['email_data']['username']); //send to dev email

        } else {

            if( $emailType == 'admin' ) {
                $mail->addAddress('hotshidac@'.$GLOBALS['COMPANY_NAME'].'.com', 'Hotshi');
            } else {
                $mail->addAddress($data['email_data']['email'], $data['email_data']['receiver_fullname']);  // send to real recipient
            }

        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $email_html;

        if(!$mail->send()) {
            return $mail->ErrorInfo;
        }

        return true;


    }

}
