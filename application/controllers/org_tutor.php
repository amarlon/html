<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 29/10/15
 * Time: 1:16 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH . 'core/Base_Controller.php');

class org_tutor extends Base_Controller {

    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();

    }

    public function index() {
        redirect('/');
        exit;
    }

    public function add_lesson( $course_id ) {

        if( $this->is_course_owner( $course_id ) ) {

            $this->data['course'] = $this->account_model->get_course( $course_id );
            //$this->data['crumb'] = 'Add lesson';
            $this->data['lesson_crumb'] = 'true';
            $this->data['hide_buttons'] = 'hide';
            $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);
            $this->data['page_view'] = get_view('app', 'org_tutor/add_lesson', $this->data);
            $this->load->view('templates/main', $this->data);

        } else {
            redirect('/');
            exit;
        }

    }

    public function add_lectures( $lesson_id ) {

        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( !$lesson_id ) {
            redirect('/');
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            redirect('/');
            exit;
        }

        if( !trim($lesson['title']) ) {
            $lesson['title'] = $this->input->get('title');
        }

        $this->data['lesson'] = $lesson;
        $this->data['course'] = $this->account_model->get_course( $lesson['course_id'] );
        $this->data['crumb'] = $lesson['title'];
        $this->data['lesson_crumb'] = 'true';
        $this->data['hide_buttons'] = 'hide';
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);
        $this->data['page_view'] = get_view('app', 'org_tutor/add_lectures', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function create_test( $lesson_id ) {

        if( !$lesson_id ) {
            redirect('/');
            exit;
        }

        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( $lesson['test_id'] ) {
            redirect('/');
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            redirect('/');
            exit;
        }

        $this->data['lesson'] = $lesson;
        $this->data['course'] = $this->account_model->get_course( $lesson['course_id'] );
        $this->data['hide_date'] = 'hide';
        $this->data['crumb'] = $lesson['title'];
        $this->data['lesson_crumb'] = 'true';
        $this->data['hide_buttons'] = 'hide';
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);

        $this->data['page_view'] = get_view('app', 'org_tutor/create_test', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function add_test_questions( $lesson_id ) {

        if( !$lesson_id ) {
            redirect('/');
            exit;
        }

        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( !$lesson ) {
            redirect('/');
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            redirect('/');
            exit;
        }

        $this->data['lesson'] = $lesson;
        $this->data['course'] = $this->account_model->get_course( $lesson['course_id'] );
        $this->data['crumb'] = $lesson['title'];
        $this->data['hide_date'] = 'hide';
        $this->data['lesson_crumb'] = 'true';
        $this->data['hide_buttons'] = 'hide';
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);

        $this->data['page_view'] = get_view('app', 'org_tutor/add_questions', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function add_test_question_answers( $lesson_id ) {

        if( !$lesson_id ) {
            redirect('/');
            exit;
        }

        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( !$lesson ) {
            redirect('/');
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            redirect('/');
            exit;
        }

        $this->data['lesson'] = $lesson;
        $this->data['course'] = $this->account_model->get_course( $lesson['course_id'] );
        $this->data['crumb'] = $lesson['title'];
        $this->data['lesson_crumb'] = 'true';
        $this->data['hide_buttons'] = 'hide';
        $this->data['hide_date'] = 'hide';
        $this->data['lesson_test'] = $this->account_model->get_lesson_test($lesson['id']);
        //$this->data['test_questions'] = $this->account_model->get_test_questions($this->data['lesson_test']['id']);
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);

        $this->data['page_view'] = get_view('app', 'org_tutor/add_question_answers_tutor', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function update_lesson( $lesson_id ) {

        if( !$lesson_id ) {
            redirect('/');
            exit;
        }

        $lesson = $this->account_model->get_lesson( $lesson_id );

        if( !$lesson ) {
            redirect('/');
            exit;
        }

        if( !$this->is_course_owner($lesson['course_id']) ) {
            redirect('/');
            exit;
        }

        $this->data['lesson'] = $lesson;
        $this->data['lesson']['lesson_lectures'] = $this->account_model->get_lesson_lectures($lesson['id']);
        //dump($lesson);exit;
        $this->data['course'] = $this->account_model->get_course( $lesson['course_id'] );
        $this->data['crumb'] = $lesson['title'];
        $this->data['lesson_crumb'] = 'true';
        $this->data['hide_buttons'] = 'hide';
        $this->data['hide_date'] = 'hide';
        $this->data['lesson_test'] = $this->account_model->get_lesson_test($lesson['id']);
        //$this->data['test_questions'] = $this->account_model->get_test_questions($this->data['lesson_test']['id']);
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);

        $this->data['page_view'] = get_view('app', 'org_tutor/update_lesson', $this->data);
        $this->load->view('templates/main', $this->data);


    }

    public function course_students( $course_id ) {

        if( !$course_id || !$this->is_course_owner($course_id) ) {
            redirect('/');
            exit;
        }

        $course = $this->account_model->get_course($course_id);

        if( !$course ) {
            redirect('/');
            exit;
        }

        $course_students = $this->account_model->get_course_students( $course_id );

        $this->data['course'] = $course;
        $this->data['course_tests'] = $this->account_model->get_course_tests($course['id']);

        $this->data['is_course_owner'] = $this->is_course_owner( $course_id );
        $this->data['course_students'] = $course_students;
        //$this->data['lessons'] = $lessons;
        $this->data['crumb'] = 'Students';
        $this->data['num_course_students'] = $this->analytics_model->get_num_course_students( $course_id );
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);
        $this->data['course_page_menu'] = get_view('crumbs', 'course_page_menu', $this->data);
        $this->data['page_title'] = 'Lessons, '.$this->data['course']['title'];
        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['page_view'] = get_view('app', 'org_tutor/course_students', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function certify( $course_id ) {

        if( !$course_id || !$this->is_course_owner($course_id) ) {
            redirect('/');
            exit;
        }

        $course = $this->account_model->get_course($course_id);

        if( !$course ) {
            redirect('/');
            exit;
        }

        $this->data['course'] = $course;

        $this->data['is_course_owner'] = $this->is_course_owner( $course_id );
        $this->data['course_students'] = $this->account_model->get_course_students( $course_id );
        $this->data['num_course_students'] = $this->analytics_model->get_num_course_students( $course_id );
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);
        $this->data['course_page_menu'] = get_view('crumbs', 'course_page_menu', $this->data);
        $this->data['page_title'] = 'Certify, '.$this->data['course']['title'];
        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['page_view'] = get_view('app', 'org_tutor/certify', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function grade_lesson_test( $course_id, $lesson_id, $student_id ) {

        if( !$course_id || !$lesson_id || !$student_id ) {
            redirect('/');
            exit;
        }

        $course = $this->account_model->get_course($course_id);
        $lesson = $this->account_model->get_lesson( $lesson_id );
        $course_student = $this->account_model->get_user_details( $student_id );

        if( !$course || !$course_student || !$lesson ) {
            redirect('/');
            exit;
        }

        //$this->data['is_completed_lesson_test'] = $this->account_model->is_completed_lesson_test( $lesson_id, $student_id );

        $this->data['lesson'] = $lesson;
        $this->data['course'] = $course;
        $this->data['crumb'] = $lesson['title'];
        $this->data['lesson_crumb'] = 'true';
        $this->data['hide_buttons'] = 'hide';
        $this->data['hide_date'] = 'hide';
        $this->data['course_student'] = $course_student;

        $user_lesson_test = $this->account_model->get_user_lesson_test($lesson['id'], $student_id);
        $tutor_lesson_test = $this->account_model->get_lesson_test($lesson['id']);

        $this->data['lesson_test'] = $user_lesson_test;
        $this->data['lesson_test_grades'] = $this->account_model->get_lesson_test_grades( $lesson['id'], $course_student['id'] );
        $this->data['num_questions'] = count($user_lesson_test['questions']);

        $num_passed_questions = 0;
        $tutor_questions_temp = $tutor_lesson_test['questions'];
        $user_questions = $user_lesson_test['questions'];
        $q_len = count($tutor_questions_temp);

        if( $user_lesson_test['questions'][0]['answers'] ) {
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

        }

        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);

        $this->data['page_view'] = get_view('app', 'org_tutor/grade_lesson_test', $this->data);
        $this->load->view('templates/main', $this->data);
    }

}