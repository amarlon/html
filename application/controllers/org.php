<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 29/10/15
 * Time: 1:16 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH . 'core/Base_Controller.php');

////////////////////
// PUBLIC PAGES   //
////////////////////

class org extends Base_Controller {

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

    public function courses( $category_id=null, $level_id=null ) {

        $this->data['course_levels'] = $this->account_model->get_course_levels();

        $this->data['course_category_id'] = $category_id ? $category_id : '0';
        $this->data['course_level_id'] = $level_id ? $level_id : '0';

        $this->data['courses'] = $this->account_model->get_courses( $this->data['course_category_id'], $this->data['course_level_id'] );

        $this->data['course_category'] = $this->account_model->get_course_category( $this->data['course_category_id'] );

        $this->data['course_level'] = $this->account_model->get_course_level( $this->data['course_level_id'] );

        $this->data['page_view'] = get_view('pages', 'courses', $this->data);
        $this->load->view('templates/main', $this->data);
    }

    public function course( $organisation_id, $course_id ) {

        $organisation = $this->account_model->get_organisation( $organisation_id );
        $course = $this->account_model->get_course( $course_id );

        if( !$organisation || !$course ) {
            redirect('/');
            exit;
        }

        if( $course['cert_cost'] ) {
            $is_made_payment = $this->account_model->get_paid_cert_user( $this->user_id, $course['id'] );
        } else {
            $is_made_payment = true;
        }

        $this->data['is_made_payment'] = $is_made_payment;
        $this->data['is_organisation_admin'] = $this->account_model->is_organisation_admin($this->user_id, $organisation_id);
        $this->data['is_course_owner'] = $this->is_course_owner( $course_id );
        $this->data['is_enrolled_in_course'] = $this->account_model->is_enrolled_in_course( $this->user_id, $course_id );
        $this->data['num_course_students'] = $this->analytics_model->get_num_course_students( $course_id );
        $this->data['num_course_lectures'] = $this->analytics_model->get_num_course_lectures( $course_id );
        $this->data['course'] = $course;
        $this->data['crumb'] = 'Overview';
        $this->data['course_status_info'] = get_view('crumbs', 'course_status_info', $this->data);
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);
        $this->data['course_page_menu'] = get_view('crumbs', 'course_page_menu', $this->data);
        $this->data['page_title'] = $this->data['course']['title'];
        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['page_view'] = get_view('pages', 'course', $this->data);
        $this->load->view('templates/main', $this->data);
    }

    public function lessons( $organisation_id, $course_id ) {

        $organisation = $this->account_model->get_organisation( $organisation_id );
        $course = $this->account_model->get_course( $course_id );

        if( !$organisation || !$course ) {
            redirect('/');
            exit;
        }

        if( $course['cert_cost'] ) {
            $is_made_payment = $this->account_model->get_paid_cert_user( $this->user_id, $course['id'] );
        } else {
            $is_made_payment = true;
        }

        $this->data['is_made_payment'] = $is_made_payment;

        $lessons = $this->account_model->get_course_lessons( $course_id );

        $this->data['is_organisation_admin'] = $this->account_model->is_organisation_admin($this->user_id, $organisation_id);
        $this->data['is_course_owner'] = $this->is_course_owner( $course_id );

        $len = count($lessons);

        for( $i = 0; $i < $len; $i++ ) {
            $lessons[$i]['lesson_lectures'] = $this->account_model->get_lesson_lectures( $lessons[$i]['id'] );
        }

        $this->data['course'] = $course;
        $this->data['lessons'] = $lessons;
        $this->data['crumb'] = 'Lessons';
        //$this->data['hide_date'] = 'hide';
        $this->data['is_enrolled_in_course'] = $this->account_model->is_enrolled_in_course( $this->user_id, $course_id );
        $this->data['num_course_students'] = $this->analytics_model->get_num_course_students( $course_id );
        $this->data['course_status_info'] = get_view('crumbs', 'course_status_info', $this->data);
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);
        $this->data['course_page_menu'] = get_view('crumbs', 'course_page_menu', $this->data);
        $this->data['page_title'] = 'Lessons, '.$this->data['course']['title'];
        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['page_view'] = get_view('pages', 'lessons', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function org_profile( $organisation_id ) {

        $organisation = $this->account_model->get_organisation( $organisation_id );

        if( !isset($organisation['id']) ) {
            redirect('/');
            exit;
        }

        $this->data['page_title'] = $organisation['name'];
        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['organisation'] = $organisation;
        $this->data['is_organisation_admin'] = $this->account_model->is_organisation_admin($this->user_id, $organisation_id);
        $this->data['tutors'] = $this->account_model->get_organisation_tutors( $organisation_id );
        $this->data['organisation_courses'] = $this->account_model->get_organisation_courses( $organisation_id );
        $this->data['is_contact'] = true;
        $org_admin = $this->account_model->get_org_admin($organisation_id);
        $this->data['org_admin_id'] = $org_admin['user_id'];

        if( $this->is_logged_in() && isset($_GET['posts']) ) {
            $posts = $this->account_model->get_posts( $org_admin['user_id'] );
        } else {
            $posts = array();
        }

        $this->data['message_user_modal'] = get_view('crumbs/modals/forms', 'message_user_modal', $this->data);
        $this->data['projects'] = $this->account_model->get_profile_projects($org_admin['user_id']);
        $this->data['jobs'] = $this->account_model->get_profile_jobs($org_admin['user_id']);

        $this->data['posts'] = $posts;
        $this->data['posts_feed'] = get_view('crumbs', 'posts_feed', $this->data);

        $this->data['page_view'] = get_view('pages', 'organisation', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function discussions( $organisation_id, $course_id, $post_id=null ) {

        $organisation = $this->account_model->get_organisation( $organisation_id );
        $course = $this->account_model->get_course( $course_id );

        if( !$organisation || !$course ) {
            redirect('/');
            exit;
        }

        $is_org_admin = $this->account_model->is_organisation_admin($this->user_id, $organisation_id);
        $is_course_owner = $this->is_course_owner( $course_id );
        $is_enrolled_in_course = $this->account_model->is_enrolled_in_course( $this->user_id, $course_id );

        if( $is_org_admin || $is_course_owner || $is_enrolled_in_course ) {
            $this->data['can_view_discussions'] = true;
        } else {
            $this->data['can_view_discussions'] = false;
        }

        $this->data['is_organisation_admin'] = $is_org_admin;
        $this->data['is_course_owner'] = $is_course_owner;
        $this->data['is_enrolled_in_course'] = $is_enrolled_in_course;
        $this->data['num_course_students'] = $this->analytics_model->get_num_course_students( $course_id );
        $this->data['num_course_lectures'] = $this->analytics_model->get_num_course_lectures( $course_id );
        $this->data['course'] = $course;
        $this->data['crumb'] = 'Overview';
        $this->data['course_status_info'] = get_view('crumbs', 'course_status_info', $this->data);
        $this->data['course_breadcrumb'] = get_view('crumbs', 'course_breadcrumb', $this->data);
        $this->data['course_page_menu'] = get_view('crumbs', 'course_page_menu', $this->data);
        $this->data['page_title'] = 'Discussions, '.$this->data['course']['title'];
        $this->data['header'] = get_view('layout/header', 'header', $this->data);


        $posts = $this->account_model->get_posts( null, $post_id, $course_id );

        $this->data['default_feed'] = true;
        $this->data['single_post'] = true;

        $this->data['view_comments_feed_modal'] = get_view('crumbs/modals/forms', 'view_comments_feed_modal', $this->data);
        $this->data['alert_modal'] = get_view('crumbs/modals', 'alert_modal');
        $this->data['new_users'] = $this->account_model->get_new_users();
        $this->data['feed_right_sidebar'] = get_view('crumbs', 'feed_right_sidebar', $this->data);
        $this->data['posts'] = $posts;
        $this->data['posts_feed'] = get_view('crumbs', 'posts_feed', $this->data);

        $this->data['page_view'] = get_view('app', 'user/feed', $this->data);
        $this->load->view('templates/main', $this->data);


        //$this->data['page_view'] = get_view('pages', 'course_discussions', $this->data);
        //$this->load->view('templates/main', $this->data);


    }



}