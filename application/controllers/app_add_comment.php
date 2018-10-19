<?php
header('Content-Type:application/json ; charset=utf-8');
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once (APPPATH . 'core/Base_Controller.php');
class app_add_comment extends Base_Controller {
    /*
     * Declare constructor to initialize
     */
    public function __construct() {
        parent::__construct ();
        if( !$this->is_logged_in() ) {
        }
    }



    public function create_comment() {

        $comment = $_POST['comment'];
        $user_id = $_POST['user_id'];
        $user_fullname = $_POST['user_fullname'];
        $to_user_id = $_POST['author_id'];
        $post_id = $_POST['post_id'];

        $post = $this->account_model->get_post( $post_id );

        //ensure post hasn't been deleted
        if( !$post ) {
            echo "Oops! This post has been removed.";
            exit;
        }

        $is_seen = $post['user_id'] == $user_id;

        $data = array(
            'post_id' => $post_id,
            'user_id' => $user_id,
            'comment' => $comment,
            'is_seen' => $is_seen
        );

        $comment_id = $this->account_model->add_comment( $data );

        if( !$comment_id ) {
            echo "Oops! Problem adding comment. Try again in a little bit.";
            exit;
        }

        //$comment = $this->account_model->get_comment( $comment_id );

        echo "success";

        /* notify poster of comment by email */
        if( $post['user_id'] != $user_id ) {

            $receiver = $this->account_model->get_user_details( $post['user_id'] );

            $this->data['email_data'] = array(
                'email' => $receiver['email'],
                'firstname' => $receiver['firstname'],
                'receiver_fullname' => $receiver['fullname'],
                'sender_fullname' => $user_fullname,
                'sender_id' => $user_id,
                'post_id' => $post_id,
                'comment' => $data['comment']

            ); $this->sendmail('comment', 'Comment posted on your post', $this->data);

        }

        exit;
    }

    public function reply_comment() {

        $comment = $_POST['comment'];
        $user_id = $_POST['user_id'];
        $user_fullname = $_POST['user_fullname'];
        $comment_id = $_POST['comment_id'];
        $to_user_id = $_POST['comment_author_id'];
        $post_id = $_POST['post_id'];

        if( $to_user_id == $user_id ) {
            echo "Sorry, you can't reply to yourself";
            exit;
        }

        $to_user = $this->account_model->get_user_details( $to_user_id );

        //ensure user exists
        if( !$to_user ) {
            echo "This user account doesn't exist";
            exit;
        }

        $post = $this->account_model->get_post( $post_id );


        if( !$post ) {
            echo "Oops! This post has been removed.";
            exit;
        }



        $data = array(
            'comment_id' => $comment_id,
            'from_user_id' => $user_id,
            'to_user_id' => $to_user_id,
            'comment' => $comment
        );

        $reply_id = $this->account_model->reply_comment( $data );

        if( !$reply_id ) {
            echo "Oops! Problem adding comment. Try again in a little bit.";
            exit;
        }

        $comment = $this->account_model->get_reply( $reply_id, $comment_id ); //root comment id

 /*       echo json_encode(array('status' => 'ok', 'message' => 'Comment posted.', 'reply_id' => $reply_id, 'comment' => $comment, 'comment_post_id' => $post_id));
*/
        echo "success";

        $receiver = $this->account_model->get_user_details( $to_user_id );

        $this->data['email_data'] = array(

            'email' => $receiver['email'],
            'firstname' => $receiver['firstname'],
            'receiver_fullname' => $receiver['fullname'],
            'sender_fullname' => $user_fullname,
            'sender_id' => $user_id,
            'post_id' => $post_id,
            'comment' => $data['comment']

        ); $this->sendmail('comment_reply', 'Comment response', $this->data);

        exit;

    }

 public function delete_comment() {

       $comment_id = $_POST['commentId'];
       $user_id = $_POST['authorCommentId'];

        if( $this->account_model->delete_feed_comment( $user_id, $comment_id ) ) {
            echo "success";
        } else {
            echo "Failed to delete this comment. Try again!";
        }

    }


 public function delete_comment_reply() {

        $user_id = $_POST['authorCommentReplyId'];
        $comment_reply_id = $_POST['comment_reply_id'];
        if( $this->account_model->delete_feed_comment_reply($user_id, $comment_reply_id ) ) {
            echo "success";
        } else {
            echo "Failed to delete this reply. Try again!";
        }

    }

}