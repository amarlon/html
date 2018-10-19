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

class org_admin extends Base_Controller {

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
        if( !$this->data['user']['is_verified'] ) {
            echo json_encode( array('status' => 'error', 'message' => EMAIL_UNVERIFIED_MSG) );
            exit;
        }

    }

    private function upload_video( $file ) {

        if( empty( $file ) ) {
            return array('secure_url' => null);
        }

        $response = \Cloudinary\Uploader::upload( $file, array("resource_type" => "video", "quality"=>50, "format" => "mp4", "timeout" => 300) );

        return $response;

    }

    private function upload_image( $file, $dir, $max_height ) {

        if( empty( $file ) ) {
            return array('secure_url' => null);
        }

        $response = \Cloudinary\Uploader::upload( $file, array('folder' => $dir, 'crop' => 'limit', 'height' => $max_height) );

        return $response;

    }

    public function create_course() {

        $tutor_id = $this->input->post('tutor_id');
        $organisation_id = $this->input->post('organisation_id');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id ) ) {
            echo json_encode( array('status' => 'error', 'message' => PERMISSION_ERR_MSG) );
            exit;
        }

        //check if tutor belongs to organisation
        if( !$this->account_model->is_organisation_user($tutor_id, $organisation_id) ) {
            echo json_encode( array('status' => 'error', 'message' => 'Selected tutor does not belong to your organisation.') );
            exit;
        }

        if( isset($_FILES['file']) ) {
            $video = $this->upload_video($_FILES['file']['tmp_name']);
        } else {
            $video['secure_url'] = null;
        }

        if( $video['secure_url'] ) {
            $bytes = $video['bytes'];
            $public_id = $video['public_id'];
        } else {
            $bytes = '';
            $public_id = '';
        }

        $start_date = explode('/', $this->input->post('start_date'));
        $end_date = explode('/', $this->input->post('end_date'));

        $start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
        $end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];

        if( $this->input->post('course_type') == 'FREE' ) {
            $cert_cost = 0;
        } else {
            $cert_cost = $this->input->post('cert_cost');
            if ( strval($cert_cost) != strval(intval($cert_cost)) ) {
                echo json_encode(array('status' => 'error', 'message' => 'Error! Please ensure the cost of certificate is a valid round number. E.g. 15, 40, 120, 230, etc.'));
                exit;
            }

            if( intval($cert_cost) < CERT_COST_MIN ) {
                echo json_encode(array('status' => 'error', 'message' => 'Error! The cost of a certificate must be &euro;'.CERT_COST_MIN.' or more.'));
                exit;
            }

            if( intval($cert_cost) > CERT_COST_MAX ) {
                echo json_encode(array('status' => 'error', 'message' => 'Error! The cost of a certificate must be &euro;'.CERT_COST_MAX.' or less.'));
                exit;
            }
        }

        $data = array(
            'organisation_id' => $organisation_id,
            'tutor_id' => $tutor_id,
            'course_category_id' => $this->input->post('course_category_id'),
            'course_level_id' => $this->input->post('course_level_id'),
            'created_by' => $this->session->userdata('id'),
            'title' => $this->input->post('title'),
            'description' => nl2br($this->input->post('description')),
            'can_enrol' => 0,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'intro_video' => $video['secure_url'],
            'intro_video_bytes' => $bytes,
            'intro_video_public_id' => $public_id,
            'cert_cost' => $cert_cost
        );

        $course_id = $this->account_model->create_course( $data );

        if( !$course_id ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem creating course. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'remove_submit_btn'  => 'true', 'message' => '<b><i class="fa fa-check"></i> Course created!</b>. You must active this course before students can enroll. You can do that at any point by visiting the <a href="/org/course/'.$organisation_id.'/'.$course_id.'" class="bold">course page</a>.'));
        exit;

    }

    public function update_course() {

        $organisation_id = $this->input->post('organisation_id');
        $course_id = $this->input->post('course_id');
        $tutor_id = $this->input->post('tutor_id');

        if( $this->is_course_owner($course_id) ){

            if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
                echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
                exit;
            }

            $course = $this->account_model->get_course( $course_id );

            if( !$course ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Course not found. Please ensure this course has not been deleted.'));
                exit;
            }

            if( !$this->account_model->is_organisation_user($tutor_id, $organisation_id) ){
                echo json_encode(array('status' => 'error', 'message' => 'This tutor does not belong in your organisation. Please select another tutor.'));
                exit;
            }

            $start_date = explode('/', $this->input->post('start_date'));
            $end_date = explode('/', $this->input->post('end_date'));

            $start_date = $start_date[2].'-'.$start_date[1].'-'.$start_date[0];
            $end_date = $end_date[2].'-'.$end_date[1].'-'.$end_date[0];

            $data = array(
                'tutor_id' => $tutor_id,
                'course_category_id' => $this->input->post('course_category_id'),
                'course_level_id' => $this->input->post('course_level_id'),
                'title' => $this->input->post('title'),
                'description' => nl2br($this->input->post('description')),
                'start_date' => $start_date,
                'end_date' => $end_date
            );

            if( !$this->account_model->update_course( $course_id, $data ) ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating course. Try again in a little bit.'));
                exit;
            }

            echo json_encode(array('status' => 'ok', 'message' => 'Course updated.', 'noreset' => 'true'));
            exit;

        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

    }

    public function update_course_intro_video() {

        $organisation_id = $this->input->post('organisation_id');
        $course_id = $this->input->post('course_id');

        if( $this->is_course_owner($course_id) ){

            if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
                echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
                exit;
            }

            $course = $this->account_model->get_course( $course_id );

            if( !$course ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Course not found. Please ensure this course has not been deleted.'));
                exit;
            }

            if( isset($_FILES['file']) ) {
                $video = $this->upload_video($_FILES['file']['tmp_name']);
            } else {
                $video['secure_url'] = null;
            }

            // update image link or delete from Cloudinary
            if( $video['secure_url'] ) {
                $bytes = $video['bytes'];
                $public_id = $video['public_id'];
            } else {
                $bytes = '';
                $public_id = '';

                if( $course['intro_video_public_id'] ) {
                    \Cloudinary\Uploader::destroy( $course['intro_video_public_id'] );
                }
            }

            $data = array(
                'intro_video' => $video['secure_url'],
                'intro_video_bytes' => $bytes,
                'intro_video_public_id' => $public_id
            );

            if( !$this->account_model->update_course( $course_id, $data ) ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem uploading video. Try again in a little bit.'));
                exit;
            }

            echo json_encode(array('status' => 'ok', 'message' => 'Video updated.', 'hideform' => 'true'));
            exit;


        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

    }

    public function remove_course_intro_video() {

        $organisation_id = $this->input->post('organisation_id');
        $course_id = $this->input->post('course_id');

        if( $this->is_course_owner($course_id) ){

            if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
                echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
                exit;
            }

            $course = $this->account_model->get_course( $course_id );
            if( !$course ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Course not found. Please ensure this course has not been deleted.'));
                exit;
            }

            if( $course['intro_video_public_id'] ) {
                \Cloudinary\Uploader::destroy( $course['intro_video_public_id'] );
            }

            $data = array(
                'intro_video' => null,
                'intro_video_bytes' => '',
                'intro_video_public_id' => ''
            );

            if( !$this->account_model->update_course( $course_id, $data ) ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing video. Try again in a little bit.'));
                exit;
            }

            echo json_encode(array('status' => 'ok', 'message' => 'Video deleted.'));
            exit;


        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

    }

    public function update_profile_intro_video() {


        $organisation_id = $this->input->post('organisation_id');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $organisation = $this->account_model->get_organisation( $organisation_id );

        if( !$organisation ) {
            echo json_encode(array('status' => 'error', 'message' => 'Yikes! This account seems to have been deactivated. Please contact help@hotshi.com or try again in a little bit.'));
            exit;
        }

        if( isset($_FILES['file']) ) {
            $video = $this->upload_video($_FILES['file']['tmp_name']);
        } else {
            $video['secure_url'] = null;
        }

        // update image link or delete from Cloudinary
        if( $video['secure_url'] ) {
            $bytes = $video['bytes'];
            $public_id = $video['public_id'];
        } else {
            $bytes = '';
            $public_id = '';

            if( $organisation['intro_video_public_id'] ) {
                \Cloudinary\Uploader::destroy( $organisation['intro_video_public_id'] );
            }
        }

        $data = array(
            'intro_video' => $video['secure_url'],
            'intro_video_bytes' => $bytes,
            'intro_video_public_id' => $public_id
        );

        if( !$this->account_model->update_organisation( $organisation_id, $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating video. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Video updated.'));
        exit;


    }

    public function remove_profile_intro_video() {

        $organisation_id = $this->input->post('organisation_id');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $organisation = $this->account_model->get_organisation( $organisation_id );

        if( !$organisation ) {
            echo json_encode(array('status' => 'error', 'message' => 'Yikes! This account seems to have been deactivated. Please contact help@hotshi.com or try again in a little bit.'));
            exit;
        }

        if( $organisation['intro_video_public_id'] ) {
            \Cloudinary\Uploader::destroy( $organisation['intro_video_public_id'] );
        }

        $data = array(
            'intro_video' => null,
            'intro_video_bytes' => '',
            'intro_video_public_id' => ''
        );

        if( !$this->account_model->update_organisation( $organisation_id, $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing video. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Video deleted.'));
        exit;

    }

    public function update_organisation() {

        $organisation_id = $this->input->post('organisation_id');
        $username = $this->input->post('username');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $organisation = $this->account_model->get_organisation($organisation_id);

        //check if username exists
        if( $this->account_model->exists_username(trim($username)) && $username != $organisation['name'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'Yikes! Username already in use. Pick a different one'));
            exit;
        }

        $data = array(
            'name' => $username,
            'website' => $this->input->post('website'),
            'about' => nl2br($this->input->post('about')),
            'country_id' => $this->input->post('country_id'),
            'institution_name' => $this->input->post('institution_name')
        );

        if( !$this->account_model->update_organisation( $organisation_id, $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating details. Try again in a little bit.'));
            exit;
        }

        $data2 = array(
            'username' => $username,
            'fullname' => $username,
            'firstname' => $username
        );

        $this->account_model->update_details( $data2, $this->user_id );

        echo json_encode(array('status' => 'ok', 'message' => 'Details updated.', 'noreset' => 'true'));
        exit;

    }

    public function enable_course_enrolment() {

        $course_id = $this->input->post('course_id');

        if( $this->is_course_owner($course_id) ) {
            $this->account_model->enable_course_enrolment( $course_id, array('can_enrol' => 1) );
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

    }

    public function remove_org_avatar() {

        $organisation_id = $this->input->post('organisation_id');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $organisation = $this->account_model->get_organisation( $organisation_id );

        if( !$organisation ) {
            echo json_encode(array('status' => 'error', 'message' => 'Yikes! This account seems to have been deactivated. Please contact help@hotshi.com or try again in a little bit.'));
            exit;
        }

        if( $organisation['profile_image_public_id'] ) {
            \Cloudinary\Uploader::destroy( $organisation['profile_image_public_id'] );
        }

        $data = array(
            'profile_image' => null,
            'profile_image_bytes' => '',
            'profile_image_public_id' => ''
        );

        if( !$this->account_model->update_organisation( $organisation_id, $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing photo. Try again in a little bit.'));
            exit;
        }

        $data2 = array(
            'image' => null,
            'image_bytes' => '',
            'image_public_id' => ''
        ); $this->account_model->update_avatar( $data2, $this->user_id );

        echo json_encode(array('status' => 'ok', 'message' => 'Photo deleted.', 'imgsrc' => get_default_org_avatar() ));
        exit;

    }

    public function update_avatar() {

        $organisation_id = $this->input->post('organisation_id');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $organisation = $this->account_model->get_organisation( $organisation_id );

        if( !$organisation ) {
            echo json_encode(array('status' => 'error', 'message' => 'Yikes! This account seems to have been deactivated. Please contact help@hotshi.com or try again in a little bit.'));
            exit;
        }

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

            if( $organisation['profile_image_public_id'] ) {
                \Cloudinary\Uploader::destroy( $organisation['profile_image_public_id'] );
            }
        }

        $data = array(
            'profile_image' => $image['secure_url'],
            'profile_image_bytes' => $bytes,
            'profile_image_public_id' => $public_id
        );

        if( !$this->account_model->update_organisation( $organisation_id, $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating photo. Try again in a little bit.'));
            exit;
        }

        $data2 = array(
            'image' => $image['secure_url'],
            'image_bytes' => $bytes,
            'image_public_id' => $public_id
        ); $this->account_model->update_avatar( $data2, $this->user_id );

        echo json_encode(array('status' => 'ok', 'message' => 'Photo updated.', 'imgsrc' => $image['secure_url']));
        exit;

    }

    public function remove_organisation_user() {

        $organisation_id = $this->input->post('organisation_id');
        $tutor_id = $this->input->post('tutor_id');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        if( !$this->account_model->remove_organisation_user( $organisation_id, $tutor_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing user. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'User removed.'));
        exit;

    }

    public function search_user_for_invitation() {

        $organisation_id = $this->input->post('organisation_id');
        $email = $this->input->post('email');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        if( $this->account_model->exists_email($email) ) {

            $user = $this->account_model->get_user( $email, $GLOBALS['MASTER_P'] );

            if( $user['email'] == $this->data['user']['email'] ) { //same user

                $data = array(
                    'status' => 'error',
                    'message' => 'You are already a member of this organisation'
                ); echo json_encode($data);

            } else if( $this->account_model->is_organisation_user( $user['id'], $organisation_id ) ) {

                $data = array(
                    'status' => 'error',
                    'message' => 'This user is already a member of your organisation.'
                ); echo json_encode($data);

            } else {

                $data = array(
                    'status' => 'ok',
                    'found_tutor' => 'true',
                    'user_id' => $user['id'],
                    'fullname' => $user['fullname'],
                    'image' => $user['image'] ? $user['image'] : get_default_avatar()
                ); echo json_encode($data);

            }

        } else {

            $data = array(
                'status' => 'ok',
                'tutor_not_found' => 'true',
                'user_email' => $email
            ); echo json_encode($data);

        }

    }

    public function add_organisation_user() {

        $organisation_id = $this->input->post('organisation_id');
        $user_id = $this->input->post('user_id');
        $user_fullname = $this->input->post('fullname');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $data = array(
            'organisation_id' => $organisation_id,
            'user_id' => $user_id,
            'is_organisation_admin' => 0
        );

        if( !$this->account_model->add_organisation_user( $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem adding user. Try again in a little bit.'));
            exit;
        }

        $user = $this->account_model->get_user_details($user_id);
        $organisation = $this->account_model->get_organisation($organisation_id);

        $this->data['email_data'] = array(
            'email' => $user['email'],
            'firstname' => $user['firstname'],
            'organisation_id' => $organisation['id'],
            'organisation_name' => $organisation['name']

        ); $this->sendmail('org_user_added', 'You were added', $this->data);

        $this->session->set_flashdata('user_added_to_organisation', '<b>'.$user['fullname'].'</b> has been added to your organisation. Their name will appear on your list of tutors when you\'re creating or editing a course.');
        echo json_encode(array('status' => 'ok', 'message' => 'User added'));
        exit;

    }

    public function invite_organisation_user() {

        $email = $this->input->post('email');
        $organisation_id = $this->input->post('organisation_id');

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        /* send email */
        //code

        $token = generate_unique_val();
        $organisation = $this->account_model->get_organisation($organisation_id);

        $data = array(
            'organisation_id' => $organisation_id,
            'email' => $email,
            'token' => $token
        );

        if( !$this->account_model->invite_organisation_user( $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem creating invitation. Try again in a little bit.'));
            exit;
        }

        $this->data['email_data'] = array(
            'email' => $email,
            'firstname' => 'Hi there',
            'organisation_id' => $organisation['id'],
            'organisation_name' => $organisation['name'],
            'activation_token' => $token

        ); $this->sendmail('tutor_invitation', 'Hotshi invitation', $this->data);

        $this->session->set_flashdata('tutor_invited', 'An invitation email has been sent to <b>'.$email.'</b>.');
        echo json_encode(array('status' => 'ok', 'message' => 'User invited'));
        exit;

    }

    public function request_course_creation() {
        $org_id = $this->input->post('organisation_id');
        /* notify admin */
        $org = $this->account_model->get_organisation( $org_id );
        $this->data['email_data'] = array(
            'firstname' => $GLOBALS['ADMIN_NAME'],
            'receiver_fullname' => $GLOBALS['ADMIN_NAME'],
            'message' => 'FYI: User <a href="'.base_url().'org/org_profile/'.$org['id'].'">'.$org['name'].'</a> has requested to create a course on Hotshi. To allow this action, login in as hotshi admin, go to organisataion page, and click ALLOW.'
        ); $this->send_admin_email('Course Creation Request', $this->data);

        echo json_encode(array('status' => 'success', 'message' => 'Admin notified'));
    }

    public function delete_course() {
        if( !$this->data['user']['is_hotshi_admin'] ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        if($this->account_model->delete_course( $this->input->post('course_id') ) ) {
            echo json_encode(array('status' => 'ok', 'message' => 'Course deleted.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Problem deleting course. Try again in a little bit.'));
        }
    }

    public function delete_account() {

        if( !$this->data['user']['is_hotshi_admin'] ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $user_email = $this->input->post('user_email');
        if( $this->account_model->delete_account($user_email) ) {
            echo json_encode(array('status' => 'ok', 'message' => 'Account successfully deleted.'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Problem deleting account. Account may have already been deleted or email does not exist. Please refresh your browser and try again.'));
        }
    }

}