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

class delete_project_opportunity_app extends Base_Controller {

    /*
     * Declare constructor to initialize
     */
    public function __construct() {
        parent::__construct ();
        if( !$this->is_logged_in() ) {
        }
    }



    public function app_delete_project() {

        $project_id = $_POST['projectId'];
        $user_id = $_POST['userId'];
        $project = $this->account_model->get_project($project_id);

        if( $project['user_id'] != $user_id ){
            echo 'Oops! Access denied. Please refresh your browser and try again.';
            exit;
        }

        if( !$this->account_model->delete_project( $project_id, $user_id ) ) {
            echo 'Oops! Problem deleting opportunity. Try again in a little bit.';
            exit;
        }

        echo "success";
        exit;

    }




        public function app_delete_opportunity() {

        $opportunity_id = $_POST['opportunityId'];
        $user_id = $_POST['userId'];
        $opportunity = $this->account_model->get_opportunity($opportunity_id);

        if( $opportunity['user_id'] != $user_id ){
            echo 'Oops! Access denied. Please refresh your browser and try again.';
            exit;
        }

        if( !$this->account_model->delete_opportunity( $opportunity_id, $user_id ) ) {
            echo 'Oops! Problem deleting opportunity. Try again in a little bit.';
            exit;
        }
        echo "success";
        exit;

    }

}