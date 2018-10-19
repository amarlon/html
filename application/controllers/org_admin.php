<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 29/10/15
 * Time: 1:16 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (APPPATH . 'core/Base_Controller.php');

class org_admin extends Base_Controller {

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

    public function add_course( $organisation_id ) {

        $organisation = $this->account_model->get_organisation( $organisation_id );

        if( !$organisation || !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id )  ) {
            redirect('/');
            exit;
        }

        $this->data['organisation'] = $organisation;
        $this->data['course_levels'] = $this->account_model->get_course_levels();
        $this->data['tutors'] = $this->account_model->get_organisation_tutors( $organisation_id );
        $this->data['page_view'] = get_view('app', 'org_admin/add_course', $this->data);
        $this->load->view('templates/main', $this->data);
    }

    public function edit_course( $course_id, $organisation_id ) {

        if( $this->is_course_owner($course_id) ){

            if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id) ) {
                redirect('/');
                exit;
            }

            $course = $this->account_model->get_course( $course_id );
            $this->data['course'] = $course;
            $this->data['course_levels'] = $this->account_model->get_course_levels();
            $this->data['tutors'] = $this->account_model->get_organisation_tutors( $organisation_id );
            $this->data['page_view'] = get_view('app', 'org_admin/edit_course', $this->data);
            $this->load->view('templates/main', $this->data);

        } else {
            redirect('/');
            exit;
        }
    }

    public function edit_org( $organisation_id ) {

        if( !$organisation_id ) {
            redirect('/');
            exit;
        }

        $organisation = $this->account_model->get_organisation($organisation_id);

        if( !$organisation ) {
            redirect('/');
            exit;
        }

        if( !$this->account_model->is_organisation_admin( $this->user_id, $organisation_id ) ) {
            redirect('/');
            exit;
        }

        $this->data['organisation'] = $organisation;
        $this->data['countries'] = $this->account_model->get_countries();
        $this->data['search_user_modal'] = get_view('crumbs/modals/forms', 'search_user_for_invitation_modal', $this->data);
        $this->data['tutors'] = $this->account_model->get_organisation_tutors( $organisation_id );
        $this->data['page_view'] = get_view('app', 'org_admin/edit_organisation', $this->data);
        $this->load->view('templates/main', $this->data);

    }

}