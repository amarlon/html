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

class add_post extends Base_Controller {


    ////////////////////////////////////////////////////////
    // HANDLE AJAX CALLS IN RELATION TO USER ACCOUNTS     //
    ////////////////////////////////////////////////////////


    /*
     * Declare constructor to initialise
     */
    public function __construct() {

        parent::__construct ();
        if( !$this->is_logged_in() ) {
        }

    }


    public function create_post() {

        $user_id = $_POST['user_id'];
        $description = $_POST['description'];
        $secure_url = null;
        $pic_bytes = '';
        $public_id = '';

        if($_POST['secure_url']!="") {
            $secure_url = $_POST['secure_url'];
            $pic_bytes = $_POST['pic_bytes'];
            $public_id = $_POST['public_id'];
           }    

        $course_id = 0;

        $data = array(
            'user_id' => $user_id,
            'description' => $description,
            'image' =>$secure_url ,
            'image_bytes' => $pic_bytes,
            'image_public_id' => $public_id,
            'course_id' => $course_id
        );

        $post_id = $this->account_model->create_post($data);

        if( !$post_id ) {
            echo "failure";
            exit;
        }
        
        echo "success";
        exit;
    }



   public function delete_post() {


        $post_id = $_POST['postId'];
        $user_id = $_POST['userId'];

        $data = array(
            'is_deleted' => 1
        );

        if( !$this->account_model->delete_post( $data, $user_id, $post_id) ) {
            echo "Failed to delete this post. Try again!";
            exit;
        }

        echo "success";
        exit;

    }



}