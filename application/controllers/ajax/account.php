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

require_once( APPPATH . 'libraries/cloudinary2/Cloudinary.php');
require_once( APPPATH . 'libraries/cloudinary2/Uploader.php');
require_once( APPPATH . 'libraries/cloudinary2/Api.php');

class account extends Base_Controller {


    ////////////////////////////////////////////////////////
    // HANDLE AJAX CALLS IN RELATION TO USER ACCOUNTS     //
    ////////////////////////////////////////////////////////


    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();

        if( !$this->input->is_ajax_request() ){
            redirect('/');
            exit;
        }

        if( !$this->is_logged_in() ) {
            echo json_encode( array('status' => 'error', 'message' => SESSION_EXP_MSG) );
            exit;
        }

        // check if user account is active
        if( !$this->data['user']['is_active'] ) {
            echo json_encode( array('status' => 'error', 'message' => ACC_DISABLED_MSG) );
            exit;
        }

        //check if user has verified their email
        if( !$this->data['user']['is_verified'] && $this->router->method != 'first_intro_completed' && $this->router->method != 'resend_verification_email' ) {
            echo json_encode( array('status' => 'error', 'message' => EMAIL_UNVERIFIED_MSG) );
            exit;
        }

    }

    private function upload_image( $file, $dir, $max_height ) {

        if( empty( $file ) ) {
            return array('secure_url' => null);
        }

        $response = \Cloudinary\Uploader::upload( $file, array('folder' => $dir, 'crop' => 'limit', 'height' => $max_height, "timeout" => 300) );

        return $response;

    }

    public function create_post() {

        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $course_id = $this->input->post('course_id');

        if( !$course_id ) {
            $course_id = 0;
        }

        $data = array(
            'user_id' => $this->user_id,
            'description' => nl2br($this->input->post('description')),
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id,
            'course_id' => $course_id
        );

        $post_id = $this->account_model->create_post( $data );

        if( !$post_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem creating post. Try again in a little bit.'));
            exit;
        }

        $post = $this->account_model->get_user_post( $post_id, $this->user_id );

        if( !$post['poster_avatar'] ) {
            $post['poster_avatar'] = get_default_avatar();
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Post created.', 'post_id' => $post_id, 'post' => $post));
        exit;

    }

    public function update_post() {

        $post_id = $this->input->post('post_id');

        $data = array(
            'description' => nl2br($this->input->post('description'))
        );

        if( !$this->account_model->update_post( $data, $post_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating post. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Post updated.', 'noreset' => 'true'));
        exit;

    }

    // --------------------------------------------------------------------

    /* update user avatar */
    public function update_avatar() {

        // check if removing or updating
        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'avatar', MAX_PROFILE_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        // update image link or delete from Cloudinary
        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';

            if( $this->data['user']['image_public_id'] ) {
                \Cloudinary\Uploader::destroy( $this->data['user']['image_public_id'] );
            }

        }

        $data = array(
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        if( !$this->account_model->update_avatar( $data, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating photo. Try again in a little bit.'));
            exit;
        }

        if( $this->data['is_french_user'] ) {
            echo json_encode(array('status' => 'ok', 'message' => 'Photo de profil mise à jour.', 'imgsrc' => $image['secure_url']));
        } else {
            echo json_encode(array('status' => 'ok', 'message' => 'Profile photo updated.', 'imgsrc' => $image['secure_url']));
        }
        exit;

    }

    public function update_post_img() {

        $post_id = $this->input->post('post_id');

        $post = $this->account_model->get_user_post( $post_id, $this->user_id );

        if( !$post ) {
            echo json_encode(array('status' => 'error', 'message' => 'Post not found!.'));
            exit;
        }

        // check if removing or updating
        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        // update image link or delete from Cloudinary
        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';

            if( $post['public_id'] ) {
                \Cloudinary\Uploader::destroy( $post['public_id'] );
            }
        }

        $data = array(
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        if( !$this->account_model->update_post( $data, $post_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating photo. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Photo updated.', 'imgsrc' => $image['secure_url']));
        exit;

    }

    public function remove_avatar() {

        if( $this->data['user']['image_public_id'] ) {
            \Cloudinary\Uploader::destroy( $this->data['user']['image_public_id'] );
        }

        $data = array(
            'image' => null,
            'image_bytes' => '',
            'image_public_id' => ''
        );

        if( !$this->account_model->update_avatar( $data, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing photo. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Image deleted.', 'imgsrc' => get_default_avatar()));
        exit;

    }

    public function remove_post_img() {

        $post_id = $this->input->post('post_id');

        $post = $this->account_model->get_user_post( $post_id, $this->user_id );

        if( !$post ) {
            echo json_encode(array('status' => 'error', 'message' => 'Post not found!.'));
            exit;
        }

        if( $post['image_public_id'] ) {
            \Cloudinary\Uploader::destroy( $post['image_public_id'] );
        }

        $data = array(
            'image' => null,
            'image_bytes' => '',
            'image_public_id' => ''
        );

        if( !$this->account_model->update_post( $data, $post_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing photo. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Image deleted.', 'imgsrc' => get_default_post_img()));
        exit;

    }


    public function add_gallery_images() {

        $image = $this->upload_image($_FILES['file']['tmp_name'], $this->user_id, MAX_GALLERY_IMG_HEIGHT);

        echo json_encode($image);

        if( !$image['secure_url'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Problem uploading photo. Try again in a little bit.'));
            exit;
        }

        $data = array(

            'user_id' => $this->user_id,
            'image' => $image['secure_url'],
            'bytes' => $image['bytes'],
            'public_id' => $image['public_id'],
            'date_created' => date('Y-m-d H:i:s')

        );

        if( !$this->account_model->add_gallery_images( $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Problem uploading your photo(s). Try again in a little bit.'));
            exit;
        }

    }

    public function get_gallery_images( $user_id ) {

        $images = $this->account_model->get_gallery_images( $user_id );
        echo json_encode( $images );

    }

    public function remove_gallery_image( $image_id ) {

        if( !$this->account_model->remove_gallery_image( $this->user_id, $image_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing photo. Try again in a little bit.'));
            exit;
        } else {
            \Cloudinary\Uploader::destroy( $this->input->post('public_id') );
        }

    }


    public function update_gallery_info() {

        $data = array(
            'gallery_desc' => $this->input->post('gallery_desc')
        );

        if( !$this->account_model->update_details( $data, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Gallery description updated.'));
        exit;

    }

    public function update_details() {



        if( $this->data['user']['is_fb_user'] ) {

            $data = array(
                'profession' => $this->input->post('profession'),
                'phone' => $this->input->post('phone'),
                'about' => nl2br($this->input->post('about')),
                'website' => $this->input->post('website'),
                //'business_address' => $this->input->post('business_address'),
                'tags' => $this->input->post('tags'),
                'country_id' => $this->input->post('country_id'),
                'country_origin_id' => $this->input->post('country_origin_id')
            );
        } else {

            $email = $this->input->post('email');
            $is_active = 1;

            if( $this->data['user']['email'] != $email ) { //user changed email address
                //$is_active = 0;
            }

            $fullname = $this->input->post('fullname');
            $firstname = explode(' ', $fullname);

            $data = array(
                'fullname' => $fullname,
                'firstname' => $firstname[0],
                'email' => $email,
                'profession' => $this->input->post('profession'),
                'phone' => $this->input->post('phone'),
                'about' => nl2br($this->input->post('about')),
                'website' => $this->input->post('website'),
                //'business_address' => $this->input->post('business_address'),
                'tags' => $this->input->post('tags'),
                'country_id' => $this->input->post('country_id'),
                'country_origin_id' => $this->input->post('country_origin_id'),
                'is_active' => $is_active
            );
        }



        if( !$this->account_model->update_details( $data, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating details. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Details updated.', 'noreset' => 'true'));
        exit;

    }

    public function first_intro_completed() {

        $data = array(
            'is_first_time_user' => 0
        );

        $this->account_model->update_details( $data, $this->user_id );

    }

    public function delete_post() {

        $post_id = $this->input->post('post_id');

        $data = array(
            'is_deleted' => 1
        );

        if( !$this->account_model->delete_post( $data, $this->user_id, $post_id) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem deleting post. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'Success'));
        exit;

    }

    public function hide_post() {

        $data = array(
            'post_id' => $this->input->post('post_id'),
            'user_id' => $this->user_id
        );

        if( !$this->account_model->hide_post( $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem hiding post. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'Success'));
        exit;

    }

    public function unhide_post() {


        if( !$this->account_model->unhide_post( $this->input->post('post_id'), $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem unhiding post. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'Success'));
        exit;

    }

    public function hide_default_post() {

        $data = array(
            'is_hidden_default_post' => 1
        );

        if( !$this->account_model->hide_default_post( $data, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem hiding post. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'Success'));
        exit;

    }

    public function get_post_comments( $post_id ) {

        $comments = $this->account_model->get_post_comments( $post_id );
        echo json_encode($comments);

    }

    public function add_comment() {

        $comment = $this->input->post('comment');
        $post_id = $this->input->post('post_id');

        $post = $this->account_model->get_post( $post_id );

        //ensure post hasn't been deleted
        if( !$post ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This post has been removed.'));
            exit;
        }

        $is_seen = $post['user_id'] == $this->user_id;

        $data = array(
            'post_id' => $post_id,
            'user_id' => $this->user_id,
            'comment' => nl2br($comment),
            'is_seen' => $is_seen
        );

        $comment_id = $this->account_model->add_comment( $data );

        if( !$comment_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem adding comment. Try again in a little bit.'));
            exit;
        }

        $comment = $this->account_model->get_comment( $comment_id );

        echo json_encode(array('status' => 'ok', 'message' => 'Comment posted.', 'comment_id' =>  $comment_id, 'comment' => $comment, 'comment_post_id' => $post_id));

        /* notify poster of comment by email */
        if( $post['user_id'] != $this->user_id ) {

            $receiver = $this->account_model->get_user_details( $post['user_id'] );

            $this->data['email_data'] = array(

                'email' => $receiver['email'],
                'firstname' => $receiver['firstname'],
                'receiver_fullname' => $receiver['fullname'],
                'sender_fullname' => $this->data['user']['fullname'],
                'sender_id' => $this->user_id,
                'post_id' => $post['id'],
                'comment' => $data['comment']

            ); $this->sendmail('comment', 'Comment posted on your post', $this->data);

        }

        exit;

    }

    public function reply_comment() {

        $comment = $this->input->post('comment');
        $comment_id = $this->input->post('comment_id');
        $to_user_id = $this->input->post('to_user_id');
        $post_id = $this->input->post('post_id');

        if( $to_user_id == $this->user_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Action not allowed.'));
            exit;
        }

        $to_user = $this->account_model->get_user_details( $to_user_id );

        //ensure user exists and user account active
        if( !$to_user || !$to_user['is_active'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This user account is no longer active.'));
            exit;
        }

        $post = $this->account_model->get_post( $post_id );

        if( !$post ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This post has been removed.'));
            exit;
        }


        $data = array(
            'comment_id' => $comment_id,
            'from_user_id' => $this->user_id,
            'to_user_id' => $to_user_id,
            'comment' => nl2br($comment)
        );

        $reply_id = $this->account_model->reply_comment( $data );

        if( !$reply_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem adding comment. Try again in a little bit.'));
            exit;
        }

        $comment = $this->account_model->get_reply( $reply_id, $comment_id ); //root comment id

        echo json_encode(array('status' => 'ok', 'message' => 'Comment posted.', 'reply_id' => $reply_id, 'comment' => $comment, 'comment_post_id' => $post_id));


        $receiver = $this->account_model->get_user_details( $to_user_id );

        $this->data['email_data'] = array(

            'email' => $receiver['email'],
            'firstname' => $receiver['firstname'],
            'receiver_fullname' => $receiver['fullname'],
            'sender_fullname' => $this->data['user']['fullname'],
            'sender_id' => $this->user_id,
            'post_id' => $post['id'],
            'comment' => $data['comment']

        ); $this->sendmail('comment_reply', 'Comment response', $this->data);

        exit;

    }

    public function get_contact_messages() {

        $contact_id = $this->input->post('contact_id');
        $messages = $this->account_model->get_contact_messages( $this->user_id, $contact_id );
        echo json_encode($messages);

    }

    public function create_message_thread() {

        $msg = $this->input->post('message');
        $receiver_id = $this->input->post('receiver_id');

        if( $receiver_id == $this->user_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Action not allowed.'));
            exit;
        }

        if( !trim($msg) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Enter a message.'));
            exit;
        }

        $receiver = $this->account_model->get_user_details($receiver_id);

        if( !$receiver || !$receiver['is_active'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'User account is no longer active.'));
            exit;
        }

        $message_map = array(
            'user_a_id' => $this->user_id,
            'user_b_id' => $receiver_id
        );

        $message = array(
            'description' => nl2br($msg),
            'sender_user_id' => $this->user_id,
            'is_seen' => 0
        );

        $message_map_id = $this->account_model->create_message_thread( $message_map, $message );

        if( !$message_map_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem sending message. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'hideform' => 'true', 'message' => 'Message sent. <a href="/account/inbox?contactid='.$receiver_id.'">View message</a>'));

        /* notify user by email */
        $this->data['email_data'] = array(
            'email' => $receiver['email'],
            'firstname' => $receiver['firstname'],
            'receiver_fullname' => $receiver['fullname'],
            'sender_fullname' => $this->data['user']['fullname'],
            'sender_id' => $this->user_id,
            'message' => $message['description']

        ); $this->sendmail('message', 'New message', $this->data);

        $this->send_android_push_notification($receiver, $this->data['user']['fullname'], $msg );

        exit;

    }

    private function upload_doc( $file ) {

        if( empty( $file ) ) {
            return array('secure_url' => null);
        }

        $response = \Cloudinary\Uploader::upload( $file, array('resource_type' => 'auto', 'use_filename' => true, "timeout" => 300) );

        return $response;

    }

    public function send_message_reply() {

        $contact_id = $this->input->post('contact_id');
        $reply = $this->input->post('message');

        if( !trim($reply) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Enter a message.'));
            exit;
        }

        $receiver = $this->account_model->get_user_details($contact_id);

        if( !$receiver || !$receiver['is_active'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'User account is no longer active.'));
            exit;
        }

        if( isset($_FILES['file']) ) {
            $image = $this->upload_doc($_FILES['file']['tmp_name']);
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'sender_user_id' => $this->user_id,
            'description' => nl2br($reply),
            'image' => $image['secure_url'],
            'bytes' => $bytes,
            'public_id' => $public_id,
            'is_seen' => 0
        );

        $inbox_reply_id = $this->account_model->send_message_reply( $this->user_id, $contact_id, $data );

        if( !$inbox_reply_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem sending reply. Try again in a little bit.'));
            exit;
        }

        $inbox_reply = $this->account_model->get_inbox_reply( $inbox_reply_id );

        echo json_encode(array('status' => 'ok', 'message' => 'Comment posted.', 'inbox_reply_id' => $inbox_reply_id, 'inbox_reply' => $inbox_reply));

        $this->send_android_push_notification($receiver, $this->data['user']['fullname'], $reply );

        exit;

    }

    public function resend_verification_email() {

        $token = generate_unique_val();

        $this->account_model->add_email_verification_token( $this->user_id, $token );

        $this->data['email_data'] = array(

            'email' => $this->data['user']['email'],
            'firstname' => $this->data['user']['firstname'],
            'receiver_fullname' => $this->data['user']['fullname'],
            'activate_token' => $token

        ); $this->sendmail('resend_verify_email', 'Confirm your '.ucfirst($GLOBALS['COMPANY_NAME']).' account', $this->data);

        echo json_encode(array('status' => 'ok', 'message' => 'An email is on its way to you. Please check your email inbox.'));
        exit;

    }

    // --------------------------------------------------------------------

    /*
     * update user password
     */
    public function update_password() {

        if( $this->data['user']['is_fb_user'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Account is currently linked to your Facebook. You must log out and use the Forgot Password option.'));
            exit;
        }

        $curr_password = $this->input->post('curr_password');
        $new_password = $this->input->post('new_password');

        if( !trim($curr_password) || !trim($new_password) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please ensure required fields are not empty.'));
            exit;
        }

        //check if current password matches
        $email = $this->data['user']['email'];
        if( !$this->account_model->get_user( $email, $curr_password ) ) {

            echo json_encode(array('status' => 'error', 'message' => 'Current password is incorrect.'));
            exit;

        }

        $e_password = $this->encrypt( $new_password );

        if( !$this->account_model->update_password( $e_password, $this->user_id ) ) {

            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problems updating password. Try again in a little bit.'));
            exit;

        }

        echo json_encode(array('status' => 'ok', 'message' => 'Password updated.'));
        exit;

    }

    // --------------------------------------------------------------------

    /*
     * update user password
     */
    public function update_email() {

        if( $this->data['user']['is_fb_user'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Account is currently linked to your Facebook. You must log out &amp; register with a new email address.'));
            exit;
        }

        $new_email = $this->input->post('new_email');

        if( $new_email == $this->data['user']['email'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'The email entered is the same as your current one.'));
            exit;
        }

        if( !valid_email($new_email) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Enter a valid email.'));
            exit;
        }

        $curr_email = $this->data['user']['email'];
        $curr_password = $this->input->post('curr_password');
        if( !$this->account_model->get_user( $curr_email, $curr_password ) ) {

            echo json_encode(array('status' => 'error', 'message' => 'Current password is incorrect.'));
            exit;

        }

        if( !$this->account_model->update_email( $new_email, $this->user_id ) ) {

            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problems updating email. Try again in a little bit.'));
            exit;

        }

        $this->data['user']['email'] = $new_email;

        echo json_encode(array('status' => 'ok', 'message' => 'Email updated. We\'ve sent you an email to verify your new email account.'));
        exit;

    }

    public function deactivate_account() {

        $curr_email = $this->data['user']['email'];
        $curr_password = $this->input->post('curr_password');

        if( !$this->account_model->get_user( $curr_email, $curr_password ) ) {

            echo json_encode(array('status' => 'error', 'message' => 'Current password is incorrect.'));
            exit;

        }

        if( !$this->account_model->deactivate_account( $this->user_id) ) {

            echo json_encode(array('status' => 'error', 'message' => 'Problem de-activating account. Try again in a little bit.'));
            exit;

        }

        echo json_encode(array('status' => 'ok', 'message' => 'Account de-activated. All Your data will be deleted within the next 30 days. To re-activate your account within that period, simply email help@blackspree.com.'));

        /* notify admin */
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'page/profile/'.$this->user_id.'">'.$this->data['user']['fullname'].'</a> deactivated their account.'
        ); $this->send_admin_email('Account deactivated', $this->data);

        $this->session->sess_destroy();
        exit;

    }

    public function create_article() {

        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'user_id' => $this->user_id,
            'title' => $this->input->post('title'),
            'description' => nl2br($this->input->post('description')),
            'tags' => '',
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        $article_id = $this->account_model->create_article( $data );

        if( !$article_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem creating article. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Article created. You can view/edit it by <a href="/page/article/'.$article_id.'" class="bold">clicking here</a>.'));
        exit;

    }

    public function update_article() {

        $article_id = $this->input->post('article_id');

        $article = $this->account_model->get_article($article_id);

        if( $article['user_id'] != $this->user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }


        $data = array(
            'user_id' => $this->user_id,
            'title' => $this->input->post('title'),
            'description' => nl2br($this->input->post('description')),
            'tags' => ''
        );

        if( !$this->account_model->update_article( $data, $article['id'], $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating article. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Article updated. You can view it <a href="/page/article/'.$article['id'].'">here</a>', 'noreset' => 'true'));
        exit;

    }

    public function create_opportunity() {

        /*if( !$this->data['user']['is_hotshi_admin'] ) {
            $response = array('status' => 'error', 'message' => 'Access denied. Hotshi Admin only.');
            echo json_encode( $response );
            exit;
        }*/

        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'user_id' => $this->user_id,
            'title' => $this->input->post('title'),
            'description' => nl2br($this->input->post('description')),
            'skills' => $this->input->post('skills'),
            'qualifications' => $this->input->post('qualifications'),
            'location' => $this->input->post('location'),
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        $stripe_token = $this->input->post('stripeToken');
        $total_amount = CREATE_OPPORTUNITY_COST;
        $this->process_stripe_payment( $stripe_token, $total_amount, 'Job Opportunity Payment - '.$this->data['user']['email'] );
        //stripe will auto-exit upon any error. if we get past stripe function, it means payment went through


        $opportunity_id = $this->account_model->create_opportunity( $data );

        echo json_encode(array('status' => 'success', 'message' => 'Success! Job opportunity has been created. You will be notified by Hotshi once activated.', 'opportunity_id' => $opportunity_id));

        /* notify admin */
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'page/profile/'.$this->user_id.'">'.$this->data['user']['fullname'].'</a> created a Job opportunity on Hotshi.<br><p>Requires your approval.</p>'
        ); $this->send_admin_email('New Job Opportunity Created', $this->data);

    }

    public function upload_opportunity_image() {

        $opportunity_id = $this->input->post('opportunity_id');
        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'ads', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        if( $this->account_model->update_opportunity( $data, $opportunity_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Job image uploaded!'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem uploading Job image.'));
        }

    }

    public function create_project() {

        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'user_id' => $this->user_id,
            'title' => $this->input->post('title'),
            'description' => nl2br($this->input->post('description')),
            'skills' => $this->input->post('skills'),
            'qualifications' => $this->input->post('qualifications'),
            'location' => $this->input->post('location'),
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        $stripe_token = $this->input->post('stripeToken');
        $total_amount = CREATE_OPPORTUNITY_COST;
        $this->process_stripe_payment( $stripe_token, $total_amount, 'Project Payment - '.$this->data['user']['email'] );
        //stripe will auto-exit upon any error. if we get past stripe function, it means payment went through


        $project_id = $this->account_model->create_project( $data );

        echo json_encode(array('status' => 'success', 'message' => 'Success! Project has been created. You will be notified by Hotshi once activated.', 'project_id' => $project_id));

        /* notify admin */
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'page/profile/'.$this->user_id.'">'.$this->data['user']['fullname'].'</a> created a project on Hotshi.<br><p>Requires your approval.</p>'
        ); $this->send_admin_email('New Project Created', $this->data);

    }

    public function upload_project_image() {

        $project_id = $this->input->post('project_id');
        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'ads', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        if( $this->account_model->update_project( $data, $project_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Project image uploaded!'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem uploading Project image.'));
        }

    }

    public function create_campaign() {

        if( !$this->data['user']['is_hotshi_admin'] ) {
            $response = array('status' => 'error', 'message' => 'Access denied. Hotshi Admin only.');
            echo json_encode( $response );
            exit;
        }

        /*if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $image['secure_url'] = null;
        } else {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT);
        }*/

        $image['secure_url'] = null;

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'user_id' => $this->user_id,
            'send_to' => $this->input->post('send_to'),
            'subject' => $this->input->post('subject'),
            'description' => nl2br($this->input->post('description')),
            'cta_link' => $this->input->post('cta_link'),
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        $campaign_id = $this->account_model->create_campaign( $data );

        if( !$campaign_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem creating email campaign. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'redirect' => '/account/campaigns/', 'message' => 'Email campaign created.'));
        exit;

    }

    public function send_email_campaign() {

        if( !$this->data['user']['is_hotshi_admin'] ) {
            $response = array('status' => 'error', 'message' => 'Access denied. Hotshi Admin only.');
            echo json_encode( $response );
            exit;
        }

        $campaign_id = $this->input->post('campaign_id');
        $campaign = $this->account_model->get_campaign( $campaign_id );

        if( !$campaign ){
            $response = array('status' => 'error', 'message' => 'Email campaign not found. Please contact your web admin for more info. Sorry about that. ');
            echo json_encode( $response );
            exit;
        }

        $users = $this->account_model->get_campaign_targets( $campaign['send_to'] );

        foreach( $users as $user ) {

            $this->data['email_data'] = array(

                'email' => $user['email'],
                'firstname' => $user['firstname'],
                'content' => $campaign['description'],
                'cta_link' => $campaign['cta_link'],

            ); $this->sendmail_campaign('campaign', $campaign['subject'], $this->data, $campaign);

        }

        echo json_encode(array('status' => 'success', 'message' => 'Done.'));

    }

    public function delete_email_campaign() {

        if( !$this->data['user']['is_hotshi_admin'] ) {
            $response = array('status' => 'error', 'message' => 'Access denied. Hotshi Admin only.');
            echo json_encode( $response );
            exit;
        }

        $campaign_id = $this->input->post('campaign_id');
        $campaign = $this->account_model->get_campaign( $campaign_id );

        if( !$campaign ){
            $response = array('status' => 'error', 'message' => 'Email campaign not found. Please contact your web admin for more info. Sorry about that. ');
            echo json_encode( $response );
            exit;
        }

        $this->account_model->delete_email_campaign( $campaign_id );

        echo json_encode(array('status' => 'success', 'message' => 'Done'));

    }

    public function update_opportunity() {

        /*if( !$this->data['user']['is_hotshi_admin'] ) {
            $response = array('status' => 'error', 'message' => 'Access denied. Hotshi Admin only.');
            echo json_encode( $response );
            exit;
        }*/

        $op_id = $this->input->post('opportunity_id');

        $opportunity = $this->account_model->get_user_opportunity( $op_id, $this->user_id );

        if( !$opportunity ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This is project is not longer available. It may have been deleted.'));
            exit;
        }

        if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $image['secure_url'] = null;
        } else {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        if( $image['secure_url'] ) {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => nl2br($this->input->post('description')),
                'skills' => $this->input->post('skills'),
                'qualifications' => $this->input->post('qualifications'),
                'location' => $this->input->post('location'),
                'image' => $image['secure_url'],
                'image_bytes' => $bytes,
                'image_public_id' => $public_id
            );
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => nl2br($this->input->post('description')),
                'skills' => $this->input->post('skills'),
                'qualifications' => $this->input->post('qualifications'),
                'location' => $this->input->post('location')
            );
        }

        if( $this->account_model->update_opportunity( $data, $op_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Opportunity updated.', 'alert' => 'Project updated.', 'redirect' => '/page/jobs/my'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating opportunity. Try again in a little bit.'));
        }

        exit;

    }

    public function update_project() {

        $op_id = $this->input->post('project_id');

        $opportunity = $this->account_model->get_user_project( $op_id, $this->user_id );

        if( !$opportunity ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This is project is not longer available. It may have been deleted.'));
            exit;
        }

        if(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) {
            $image['secure_url'] = null;
        } else {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        if( $image['secure_url'] ) {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => nl2br($this->input->post('description')),
                'skills' => $this->input->post('skills'),
                'qualifications' => $this->input->post('qualifications'),
                'location' => $this->input->post('location'),
                'image' => $image['secure_url'],
                'image_bytes' => $bytes,
                'image_public_id' => $public_id
            );
        } else {
            $data = array(
                'title' => $this->input->post('title'),
                'description' => nl2br($this->input->post('description')),
                'skills' => $this->input->post('skills'),
                'qualifications' => $this->input->post('qualifications'),
                'location' => $this->input->post('location')
            );
        }

        if( $this->account_model->update_project( $data, $op_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Project updated.', 'alert' => 'Project updated', 'redirect' => '/page/projects/my'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating project. Try again in a little bit.'));
        }

        exit;

    }

    public function activate_opportunity() {

        $opportunity_id = $this->input->post('opportunity_id');
        $opportunity = $this->account_model->get_opportunity($opportunity_id);

        if( !$opportunity ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This opportunity no longer exists. It may have been deleted.'));
            exit;
        }

        if( !$this->data['user']['is_hotshi_admin'] ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }

        $data = array(
            'is_active' => 1
        );

        if( !$this->account_model->activate_opportunity( $data, $opportunity_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating opportunity. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'message' => 'Opportunity activated.'));

        $user = $this->account_model->get_user_details( $opportunity['user_id'] );
        $this->data['email_data'] = array(
            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'receiver_fullname' => $user['fullname']
        ); $this->sendmail('job_posting_approved', 'Congrats! Your Job Posting was approved.', $this->data);

    }

    public function activate_project() {

        $project_id = $this->input->post('project_id');
        $project = $this->account_model->get_project($project_id);

        if( !$project ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This project no longer exists. It may have been deleted.'));
            exit;
        }

        if( !$this->data['user']['is_hotshi_admin'] ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }

        $data = array(
            'is_active' => 1
        );

        if( !$this->account_model->activate_project( $data, $project_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating opportunity. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'message' => 'Project activated!'));

        $user = $this->account_model->get_user_details( $project['user_id'] );
        $this->data['email_data'] = array(
            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'receiver_fullname' => $user['fullname']
        ); $this->sendmail('project_approved', 'Congrats! Your project was approved.', $this->data);

    }

    public function deactivate_opportunity() {

        $opportunity_id = $this->input->post('opportunity_id');
        $opportunity = $this->account_model->get_opportunity($opportunity_id);

        if( !$opportunity ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This opportunity no longer exists. It may have been deleted.'));
            exit;
        }

        if( !$this->data['user']['is_hotshi_admin'] ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }

        $data = array(
            'is_active' => 0
        );

        if( !$this->account_model->deactivate_opportunity( $data, $opportunity_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating opportunity. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'message' => 'Opportunity de-activated.'));
        exit;

    }

    public function deactivate_project() {

        $project_id = $this->input->post('project_id');
        $project = $this->account_model->get_project($project_id);

        if( !$project ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! This project no longer exists. It may have been deleted.'));
            exit;
        }

        if( !$this->data['user']['is_hotshi_admin'] ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }

        $data = array(
            'is_active' => 0
        );

        if( !$this->account_model->deactivate_project( $data, $project_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating project. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'message' => 'Project de-activated.'));
        exit;

    }

    public function delete_opportunity() {

        $opportunity_id = $this->input->post('opportunity_id');
        $opportunity = $this->account_model->get_opportunity($opportunity_id);

        if( $opportunity['user_id'] != $this->user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }

        if( !$this->account_model->delete_opportunity( $opportunity_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem deleting opportunity. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'message' => 'Opportunity deleted.'));
        exit;

    }

    public function delete_project() {

        $project_id = $this->input->post('project_id');
        $project = $this->account_model->get_project($project_id);

        if( $project['user_id'] != $this->user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }

        if( !$this->account_model->delete_project( $project_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem deleting opportunity. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'success', 'message' => 'Project deleted.'));
        exit;

    }

    public function apply_for_opportunity() {

        $opportunity_id = $this->input->post('opportunity_id');
        $msg = $this->input->post('message');
        $opportunity = $this->account_model->get_opportunity($opportunity_id);

        if( $opportunity['user_id'] == $this->user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'You cannot apply for an opportunity you created. Please contact Hotshi admin for more details.'));
            exit;
        }

        $user = $this->account_model->get_user_details( $opportunity['user_id'] );

        ////////////
        $receiver_id = $opportunity['user_id'];

        if( !trim($msg) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a message.'));
            exit;
        }

        $receiver = $this->account_model->get_user_details($receiver_id);

        if( !$receiver || !$receiver['is_active'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Receiver account is no longer active. Sorry about that.'));
            exit;
        }

        $message_map = array(
            'user_a_id' => $this->user_id,
            'user_b_id' => $receiver_id
        );

        $message = array(
            'description' => nl2br('RE: <b>'.$opportunity['title'].'</b><br><br>'.$msg),
            'sender_user_id' => $this->user_id,
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

        echo json_encode(array('status' => 'success', 'message' => 'Application sent! We\'ll be in touch.'));
        exit;

    }

    public function apply_for_project() {

        $project_id = $this->input->post('project_id');
        $msg = $this->input->post('message');
        $project = $this->account_model->get_project($project_id);

        if( $project['user_id'] == $this->user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'Our record indicates this project currently belongs to you. Please contact Hotshi admin for more details.'));
            exit;
        }

        //$user = $this->account_model->get_user_details( $project['user_id'] );

        ////////////
        $receiver_id = $project['user_id'];

        if( !trim($msg) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Please enter a message.'));
            exit;
        }

        $receiver = $this->account_model->get_user_details($receiver_id);

        if( !$receiver || !$receiver['is_active'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Receiver account is no longer active. Sorry about that.'));
            exit;
        }

        $message_map = array(
            'user_a_id' => $this->user_id,
            'user_b_id' => $receiver_id
        );

        $message = array(
            'description' => nl2br('RE: <b>'.$project['title'].'</b><br><br>'.$msg),
            'sender_user_id' => $this->user_id,
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
            'applicant_fullname' => $this->data['user']['fullname'],
            'applicant_id' => $this->data['user']['id']

        ); $this->sendmail('new_project_proposal', 'Someone likes your project on Hotshi.', $this->data);

        echo json_encode(array('status' => 'success', 'message' => 'Message sent! The user will be in touch if they are interested in your proposal.'));
        exit;

    }

    public function remove_article_image() {

        $article_id = $this->input->post('article_id');

        $article = $this->account_model->get_article($article_id);

        if( !$article ) {
            echo json_encode(array('status' => 'error', 'message' => 'Article not found!.'));
            exit;
        }

        if( $article['image_public_id'] ) {
            \Cloudinary\Uploader::destroy( $article['image_public_id'] );
        }

        $data = array(
            'image' => null,
            'image_bytes' => '',
            'image_public_id' => ''
        );

        if( !$this->account_model->update_article( $data, $article['id'], $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing photo. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Image deleted.', 'imgsrc' => get_default_post_img()));
        exit;

    }

    public function update_article_img() {

        $article_id = $this->input->post('article_id');

        $article = $this->account_model->get_article($article_id);

        if( $article['user_id'] != $this->user_id ){
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Access denied. Please refresh your browser and try again.'));
            exit;
        }

        // check if removing or updating
        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'posts', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        // update image link or delete from Cloudinary
        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';

            if( $article['image_public_id'] ) {
                \Cloudinary\Uploader::destroy( $article['image_public_id'] );
            }
        }

        $data = array(
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        if( !$this->account_model->update_article_img( $data, $article_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating image. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Image updated. <a href="/page/article/'.$article_id.'" class="bold">Click here</a> to view article.', 'imgsrc' => $image['secure_url']));
        exit;

    }

    public function delete_article() {

        $article_id = $this->input->post('article_id');
        $article = $this->account_model->get_article($article_id);

        if( $article && $article['user_id'] == $this->user_id ) {

            if( $this->account_model->delete_article( $article_id ) ) {
                $this->session->set_flashdata('article_deleted', 'Your article was deleted');
                echo json_encode(array('status' => 'ok', 'message' => 'Article deleted.'));
            } else {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem deleting article'));
            }

        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Unauthorised or article no longer exists.'));
            exit;
        }

    }

    public function upload_cv() {

        $ext = '';

        if( isset($_FILES['file']) ) {

            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            $doc = $this->upload_doc($_FILES['file']['tmp_name']);
        } else {
            $doc['secure_url'] = null;
        }

        if( $doc['secure_url'] ) {
            $bytes = $doc['bytes'];
            $public_id = $doc['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'cv' => $doc['secure_url'],
            'cv_bytes' => $bytes,
            'cv_public_id' => $public_id,
            'cv_extension' => $ext
        );

        $done = $this->account_model->update_details( $data, $this->user_id );

        if( !$done ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem uploading CV. Please try again in a little bit.'));
            exit;
        }

        $this->session->set_flashdata('cv_uploaded', 'Your CV was uploaded');
        $response = array('status' => 'success', 'message' => 'CV uploaded');
        echo json_encode( $response );

        /* notify admin */
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'page/profile/'.$this->user_id.'">'.$this->data['user']['fullname'].'</a> uploaded a CV.<br><p>You can view/download CV by clicking <a href="'.$doc['secure_url'].'">here</a>.</p>'
        ); $this->send_admin_email('New CV Uploaded', $this->data);

    }

    public function delete_cv() {

        if( $this->data['user']['cv_public_id'] ){
            \Cloudinary\Uploader::destroy( $this->data['user']['cv_public_id'] );
        }

        $data = array(
            'cv' => '',
            'cv_bytes' => '',
            'cv_public_id' => ''
        );

        $this->account_model->update_details( $data, $this->user_id );

        $this->session->set_flashdata('cv_deleted', 'Your CV was deleted');
        $response = array('status' => 'ok', 'message' => 'CV deleted');
        echo json_encode( $response );

    }


    public function enrol() {

        $course_id = $this->input->post('course_id');
        $course = $this->account_model->get_course($course_id);

        if( !$course ) {
            echo json_encode(array('status' => 'error', 'message' => 'Sorry, this course no longer exists.'));
            exit;
        }

        if( !$course || !$course['can_enrol'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'This course is currently inactive. Check again in a little bit.'));
            exit;
        }

        if( $course['cert_cost'] ) {
            $is_made_payment = $this->account_model->get_paid_cert_user( $this->user_id, $course['id'] );
        } else {
            $is_made_payment = true;
        }

        if( !$is_made_payment ) {
            echo json_encode(array('status' => 'error', 'message' => 'Payment required before you can enrol in this course. Please contact Hotshi for more details.'));
            exit;
        }

        $data = array(
            'user_id' => $this->user_id,
            'course_id' => $course_id,
            'is_completed_course' => 0,
            'is_left_course' => 0
        );

        if( !$this->account_model->enrol( $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem enrolling. Try again in a little bit.'));
            exit;
        }

        $response = array('status' => 'success');
        echo json_encode( $response );

        //////
        $this->data['email_data'] = array(
            'email' => $this->data['user']['email'],
            'firstname' => $this->data['user']['firstname'],
            'course_title' => $course['title'],
            'course_creator' => $course['organisation_name'],
            'org_id' => $course['organisation_id'],
            'course_id' => $course['id']
        ); $this->sendmail('new_enrollment', 'You are enrolled', $this->data);

    }

    public function unenroll() {

        $course_id = $this->input->post('course_id');

        $this->account_model->unenroll( $this->session->userdata('id'), $course_id );

        $response = array('status' => 'success');
        echo json_encode( $response );

    }

    public function add_student_test_answers() {

        $lesson_id = $this->input->post('lesson_id');
        $lesson = $this->account_model->get_lesson( $lesson_id );
        $organisation_id = $this->input->post('organisation_id');

        if( !$this->account_model->is_enrolled_in_course( $this->user_id, $lesson['course_id']) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $questions = $this->input->post('questions');
        $qids = $questions['qid'];

        //validate answers

        if( !isset($questions['answers'])  ) {
            echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 1 answer for every question.'));
            exit;
        }

        foreach( $qids as $qid ) {

            if( !isset($questions['answers'][$qid]) ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 1 answer for every question.'));
                exit;
            }

            $answers = $questions['answers'][$qid];

            if( !$answers['text'] || count($answers['text']) < 1 ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 1 answer for every question.'));
                exit;
            }

            $bool_count = 0;
            foreach($answers['is_correct'] as $bool) {
                if($bool) {
                    $bool_count++;
                }
            }

            if( $bool_count == 0 ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please select at least one answer for every question.'));
                exit;
            }

        }

        foreach( $qids as $qid ) {

            $answers = $questions['answers'][$qid];

            $answers_arr = array();
            $answers_bool_arr = array();
            foreach( $answers['text'] as $text ) { $answers_arr[] = $text; }
            foreach( $answers['is_correct'] as $bool ) { $answers_bool_arr[] = $bool; }

            $len = count($answers_arr);

            for( $i = 0; $i < $len; $i++ ) {

                $data = array(
                    'lesson_test_question_id' => $qid,
                    'user_id' => $this->user_id,
                    'answer' => $answers_arr[$i],
                    'is_correct_answer' => $answers_bool_arr[$i],
                    'lesson_id' => $lesson_id
                );

                $this->account_model->add_student_test_answers($data);
                //echo json_encode(array('qid' => $qid, 'answer' => $answers_arr[$i], 'is_correct' => $answers_bool_arr[$i]));
            }

        }

        $tutor_lesson_test = $this->account_model->get_lesson_test($lesson['id']);
        $user_lesson_test = $this->account_model->get_user_lesson_test($lesson['id'], $this->user_id);
        $num_passed_questions = 0;
        $tutor_questions_temp = $tutor_lesson_test['questions'];
        $user_questions = $user_lesson_test['questions'];
        $q_len = count($tutor_questions_temp);

        for( $i = 0; $i < $q_len; $i++ ) {
            $answers_len = count($tutor_questions_temp[$i]['answers']);
            for( $j = 0; $j < $answers_len; $j++ ) {
                if( $tutor_questions_temp[$i]['answers'][$j]['is_correct_answer'] &&  $user_questions[$i]['answers'][$j]['is_correct_answer'] ) {

                } else {
                    unset($tutor_questions_temp[$i]['answers'][$j]);
                }
            }
        }

        for( $i = 0; $i < $q_len; $i++ ) {
            if( count($tutor_questions_temp[$i]['answers']) >= 1 ) {
                $num_passed_questions++;
            }
        }

        $this->data['num_questions'] = $q_len;
        $this->data['num_passed_questions'] = $num_passed_questions;

        echo json_encode(array('status' => 'ok', 'message' => '<p>You scored: <span style="font-size:15px !important;"><b>'.$num_passed_questions.'</b> / <b>'.$q_len.'</b></span></p> <p>Your answers have been saved. <a href="/org/lessons/'.$organisation_id.'/'.$lesson['course_id'].'">Return to lessons</a></p>', 'hideform' => 'true', 'noreset' => 'true'));
        exit;

    }

    public function follow_org() {

        $org_id = $this->input->post('org_id');
        $this->account_model->follow_org( $org_id, $this->user_id );
        $response = array('status' => 'success');
        echo json_encode( $response );

        $org_admin = $this->account_model->get_org_admin($org_id);
        $user = $this->account_model->get_user_details( $org_admin['user_id'] );

        $this->data['email_data'] = array(

            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'receiver_fullname' => $user['fullname'],
            'follower_fullname' => $this->data['user']['fullname'],
            'follower_id' => $this->data['user']['id']

        ); $this->sendmail('new_follower', 'New follower on Hotshi.', $this->data);

    }

    public function unfollow_org() {

        $org_id = $this->input->post('org_id');
        $this->account_model->unfollow_org( $org_id, $this->user_id );
        $response = array('status' => 'success');
        echo json_encode( $response );

    }

    public function enable_course_creation() {

        $org_id = $this->input->post('org_id');
        if( !$this->data['user']['is_hotshi_admin'] ) {
            $response = array('status' => 'error', 'message' => 'Access denied. You\'re not a Hotshi Admin.');
            echo json_encode( $response );
            exit;
        }

        $data = array(
            'can_create_course' => 1
        );

        if( $this->account_model->update_course_creation_status( $org_id, $data ) ) {
            $response = array('status' => 'success', 'message' => 'Done! This organisation can now create courses on Hotshi');
            echo json_encode( $response );
        } else {
            $response = array('status' => 'error', 'message' => 'Oops! Something went wrong. Try again in a little bit.');
            echo json_encode( $response );
        }

    }

    public function disable_course_creation() {

        $org_id = $this->input->post('org_id');
        if( !$this->data['user']['is_hotshi_admin'] ) {
            $response = array('status' => 'error', 'message' => 'Access denied. You\'re not a Hotshi Admin.');
            echo json_encode( $response );
            exit;
        }

        $data = array(
            'can_create_course' => 0
        );

        if( $this->account_model->update_course_creation_status( $org_id, $data ) ) {
            $response = array('status' => 'success', 'message' => 'Done! This organisation can no longer create courses on Hotshi');
            echo json_encode( $response );
        } else {
            $response = array('status' => 'error', 'message' => 'Oops! Something went wrong. Try again in a little bit.');
            echo json_encode( $response );
        }

    }

    public function create_ad() {

        $start_date = explode('/', $this->input->post('start_date'));
        $end_date = explode('/', $this->input->post('end_date'));

        $start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
        $end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];

        $date1 = new DateTime($start_date);
        $date2 = new DateTime($end_date);
        $duration = $date2->diff($date1)->format("%a");

        $data = array(
            'user_id' => $this->user_id,
            'description' => nl2br($this->input->post('description')),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'charge_per_day' => AD_CHARGE_PER_DAY,
            'duration' => $duration,
            'image' => '',
            'link' => $this->input->post('link')
        );

        $stripe_token = $this->input->post('stripeToken');
        $total_amount = $duration*AD_CHARGE_PER_DAY;
        $this->process_stripe_payment( $stripe_token, $total_amount, 'Ad Payment - '.$this->data['user']['email'] );
        //stripe will auto-exit upon any error. if we get past stripe function, it means payment went through

        $ad_id = $this->account_model->create_ad( $data );

        echo json_encode(array('status' => 'success', 'message' => 'Your ad has been created. You will be notified by Hotshi once activated.', 'ad_id' => $ad_id));

        /* notify admin */
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'page/profile/'.$this->user_id.'">'.$this->data['user']['fullname'].'</a> created an Ad on Hotshi.<br><p>Requires your approval.</p>'
        ); $this->send_admin_email('New Ad Created', $this->data);

    }

    public function upload_ad_image() {

        $ad_id = $this->input->post('ad_id');
        if( isset($_FILES['file']) ) {
            $image = $this->upload_image($_FILES['file']['tmp_name'], 'ads', MAX_POST_IMG_HEIGHT); //file, dir, max_height
        } else {
            $image['secure_url'] = null;
        }

        if( $image['secure_url'] ) {
            $bytes = $image['bytes'];
            $public_id = $image['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $data = array(
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        );

        if( $this->account_model->update_ad( $ad_id, $this->user_id, $data ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Ad image uploaded!'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem uploading Ad image.'));
        }

    }

    public function delete_ad() {

        $ad_id = $this->input->post('ad_id');

        $ad = $this->account_model->get_user_ad( $ad_id, $this->user_id );

        if( !$ad ) {
            echo json_encode(array('status' => 'error', 'message' => 'Sorry, this ad no longer exists. It may have been deleted. Please contact Hotshi for further details.'));
        }

        if( $this->account_model->delete_ad( $ad_id, $this->user_id ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Your Ad was successfully deleted.'));
            if( $ad['image_public_id'] ) {
                \Cloudinary\Uploader::destroy( $ad['image_public_id'] );
            }
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem deleting ad. Try again in a little bit.'));
        }

    }

    public function approve_ad() {
        $ad_id = $this->input->post('ad_id');
        if( !$this->data['user']['is_hotshi_admin'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Access denied. Hotshi admin only.'));
            exit;
        }

        $ad = $this->account_model->get_ad( $ad_id );

        if( !$ad ) {
            echo json_encode(array('status' => 'error', 'message' => 'Sorry. This Ad no longer exists. It may have already been deleted by the original creator. Please reload your web page and try again.'));
        }

        $data = array(
            'is_active' => 1
        );

        if( $this->account_model->update_ad( $ad_id, null, $data ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Ad approved! This Ad will appear on all user feed.'));
            //send email to ad creator
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem approving ad. Try again in a little bit.'));
        }

        $user = $this->account_model->get_user_details( $ad['user_id'] );

        $this->data['email_data'] = array(

            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'receiver_fullname' => $user['fullname'],
            'ad_end_date' => $ad['end_date']

        ); $this->sendmail('ad_approved', 'Congrats! Your Ad was approved.', $this->data);
    }

    public function disapprove_ad() {

        $ad_id = $this->input->post('ad_id');

        if( !$this->data['user']['is_hotshi_admin'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Access denied. Hotshi admin only.'));
            exit;
        }

        $ad = $this->account_model->get_ad( $ad_id );

        if( !$ad ) {
            echo json_encode(array('status' => 'error', 'message' => 'Sorry. This Ad no longer exists. It may have already been deleted by the original creator. Please reload your web page and try again.'));
        }

        $data = array(
            'is_active' => 0
        );

        if( $this->account_model->update_ad( $ad_id, null, $data ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Ad dis-approved. This Ad will no longer appear on user feed.'));
            //send email to ad creator
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem dis-approving ad. Try again in a little bit.'));
        }
    }

    public function update_ad() {

        $ad_id = $this->input->post('ad_id');
        $ad = $this->account_model->get_user_ad( $ad_id, $this->user_id );

        if( !$ad ) {
            echo json_encode(array('status' => 'error', 'message' => 'Sorry, this ad no longer exists. It may have been deleted. Please contact Hotshi for further details.'));
        }

        if( isset($_FILES['file']) && $_FILES['file']['tmp_name'] ) {

            $image = $this->upload_image($_FILES['file']['tmp_name'], 'ads', MAX_PROFILE_IMG_HEIGHT); //file, dir, max_height

            \Cloudinary\Uploader::destroy( $ad['image_public_id'] );

            $data = array(
                'description' => nl2br( $this->input->post('description') ),
                'link' => $this->input->post('link'),
                'image' => $image['secure_url'],
                'image_bytes' => $image['bytes'],
                'image_public_id' => $image['public_id']
            );
        } else {

            $data = array(
                'description' => nl2br( $this->input->post('description') ),
                'link' => $this->input->post('link')
            );
        }

        if( $this->account_model->update_ad( $ad_id, $this->user_id, $data ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Your Ad was successfully updated!', 'alert' => 'Your Ad was successfully updated', 'reload' => 'true'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating Ad. Try again in a little bit.'));
        }

    }

    public function process_cert_payment() {

        $stripe_token = $this->input->post('stripeToken');
        $course_id = $this->input->post('course_id');

        $course = $this->account_model->get_course($course_id);

        if( !$course ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! We\'re sorry. This course no longer exists on Hotshi. Please contact us for further details.', 'alert' => 'Oops! We\'re sorry. This course no longer exists on Hotshi. Please contact us for further details.'));
            exit;
        }

        $total_amount = $course['cert_cost'];
        $this->process_stripe_payment( $stripe_token, $total_amount, 'Certificate payment - '.$this->data['user']['email'] );
        //stripe will auto-exit upon any error. if we get past stripe function, it means payment went through

        //$this->session->set_flashdata('cert_payment_made', '<i class="fa fa-check-circle"></i> Payment successful! Please click the enrol button.');
        //echo json_encode(array('status' => 'success', 'message' => 'Payment successful.', 'reload' => 'true'));

        $data = array(
            'user_id' => $this->user_id,
            'course_id' => $course_id,
            'amount_paid' => $course['cert_cost']
        );

        $this->account_model->insert_cert_payment_record( $data );

        //////////auto enrol user

        $data = array(
            'user_id' => $this->user_id,
            'course_id' => $course_id,
            'is_completed_course' => 0,
            'is_left_course' => 0
        );
        $this->account_model->enrol( $data );
        echo json_encode(array('status' => 'success', 'reload' => 'true'));

        //////
        $this->data['email_data'] = array(
            'email' => $this->data['user']['email'],
            'firstname' => $this->data['user']['firstname'],
            'course_title' => $course['title'],
            'course_creator' => $course['organisation_name'],
            'org_id' => $course['organisation_id'],
            'course_id' => $course['id']
        ); $this->sendmail('new_enrollment', 'You are enrolled', $this->data);

        /////////////////////////

        /* notify admin */
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'page/profile/'.$this->user_id.'">'.$this->data['user']['fullname'].'</a> made a course payment on Hotshi.<br><p>No action required.</p>'
        ); $this->send_admin_email('New Payment Received', $this->data);
    }

    public function invite_friends() {

        //check if user already exists on Hotshi, if so, don't send email.
        $emails = $this->input->post('emails');
        $num_exists = 0;


        for( $i = 0; $i < count($emails); $i++ ) {
            if( $this->account_model->exists_email( $emails[$i] ) ) {
                $num_exists++;
            } else {
                //send email invitation
                $this->data['email_data'] = array(
                    'firstname' => $emails[$i],
                    'email' => $emails[$i],
                    'sender_fullname' => $this->data['user']['fullname']

                ); $this->sendmail('friend_invite', 'Hotshi Invitation', $this->data);
            }
        }

        $success_message = count($emails).' invitations sent!';

        if( $num_exists ) {
            $success_message = (count($emails)-$num_exists).' invitations sent! One or more emails already exists on Hosthi. These were ignored.';
        }

        echo json_encode(array('status' => 'ok', 'message' => $success_message));

    }

    public function delete_feed_comment() {

        $comment_id = $this->input->post('comment_id');
        if( $this->account_model->delete_feed_comment( $this->user_id, $comment_id ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Comment deleted'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Problem deleting comment. Try again in a little bit'));
        }

    }

    public function delete_feed_comment_reply() {

        $comment_reply_id = $this->input->post('comment_reply_id');
        if( $this->account_model->delete_feed_comment_reply( $this->user_id, $comment_reply_id ) ) {
            echo json_encode(array('status' => 'success', 'message' => 'Comment deleted'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Problem deleting comment. Try again in a little bit'));
        }

    }

    public function update_android_device_id() {

        $data = array( 'android_device_id' => $this->input->post('device_id'));
        $this->account_model->update_details( $data, $this->user_id );

    }

    public function send_android_push_notification( $receiver, $title, $message ) {

        if( $receiver['android_device_id'] ) {

            $link = base_url().'account/inbox';

            $device_id = $receiver['android_device_id'];

            $notification = [
                'title' => $title,
                'body' => $message,
                'icon' =>'myIcon',
                'sound' => 'mySound'

            ];

            $extraNotificationData = ["message" => $notification, "link" => "https://hotshi.com/account/inbox?contactid=".$this->user_id];

            $fcmNotification = [
                //'registration_ids' => $tokenList, //multple token array
                'to'        => $device_id, //single token
                'notification' => $notification,
                'data' => $extraNotificationData
            ];

            $headers = [
                'Authorization: key=' . GOOGLE_ANDROID_ACCESS_KEY,
                'Content-Type: application/json'
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
            $result = curl_exec($ch);
            curl_close($ch);
            //echo $result;
        }

    }

}