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

class org_tutor extends Base_Controller {

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

        if( !$this->account_model->is_organisation_user($this->user_id, $this->input->post('organisation_id')) ) {
            echo json_encode( array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        //check if user has verified their email
        if( !$this->data['user']['is_verified'] ) {
            echo json_encode( array('status' => 'error', 'message' => EMAIL_UNVERIFIED_MSG) );
            exit;
        }

    }

    private function upload_doc( $file ) {

        if( empty( $file ) ) {
            return array('secure_url' => null);
        }

        $response = \Cloudinary\Uploader::upload( $file, array('resource_type' => 'auto', 'use_filename' => true) );

        return $response;

    }

    private function upload_lecture( $file ) {

        if( empty( $file ) ) {
            return array('secure_url' => null);
        }

        $response = \Cloudinary\Uploader::upload( $file, array("resource_type" => "video", "quality"=>50, "format" => "mp4", "timeout" => 300) );

        return $response;

    }

    public function add_lesson() {

        $organisation_id = $this->input->post('organisation_id');
        $course_id = $this->input->post('course_id');

        if( $this->is_course_owner($course_id) ) {

            if( isset($_FILES['file']) ) {
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
                'course_id' => $course_id,
                'created_by' => $this->user_id,
                'title' => $this->input->post('title'),
                'description' => nl2br($this->input->post('description')),
                'doc' => $doc['secure_url'],
                'doc_bytes' => $bytes,
                'doc_public_id' => $public_id,
            );

            $lesson_id = $this->account_model->add_lesson( $data );

            if( !$lesson_id ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oop! Problem adding lesson. Try again in a little bit.'));
                exit;
            }

            $this->session->set_flashdata('lesson_added', 'Lesson added! Scroll to lesson and click <b>Update</b> to add lecture vidoes and a test.');
            $response = array('status' => 'success', 'redirect' => '/org/lessons/'.$organisation_id.'/'.$course_id.'');
            echo json_encode( $response );

        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }
    }

    public function add_lecture() {

        $lesson_id = $this->input->post('lesson_id');
        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( !$lesson ) {
            echo json_encode(array('status' => 'error', 'message' => 'This lesson no longer exists. Please contact help@hotshi.com if problem persists.'));
            exit;
        }

        $organisation_id = $this->input->post('organisation_id');

        if( $this->is_course_owner($lesson['course_id']) ) {

            if( isset($_FILES['file']) ) {
                $video = $this->upload_lecture($_FILES['file']['tmp_name']);
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

            $data = array(
                'lesson_id' => $lesson['id'],
                'video_title' => $this->input->post('title'),
                'video' => $video['secure_url'],
                'video_bytes' => $bytes,
                'video_public_id' => $public_id,
            );

            $lecture_id = $this->account_model->add_lecture( $data );

            if( !$lecture_id ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oop! Problem adding lecture. Try again in a little bit.'));
                exit;
            }

            $this->session->set_flashdata('lectures_added', 'New lecture videos added.');
            $response = array('status' => 'ok', 'message' => 'Video uploaded! You can upload another, or go to <a href="/org/lessons/'.$organisation_id.'/'.$lesson['course_id'].'"><b>lessons page</b></a>.', 'lecture_added' => 'true');
            echo json_encode( $response );
            exit;

        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

    }


    public function create_test() {

        $lesson_id = $this->input->post('lesson_id');
        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( !$lesson ) {
            echo json_encode(array('status' => 'error', 'message' => 'This lesson no longer exists. Please contact help@hotshi.com if problem persists.'));
            exit;
        }

        $organisation_id = $this->input->post('organisation_id');

        if( $lesson['test_id'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'A test has already been created for this lesson. You can go to <a href="/org/lessons/'.$organisation_id.'/'.$lesson['course_id'].'" class="bold">lessons page</a> and edit it.'));
            exit;
        }

        if( $this->is_course_owner($lesson['course_id']) ) {

            $data = array(
                'lesson_id' => $lesson['id'],
                'created_by' => $this->user_id,
                'title' => $this->input->post('title'),
                'description' => nl2br($this->input->post('description'))
            );

            $test_id = $this->account_model->create_test( $data );

            if( !$test_id ) {
                echo json_encode(array('status' => 'error', 'message' => 'Oop! Problem creating test. Try again in a little bit.'));
                exit;
            }

            $response = array('status' => 'success', 'redirect' => '/org_tutor/add_test_questions/'.$lesson_id);
            echo json_encode( $response );
            exit;

        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

    }

    public function add_test_questions() {

        $lesson_id = $this->input->post('lesson_id');
        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( !$lesson ) {
            echo json_encode(array('status' => 'error', 'message' => 'This lesson no longer exists. Please contact help@hotshi.com if problem persists.'));
            exit;
        }

        $organisation_id = $this->input->post('organisation_id');

        if( !$lesson['test_id'] ) {
            echo json_encode(array('status' => 'error', 'message' => 'This test no longer exists. Please contact help@hotshi.com if problem persists.'));
            exit;
        }

        if( $this->is_course_owner($lesson['course_id']) ) {

            $questions = $this->input->post('questions');

            $len = count($questions);

            for( $i = 0; $i < $len; $i++ ) {
                $data = array(
                    'lesson_test_id' => $lesson['test_id'],
                    'created_by' => $this->user_id,
                    'question' => $questions[$i],
                );

                $this->account_model->add_test_questions( $data );
            }

            $response = array('status' => 'success', 'redirect' => '/org_tutor/add_test_question_answers/'.$lesson_id);
            echo json_encode( $response );
            exit;

        } else {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

    }

    public function add_tutor_test_answers() {

        $lesson_id = $this->input->post('lesson_id');
        $lesson = $this->account_model->get_lesson( $lesson_id );
        $organisation_id = $this->input->post('organisation_id');

        if( !$this->is_course_owner($lesson['course_id']) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $questions = $this->input->post('questions');
        $qids = $questions['qid'];

        //validate answers

        if( !isset($questions['answers'])  ) {
            echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 2 answers for every question.'));
            exit;
        }

        foreach( $qids as $qid ) {

            if( !isset($questions['answers'][$qid]) ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 2 answers for every question.'));
                exit;
            }

            $answers = $questions['answers'][$qid];

            if( !$answers['text'] || count($answers['text']) < 2 ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 2 answers for every question.'));
                exit;
            }

            $bool_count = 0;
            foreach($answers['is_correct'] as $bool) {
                if($bool) {
                    $bool_count++;
                }
            }

            if( $bool_count == 0 ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please select at least one correct answer for every set of answers.'));
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
                    'created_by' => $this->user_id,
                    'answer' => $answers_arr[$i],
                    'is_correct_answer' => $answers_bool_arr[$i]
                );

                $this->account_model->add_tutor_test_answers($data);
                //echo json_encode(array('qid' => $qid, 'answer' => $answers_arr[$i], 'is_correct' => $answers_bool_arr[$i]));
            }

        }

        $this->session->set_flashdata('answers_added', 'Lesson test created. To update, scroll to lesson and click <b>Update</b></b>.');
        $response = array('status' => 'success', 'redirect' => '/org/lessons/'.$organisation_id.'/'.$lesson['course_id'].'');
        echo json_encode( $response );
        exit;
    }

    public function update_lesson() {

        $lesson_id = $this->input->post('lesson_id');
        $lesson = $this->account_model->get_lesson( $lesson_id );
        $organisation_id = $this->input->post('organisation_id');

        if( !$this->is_course_owner($lesson['course_id']) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $data = array(
            'title' => $this->input->post('title'),
            'description' => nl2br($this->input->post('description'))
        );

        if( !$this->account_model->update_lesson( $lesson['id'], $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating lesson. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Done! Lesson updated.', 'noreset' => 'true'));
        exit;

    }

    public function update_lesson_doc() {

        $lesson_id = $this->input->post('lesson_id');

        $lesson = $this->account_model->get_lesson($lesson_id);

        if( !$lesson ) {
            echo json_encode(array('status' => 'error', 'message' => 'Lesson not found!.'));
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        // check if removing or updating
        if( isset($_FILES['file']) ) {
            $doc = $this->upload_doc($_FILES['file']['tmp_name']);
        } else {
            $doc['secure_url'] = null;
        }

        // update image link or delete from Cloudinary
        if( $doc['secure_url'] ) {
            $bytes = $doc['bytes'];
            $public_id = $doc['public_id'];
        } else {
            $bytes = '';
            $public_id = '';

            if( $lesson['doc_public_id'] ) {
                \Cloudinary\Uploader::destroy( $lesson['doc_public_id'] );
            }
        }

        $data = array(
            'doc' => $doc['secure_url'],
            'doc_bytes' => $bytes,
            'doc_public_id' => $public_id
        );

        if( !$this->account_model->update_lesson( $lesson['id'], $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem updating document. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Document updated.', 'noreset' => 'true'));
        exit;

    }

    public function remove_lesson_doc() {

        $lesson_id = $this->input->post('lesson_id');

        $lesson = $this->account_model->get_lesson($lesson_id);

        if( !$lesson ) {
            echo json_encode(array('status' => 'error', 'message' => 'Lesson not found!.'));
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        if( $lesson['doc_public_id'] ) {
            \Cloudinary\Uploader::destroy( $lesson['doc_public_id'] );
        }

        $data = array(
            'doc' => null,
            'doc_bytes' => '',
            'doc_public_id' => ''
        );

        if( !$this->account_model->update_lesson( $lesson['id'], $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing document. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Document deleted.'));
        exit;

    }

    public function remove_lecture_vid() {
        $lesson_id = $this->input->post('lesson_id');
        $lecture_vid_id = $this->input->post('video_id');
        $lecture_vid_public_id = $this->input->post('vid_public_id');

        $lesson = $this->account_model->get_lesson($lesson_id);

        if( !$lesson ) {
            echo json_encode(array('status' => 'error', 'message' => 'Lesson not found!.'));
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        \Cloudinary\Uploader::destroy( $lecture_vid_public_id );

        if( !$this->account_model->remove_lecture_vid( $lecture_vid_id ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Problem removing video. Try again in a little bit.'));
            exit;
        }

        echo json_encode(array('status' => 'ok', 'message' => 'Video deleted.'));
        exit;
    }

    public function update_tutor_test_answers() {

        $lesson_id = $this->input->post('lesson_id');
        $lesson = $this->account_model->get_lesson( $lesson_id );
        $organisation_id = $this->input->post('organisation_id');

        if( !$this->is_course_owner($lesson['course_id']) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $questions = $this->input->post('questions');
        $qids = $questions['qid'];

        //validate answers

        if( !isset($questions['answers'])  ) {
            echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 2 answers for every question.'));
            exit;
        }

        foreach( $qids as $qid ) {

            if( !isset($questions['answers'][$qid]) ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 2 answers for every question.'));
                exit;
            }

            $answers = $questions['answers'][$qid];

            if( !$answers['text'] || count($answers['text']) < 2 ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please provide at least 2 answers for every question.'));
                exit;
            }

            $bool_count = 0;
            foreach($answers['is_correct'] as $bool) {
                if($bool) {
                    $bool_count++;
                }
            }

            if( $bool_count == 0 ) {
                echo json_encode(array('status' => 'error', 'message' => '* Please select at least one correct answer for every set of answers.'));
                exit;
            }

        }

        foreach( $qids as $qid ) {

            $answers = $questions['answers'][$qid];

            $answers_id_arr = array();
            $answers_arr = array();
            $answers_bool_arr = array();
            foreach( $answers['answer_id'] as $id ) { $answers_id_arr[] = $id; }
            foreach( $answers['text'] as $text ) { $answers_arr[] = $text; }
            foreach( $answers['is_correct'] as $bool ) { $answers_bool_arr[] = $bool; }

            $len = count($answers_arr);

            for( $i = 0; $i < $len; $i++ ) {

                $data = array(
                    'answer' => $answers_arr[$i],
                    'is_correct_answer' => $answers_bool_arr[$i]
                );

                $this->account_model->update_tutor_test_answers($answers_id_arr[$i], $data);
            }

        }

        /*$this->session->set_flashdata('answers_added', 'Lesson test created. To update, scroll to lesson and click <b>Update</b></b>.');
        $response = array('status' => 'success', 'redirect' => '/org/lessons/'.$organisation_id.'/'.$lesson['course_id'].'');
        echo json_encode( $response );
        exit;*/

        echo json_encode(array('status' => 'ok', 'message' => 'Answers updated.', 'noreset' => 'true'));
        exit;

    }

    public function certify() {

        $student_id = $this->input->post('student_id');
        $course_id = $this->input->post('course_id');

        if( !$this->is_course_owner($course_id) || !$this->account_model->is_enrolled_in_course($student_id, $course_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $course = $this->account_model->get_course($course_id);
        $student = $this->account_model->get_user_details($student_id);
        $tutor = $this->account_model->get_user_details($this->user_id);

        if( !$tutor['fullname'] ){
            echo json_encode(array('status' => 'error', 'message' => 'You must add your full name to your user profile before certifying students. Please go to your user profile page and click - edit profile -'));
            exit;
        }

        $data = array(
            'is_certified' => 1,
            'certified_by' => $this->user_id,
            'is_failed' => 0
        );

        if( !$this->account_model->certify( $student_id, $course_id, $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Technical problems. Please try again shortly.'));
            exit;
        }

        $this->data['email_data'] = array(

            'email' => $student['email'],
            'firstname' => $student['firstname'],
            'receiver_fullname' => $student['fullname'],
            'course_title' => $course['title'],
            'course_id' => $course['id']

        ); $this->sendmail('certified', 'Congratulations! You passed.', $this->data);

        echo json_encode(array('status' => 'ok', 'message' => 'Certificate updated.'));
        exit;

    }

    public function failed_course() {

        $student_id = $this->input->post('student_id');
        $course_id = $this->input->post('course_id');

        if( !$this->is_course_owner($course_id) || !$this->account_model->is_enrolled_in_course($student_id, $course_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $course = $this->account_model->get_course($course_id);
        $student = $this->account_model->get_user_details($student_id);

        $data = array(
            'is_certified' => 0,
            'is_failed' => 1,
            'certified_by' => $this->user_id
        );

        if( !$this->account_model->certify( $student_id, $course_id, $data ) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Technical problems. Please try again shortly.'));
            exit;
        }

        $this->data['email_data'] = array(

            'email' => $student['email'],
            'firstname' => $student['firstname'],
            'receiver_fullname' => $student['fullname'],
            'course_title' => $course['title'],
            'course_id' => $course['id'],
            'organisation_id' => $course['organisation_id']

        ); $this->sendmail('failed', 'We\'re sorry.', $this->data);

        echo json_encode(array('status' => 'ok', 'message' => 'Certificate updated.'));
        exit;

    }

    public function grade_lesson_test() {

        $student_id = $this->input->post('student_id');
        $course_id = $this->input->post('course_id');
        $lesson_id = $this->input->post('lesson_id');
        $grade = $this->input->post('grade');
        $tutor_comment = $this->input->post('tutor_comment');

        if( !$this->is_course_owner($course_id) || !$this->account_model->is_enrolled_in_course($student_id, $course_id) ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $grade = $grade == 'pass' ? 'pass' : 'fail';

        $data = array(
            'lesson_id' => $lesson_id,
            'user_id' =>  $student_id,
            'graded_by' =>  $this->user_id,
            'grade' => $grade,
            'tutor_comment' => nl2br($tutor_comment)
        );

        if( !$this->account_model->grade_lesson_test($data) ) {
            echo json_encode(array('status' => 'error', 'message' => 'Oops! Technical problems. Try again in a little bit.'));
            exit;
        }


        echo json_encode(array('status' => 'ok', 'message' => 'Graded updated.', 'noreset' => 'true'));
        exit;
    }

    public function remove_lesson() {
        $course_id = $this->input->post('course_id');
        $lesson_id = $this->input->post('lesson_id');

        if( !$this->is_course_owner($course_id)  ) {
            echo json_encode(array('status' => 'error', 'message' => PERMISSION_ERR_MSG));
            exit;
        }

        $data = array(
            'is_deleted' => 1
        );

        $this->account_model->update_lesson( $lesson_id, $data );
        echo json_encode(array('status' => 'success', 'message' => 'Lesson removed.'));
    }


}