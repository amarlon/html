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

class page extends Base_Controller {

    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();

        if( !$this->is_logged_in() ) {

        }

    }

    public function index() {
        redirect('/page/home');
        exit;
    }

    public function home() {

        if( $this->data['is_logged_in'] ) {
            redirect('/account/feed');
            exit;
        }
        //$partners = array('17', '16', '18', '8', '5', '7');
        $partners = array('19');
        $this->data['hotshi_partners'] = $this->account_model->get_hotshi_partners($partners);
        $this->data['page_view'] = get_view('pages', 'landing', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function signup($type=null) {

        if( $this->data['is_logged_in'] ) {
            redirect('/account/feed');
            exit;
        }

        switch($type) {
            case 'learner':
                $this->data['active_learner'] = 'active';
                $this->data['active_tutor'] = '';
                break;
            case 'tutor':
                $this->data['active_learner'] = '';
                $this->data['active_tutor'] = 'active';
                break;
            default:
                $this->data['active_learner'] = 'active';
                $this->data['active_tutor'] = '';
                break;
        }

        //$this->data['countries'] = $this->account_model->get_countries();
        $this->data['page_view'] = get_view('pages', 'signup', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function signup_invite( $invitation_token ) {

        if( $this->data['is_logged_in'] ) {
            redirect('/account/feed');
            exit;
        }

        if( !$invitation_token ) {
            redirect('/account/feed');
            exit;
        }

        $invited_user = $this->account_model->get_tutor_invitation_token( $invitation_token );

        if( $invited_user ) {
            $this->data['valid_token'] = true;
            $this->data['invited_user'] = $invited_user;
            $this->data['invited_user']['invitation_token'] = $invited_user['token'];
            $this->data['organisation'] = $this->account_model->get_organisation( $invited_user['organisation_id'] );
        } else {
            $this->data['valid_token'] = false;
        }

        $this->data['page_view'] = get_view('pages', 'signup_invite', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function login() {

        if( $this->data['is_logged_in'] ) {
            redirect('/account/feed');
            exit;
        }

        $this->data['page_view'] = get_view('pages', 'login', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function articles( $user_id=null ) {

        if( $user_id ) {

            $user = $this->account_model->get_user_details( $user_id );
            $this->data['page_title'] = $user['fullname']."'s' Articles";
            $this->data['header'] = get_view('layout/header', 'header', $this->data);
            $this->data['articles'] = $this->account_model->get_user_articles($user_id);

        } else {

            $this->data['articles'] = $this->account_model->get_articles();

        }

        $this->data['crumb_title'] = $this->data['page_title'];
        $this->data['articles_breadcrumb'] = get_view('crumbs', 'articles_breadcrumb', $this->data);
        $this->data['page_view'] = get_view('pages', 'articles', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function article( $article_id ) {

        if( !$article_id ) {
            redirect('/');
            exit;
        }

        $article = $this->account_model->get_article( $article_id );

        if( !isset($article['id']) ) {
            redirect('/');
            exit;
        }

        $this->data['article'] = $article;
        $this->data['page_title'] = $article['title'];
        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['crumb_title'] = $article['title'];
        $this->data['articles_breadcrumb'] = get_view('crumbs', 'articles_breadcrumb', $this->data);
        $this->data['page_view'] = get_view('pages', 'article', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function jobs( $my=null ) {

        $user_id = $my ? $this->user_id : '';

        $this->data['opportunities'] = $this->account_model->get_opportunities( $this->data['user']['is_hotshi_admin'], $user_id );
        $this->data['crumb_title'] = $this->data['page_title'];
        $this->data['is_my'] = $my;
        $this->data['articles_breadcrumb'] = get_view('crumbs', 'articles_breadcrumb', $this->data);
        $this->data['page_view'] = get_view('pages', 'opportunities', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function projects( $my=null ) {

        $user_id = $my ? $this->user_id : '';

        $this->data['projects'] = $this->account_model->get_projects( $this->data['user']['is_hotshi_admin'], $user_id );
        $this->data['crumb_title'] = $this->data['page_title'];
        $this->data['is_my'] = $my;
        $this->data['articles_breadcrumb'] = get_view('crumbs', 'articles_breadcrumb', $this->data);
        $this->data['page_view'] = get_view('pages', 'projects', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function opportunity( $op_id ) {

        if( !$op_id ) {
            redirect('/page/jobs');
            exit;
        }

        $opportunity = $this->account_model->get_opportunity( $op_id );

        if( !isset($opportunity['id']) ) {
            redirect('/page/jobs');
            exit;
        }

        if( $opportunity['is_active'] || $this->data['user']['is_hotshi_admin'] || $opportunity['user_id'] == $this->user_id ) {
            $this->data['opportunity'] = $opportunity;
            $this->data['page_title'] = $opportunity['title'];
            $this->data['header'] = get_view('layout/header', 'header', $this->data);
            $this->data['opportunity_title'] = $opportunity['title'];
            $this->data['page_view'] = get_view('pages', 'opportunity', $this->data);
            $this->load->view('templates/main', $this->data);

        } else {
            redirect('/page/jobs');
            exit;
        }

    }

    public function project( $project_id ) {

        if( !$project_id ) {
            redirect('/page/projects');
            exit;
        }

        $opportunity = $this->account_model->get_project( $project_id );

        if( !isset($opportunity['id']) ) {
            redirect('/page/jobs');
            exit;
        }

        if( $opportunity['is_active'] || $this->data['user']['is_hotshi_admin'] || $opportunity['user_id'] == $this->user_id ) {
            $this->data['opportunity'] = $opportunity;
            $this->data['page_title'] = $opportunity['title'];
            $this->data['header'] = get_view('layout/header', 'header', $this->data);
            $this->data['opportunity_title'] = $opportunity['title'];
            $this->data['page_view'] = get_view('pages', 'project', $this->data);
            $this->load->view('templates/main', $this->data);

        } else {
            redirect('/page/jobs');
            exit;
        }

    }

    public function organisations() {

        $this->data['organisations'] = $this->account_model->get_organisations();
        $this->data['page_view'] = get_view('pages', 'organisations', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function users() {

        $this->data['users'] = $this->account_model->get_users();
        $this->data['page_view'] = get_view('pages', 'users', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function profile( $user_id ) {

        if( !$user_id ) {
            redirect('/');
            exit;
        }

        if( is_numeric( $user_id ) ) {

            $user = $this->account_model->get_user_details( $user_id );

            if( !$user ) {
                redirect('/');
                exit;
            }

            if( $this->is_logged_in() && isset($_GET['posts']) ) {
                redirect('/page/profile/'.$user['vanity_url'].'?posts');
            } else {
                redirect('/page/profile/'.$user['vanity_url']);
            }


            exit;

        } else {

            $vanity_url = $user_id;

            $user = $this->account_model->get_user_by_vanity_url( $vanity_url );

            $user_id = $user['id'];
            $this->data['user'] = $this->account_model->get_user_details( $user_id );

            if( !isset($this->data['user']['id']) ) {
                redirect('/');
                exit;
            }

            $org_admin_user = $this->account_model->is_organisation_admin_user($user_id);

            if( $org_admin_user ) {
                redirect('/org/org_profile/'.$org_admin_user['organisation_id'].'');
                exit;
            }

            if( $this->is_logged_in() && isset($_GET['posts']) ) {
                $posts = $this->account_model->get_posts( $user_id );
            } else {
                $posts = array();
            }

            $this->data['page_title'] = $this->data['user']['fullname'];
            $this->data['header'] = get_view('layout/header', 'header', $this->data);
            $this->data['is_contact'] = $this->account_model->is_contact( $this->user_id, $this->data['user']['id'] );
            $this->data['message_user_modal'] = get_view('crumbs/modals/forms', 'message_user_modal', $this->data);
            $this->data['tutor_courses'] = $this->account_model->get_tutor_courses($this->data['user']['id']);
            $this->data['projects'] = $this->account_model->get_profile_projects($this->data['user']['id']);
            $this->data['jobs'] = $this->account_model->get_profile_jobs($this->data['user']['id']);
            $this->data['posts'] = $posts;
            $this->data['posts_feed'] = get_view('crumbs', 'posts_feed', $this->data);
            $this->data['posts'] = $posts;
            $this->data['posts_feed'] = get_view('crumbs', 'posts_feed', $this->data);
            $this->data['page_view'] = get_view('pages', 'profile', $this->data);
            $this->load->view('templates/main', $this->data);

        }

    }

    public function about() {

        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['page_view'] = get_view('pages', 'about', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function privacy() {

        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['page_view'] = get_view('pages', 'privacy', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function contact() {

        redirect('/page/about');
        exit;

        $this->data['header'] = get_view('layout/header', 'header', $this->data);
        $this->data['page_view'] = get_view('pages', 'contact', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function search() {

        $term = $this->input->get('q');

        if( !$term || strlen($term) < MIN_STR_LEN_SEARCH ) {
            redirect('/');
            exit;
        }

        if( strlen($term) < MIN_STR_LEN_SEARCH) {
            //do nothing
            $this->data['search_results'] = array();
        } else {
            $this->data['search_results'] = $this->account_model->get_search_reaults($term);
        }

        $this->data['search_term'] = $term;
        $this->data['course_levels'] = $this->account_model->get_course_levels();
        $this->data['course_category_id'] =  '0';
        $this->data['course_level_id'] = '0';
        $this->data['courses'] = $this->account_model->get_search_reaults( $term );
        $this->data['course_category'] = $this->account_model->get_course_category( $this->data['course_category_id'] );
        $this->data['course_level'] = $this->account_model->get_course_level( $this->data['course_level_id'] );
        $this->data['page_view'] = get_view('pages', 'search_results', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    /*public function faqs() {

        $this->data['page_view'] = get_view('pages', 'faqs', $this->data);
        $this->load->view('templates/main', $this->data);

    }*/

    /* password reset page */
    public function reset_password( $token ) {

        if( !$token || $this->is_logged_in() ) {
            redirect('/');
            exit;
        }

        $result = $this->account_model->get_password_reset_token($token);

        if( $result ) {
            $this->data['reset_token'] = $result['token'];
        } else {
            $this->data['password_reset_token_expired'] = true;
        }

        $this->data['page_view'] = get_view('pages', 'reset_password', $this->data);
        $this->load->view('templates/main', $this->data);

    }


    /* verify an email account */
    public function verify_email( $token ) {

        if( !$token ) {
            redirect('/');
            exit;
        }

        if( $this->account_model->verify_email( $token ) ) {
            $this->data['email_verified'] = true;
        }

        $this->data['page_view'] = get_view('pages', 'verify_email', $this->data);
        $this->load->view('templates/main', $this->data);

    }

    public function logout() {

        if( $this->is_logged_in() && $this->data['user']['is_fb_user'] ) {
            $this->session->sess_destroy();
            $this->data['page_view'] = get_view('pages', 'logout', $this->data);
            $this->load->view('templates/main', $this->data);
        } else if( $this->is_logged_in() )  {
            $this->session->sess_destroy();
            redirect ( '/' );
            exit;
        } else {
            redirect ( '/' );
            exit;
        }

    }

}