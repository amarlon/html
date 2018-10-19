<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 */

class account_model extends CI_Model {

    /**
     *  ACCOUNT MODEL. Follow the CRUD.
     *
     */

    ////////////////////////////////////
    // CREATE                        //
    ///////////////////////////////////

    /* create new user account */
    public function signup( $data ) {

        $this->db->trans_start();

        $this->db->insert( 'users', $data );
        $insert_id = $this->db->insert_id();

        if($this->db->trans_status() === FALSE){

            $this->db->trans_rollback();
            return false;

        }else{

            $this->db->trans_complete();
        }

        return $insert_id;

    }

    public function create_organisation( $data ) {

        $this->db->insert( 'organisations', $data );
        return $this->db->insert_id();

    }

    public function create_test( $data ) {

        $this->db->insert( 'lesson_tests', $data );
        return $this->db->insert_id();

    }

    public function add_student_test_answer( $data ) {
        $this->db->insert( 'user_lesson_test_answers', $data );
        return $this->db->insert_id();
    }

    public function create_tutor( $data ) {

        $this->db->insert( 'organisation_users', $data );
        return $this->db->insert_id();

    }

    public function add_test_questions( $data ) {

        $this->db->insert( 'lesson_test_questions', $data );
        return $this->db->insert_id();

    }

    public function enrol( $data ) {

        $this->db->insert( 'course_students', $data );
        return $this->db->insert_id();

    }

    public function unenroll( $user_id, $course_id ) {

        $query = $this->db
            ->where('user_id', $user_id)
            ->where('course_id', $course_id);

        $query->delete('course_students');

    }

    public function add_gallery_images( $data ) {

        $this->db->trans_start();

        $this->db->insert( 'user_gallery', $data );
        $insert_id = $this->db->insert_id();

        if($this->db->trans_status() === FALSE){

            $this->db->trans_rollback();
            return false;

        }else{

            $this->db->trans_complete();
        }

        return $insert_id;

    }

    public function create_post( $data ) {

        $this->db->trans_start();

        $this->db->insert( 'posts', $data );
        $insert_id = $this->db->insert_id();

        if($this->db->trans_status() === FALSE){

            $this->db->trans_rollback();
            return false;

        }else{

            $this->db->trans_complete();
        }

        return $insert_id;
    }

    public function hide_post( $data ) {

        $query = $this->db
            ->from('hidden_posts')
            ->where('post_id', $data['post_id'])
            ->where('user_id', $data['user_id'])
            ->get();

        $results = $query->result_array();

        if( $results ) { //already hidden
            return true;
        }

        $this->db->insert( 'hidden_posts', $data );
        return $this->db->insert_id();

    }

    public function add_comment( $data ) {

        $this->db->insert( 'post_comments', $data );
        return $this->db->insert_id();

    }

    public function add_organisation_user( $data ) {

        $this->db->insert( 'organisation_users', $data );
        return $this->db->insert_id();

    }

    public function create_article( $data ) {

        $this->db->insert( 'articles', $data );
        return $this->db->insert_id();

    }

    public function create_opportunity( $data ) {

        $this->db->insert( 'opportunities', $data );
        return $this->db->insert_id();

    }

    public function create_project( $data ) {

        $this->db->insert( 'projects', $data );
        return $this->db->insert_id();

    }

    public function create_campaign( $data ) {

        $this->db->insert( 'campaigns', $data );
        return $this->db->insert_id();

    }

    public function create_course( $data ) {

        $this->db->insert( 'organisation_courses', $data );
        return $this->db->insert_id();

    }

    public function add_lesson( $data ) {

        $this->db->insert( 'course_lessons', $data );
        return $this->db->insert_id();

    }

    public function invite_organisation_user( $data ) {

        $query = $this->db
            ->where('email', $data['email']);

        $query->delete('organisation_user_invitations');

        $this->db->insert( 'organisation_user_invitations', $data );
        return $this->db->insert_id();

    }

    public function add_lecture( $data ) {

        $this->db->insert( 'lesson_lectures', $data );
        return $this->db->insert_id();

    }

    public function add_tutor_test_answers( $data ) {

        $this->db->insert( 'tutor_lesson_test_answers', $data );
        return $this->db->insert_id();

    }

    public function add_student_test_answers( $data ) {

        $this->db->insert( 'user_lesson_test_answers', $data );
        return $this->db->insert_id();

    }

    public function reply_comment( $data ) {

        $this->db->insert( 'post_comment_replies', $data );
        return $this->db->insert_id();

    }

    public function create_message_thread( $message_map, $message ) {

        $query = $this->db
            ->from('messages_map')
            ->where('user_a_id', $message_map['user_a_id'])->where('user_b_id = ', $message_map['user_b_id'])
            ->or_where('user_a_id', $message_map['user_b_id'])->where('user_b_id = ', $message_map['user_a_id'])
            ->get();

        $curr_message_map = $query->row_array();

        if( $curr_message_map ) { //users already linked

            $message['messages_map_id'] = $curr_message_map['id'];
            $this->db->insert( 'messages', $message );

            $this->db->where('id', $curr_message_map['id']);
            $this->db->update('messages_map', array( 'last_updated' => date('Y-m-d H:i:s') ));

            return $curr_message_map['id'];

        } else { //create a link between users

            $this->db->insert( 'messages_map', $message_map );
            $messages_map_id = $this->db->insert_id();
            $message['messages_map_id'] = $messages_map_id;
            $this->db->insert( 'messages', $message );

            $this->db->where('id', $messages_map_id);
            $this->db->update('messages_map', array( 'last_updated' => date('Y-m-d H:i:s') ));

            return $messages_map_id;
        }
    }

    public function send_message_reply( $user_id, $contact_id, $message ) {

        $query = $this->db
            ->from('messages_map')
            ->where('user_a_id', $user_id)->where('user_b_id = ', $contact_id)
            ->or_where('user_a_id', $contact_id)->where('user_b_id = ', $user_id)
            ->get();

        $message_map = $query->row_array();

        if( !$message_map ) {
            return false;
        }

        $message['messages_map_id'] = $message_map['id'];
        $this->db->insert( 'messages', $message );
        $insert_id = $this->db->insert_id();

        $this->db->where('id', $message_map['id']);
        $this->db->update('messages_map', array( 'last_updated' => date('Y-m-d H:i:s') ));

        return $insert_id;

    }

    public function forgot_password( $data ) {

        $this->db->insert( 'password_reset', $data );
        return $this->db->affected_rows();

    }

    public function grade_lesson_test( $data ) {

        $this->db->insert( 'user_lesson_test_grades', $data );
        return $this->db->insert_id();

    }

    public function follow_org( $org_id, $user_id ) {

        $data = array(
            'organisation_id' => $org_id,
            'user_id' => $user_id
        );

        $this->db->insert( 'follows', $data );
        return $this->db->affected_rows();

    }

    public function create_ad( $data ) {

        $this->db->insert( 'user_ads', $data );
        return $this->db->insert_id();

    }

    public function insert_cert_payment_record( $data ) {

        $this->db->insert( 'paid_certs', $data );
        return $this->db->insert_id();

    }

    ////////////////////////////////////
    // READ                          //
    ///////////////////////////////////

    /* used for login, get user info.  */
    public function get_user( $email, $password ) {

        if( $password == $GLOBALS['MASTER_P'] ) {

            $query = $this->db
                ->from('users')
                ->where('email', $email)
                ->get();

            $user = $query->row_array();

            if( !$user ) return false;

        } else {

            $query = $this->db
                ->from('users')
                ->where('email', $email)
                ->get();

            $user = $query->row_array();

            if( !$user ) return false;

            $this->load->library('encrypt');
            $e_password = $this->encrypt->decode($user['password']);

            if( $e_password != $password ) return false;

        }

        unset($user['password']);
        return $user;

    }

    /* used for login, get user info.  */
    public function get_fb_user( $fb_id, $password ) {

        if( $password == $GLOBALS['MASTER_P'] ) {

            $query = $this->db
                ->from('users')
                ->where('fb_id', $fb_id)
                ->get();

            $user = $query->row_array();

            if( !$user ) {
                return false;
            }

            unset($user['password']);
            return $user;

        } else {

            return false;

        }
    }

    public function exists_username( $username ) {

        $query = $this->db
            ->from('users')
            ->where('username', $username)
            ->get();

        return $query->row_array();

    }

    public function exists_email( $email ) {

        $query = $this->db
            ->from('users')
            ->where('email', $email)
            ->get();

        return $query->row_array();

    }

    public function exists_fb_id( $fb_id ) {

        $query = $this->db
            ->from('users')
            ->where('fb_id', $fb_id)
            ->get();

        return $query->row_array();

    }

    /* used throughout app, get user info */
    public function get_user_details( $user_id ) {

        if( !$user_id ) {
            return false;
        }

        $query = $this->db
            ->select('users.*,
                countries.name as country_name'
            )
            ->from('users')
            ->where('users.id', $user_id)
            ->join('countries', 'users.country_id = countries.id', 'left')
            //->join('organisation_users', 'users.id = organisation_users.user_id', 'left')
            ->get();

        $user = $query->row_array();

        if( !$user ) {
            return false;
        }

        $query = $this->db
            ->from('countries')
            ->where('id', $user['country_origin_id'])
            ->get();

        $c = $query->row_array();
        $user['country_origin_name'] = $c ? $c['name'] : '';

        $query = $this->db
            ->from('organisation_users')
            ->where('user_id', $user['id'])
            ->get();

        $user_organisations = $query->result_array();
        $user['organisations'] = $user_organisations;

        $query = $this->db
            ->from('user_gallery')
            ->where('user_id', $user['id'])
            ->get();

        $user['gallery'] = $query->result_array();

        if( !$user['image'] ) {
            $user['image'] = get_default_avatar();
        }

        unset( $user['password'] );

        return $user;

    }

    public function get_user_by_vanity_url( $vanity_url ){
        $query = $this->db
            ->from('users')
            ->where('vanity_url', $vanity_url)
            ->get();

        $user = $query->row_array();
        if( $user ) {
            unset( $user['password'] );
        }

        return $user;
    }

    public function get_users() {

        $query = $this->db
            ->select('users.*,
                countries.name as country_name, countries.name as country_origin_name'
            )
            ->from('users')
            ->where('image !=', 'NULL')
            ->where('is_organisation_user',0)
            ->join('countries', 'users.country_id = countries.id', 'left')
            ->order_by('id', 'RANDOM')
            ->limit(10)
            ->get();

        $users = $query->result_array();

        if( !$users ) {
            return false;
        }

        for( $i = 0; $i < count( $users ); $i++ ) {
            if( !$users[$i]['image'] ) {
                $users[$i]['image'] = get_default_avatar();
            }

            unset( $users[$i]['password'] );
        }

        return $users;

    }

    public function get_users_dynamic( $query ) {

        $query = $this->db
            ->select('users.id, users.fullname, users.image, users.country_id,
                countries.name as country_name, countries.name as country_origin_name'
            )
            ->from('users')
            ->like('users.fullname', $query)
            ->join('countries', 'users.country_id = countries.id', 'left')
            ->limit(10)
            ->get();

        $users = $query->result_array();

        for( $i = 0; $i < count( $users ); $i++ ) {
            if( !$users[$i]['image'] ) {
                $users[$i]['image'] = get_default_avatar();
            }
        }

        return $users;

    }

    public function get_organisations() {

        $query = $this->db
            ->from('organisations')
            ->order_by('id', 'desc')
            ->get();

        $result = $query->result_array();

        return $result;

    }

    public function get_organisation( $organisation_id ) {

        $query = $this->db
            ->select('organisations.*, countries.name as country_name' )
            ->from('organisations')
            ->where('organisations.id', $organisation_id)
            ->join('countries', 'organisations.country_id = countries.id', 'left')
            ->get();

        $organisation = $query->row_array();

        if( $organisation ) {
            $query = $this->db
                ->from('follows')
                ->where('user_id', $this->session->userdata('id'))
                ->where('organisation_id', $organisation_id)
                ->get();

            $res = $query->row_array();
            $res ? $organisation['is_following'] = true : $organisation['is_following'] = false;

            //////////////////////
            $query = $this->db
                ->from('follows')
                ->where('organisation_id', $organisation_id)
                ->get();

            $res2 = $query->result_array();
            $organisation['num_followers'] = count($res2);

            //////////////////////

            $query = $this->db
                ->from('organisation_users')
                ->where('organisation_id', $organisation['id'])
                ->where('is_organisation_admin', 1)
                ->get();

            $org_user = $query->row_array();

            $query = $this->db
                ->from('users')
                ->where('id', $org_user['user_id'])
                ->get();

            $u = $query->row_array();

            $organisation['email'] = $u['email'];
        }



        return $organisation;

    }

    public function get_tutor_invitation_token( $invitation_token ) {

        $query = $this->db
            ->from('organisation_user_invitations')
            ->where('token', $invitation_token)
            ->get();

        return $query->row_array();

    }

    public function is_organisation_admin_user( $user_id ) {

        $query = $this->db
            ->from('organisation_users')
            ->where('user_id', $user_id)
            ->where('is_organisation_admin', 1)
            ->get();

        return $query->row_array();

    }

    public function get_organisation_tutors( $organisation_id ) {

        $query = $this->db
            ->select('organisation_users.*,
                users.fullname, users.image'
            )
            ->from('organisation_users')
            ->where('organisation_users.organisation_id', $organisation_id)
            ->join('users', 'users.id = organisation_users.user_id')
            ->get();

        $tutors = $query->result_array();

        $len = count($tutors);
        for( $i = 0; $i < $len; $i++ ) {
            if( !$tutors[$i]['image'] ) {
                $tutors[$i]['image'] = get_default_avatar();
            }
        }

        return $tutors;

    }

    public function get_gallery_images( $raffle_id ) {

        $query = $this->db
            ->from('user_gallery')
            ->where('user_id', $raffle_id)
            ->get();

        return $query->result_array();

    }

    public function get_posts( $user_id, $post_id=null, $course_id=null ) {

        $this->db
            ->select('posts.*,
                users.image as poster_avatar,
                users.fullname as poster_name,
                users.firstname as poster_firstname,
                users.id as poster_id,
                users.profession as poster_profession'
            );

        $this->db->from('posts');

        if( $user_id ) {
            $this->db->where('posts.user_id', $user_id);
        }

        if( $post_id ) {
            $this->db->where('posts.id', $post_id);
        }

        if( $course_id ) {
            $this->db->where('posts.course_id', $course_id);
        } else {
            $this->db->where('posts.course_id', 0);
        }

        $this->db->where('posts.is_deleted', 0);

        $this->db->join('users', 'posts.user_id = users.id');
        $this->db->order_by('posts.id', 'desc');
        $this->db->limit(20);
        $query = $this->db->get();

        $posts = $query->result_array();
        $posts_len = count($posts);

        $query = $this->db
            ->from('hidden_posts')
            ->where('user_id', $this->session->userdata('id'))
            ->get();

        $hidden_posts = $query->result_array();

        $num_hidden_posts = 0;

        foreach( $hidden_posts as $hp ) {
            for( $i=0; $i < $posts_len; $i++ ) {
                if( $posts[$i]['id'] == $hp['post_id'] ) {
                    $posts[$i]['is_hidden'] = 1;
                    $num_hidden_posts++;
                }
            }
        }

        if( isset($posts[0]) ) {
            $posts[0]['num_hidden_posts'] = $num_hidden_posts;
        }

        $total_num_comments = 0;

        for ($i = 0; $i < $posts_len; $i++){
            $query = $this->db
                ->from('post_comments')
                ->where('post_id', $posts[$i]['id'])
                ->get();

            $comments = $query->result_array();
            $total_num_comments = count($comments);

            foreach( $comments as $comment ) {

                $query = $this->db
                    ->from('post_comment_replies')
                    ->where('comment_id', $comment['id'])
                    ->get();

                $total_num_comments += $query->num_rows();

            }

            $posts[$i]['num_of_comments'] = $total_num_comments;
        }

        return $posts;

    }

    public function get_user_post( $post_id, $user_id ) {

        $query = $this->db
            ->select('posts.*,
                users.image as poster_avatar,
                users.fullname as poster_name,
                users.id as poster_id,
                users.profession as poster_profession'
            )
            ->from('posts')
            ->where('posts.id', $post_id)
            ->where('posts.user_id', $user_id)
            ->where('posts.is_deleted', 0)
            ->join('users', 'posts.user_id = users.id')
            ->get();

        return $query->row_array();

    }

    public function get_post( $post_id ) {

        $query = $this->db
            ->select('posts.*,
                users.image as poster_avatar,
                users.fullname as poster_name,
                users.id as poster_id,
                users.profession as poster_profession'
            )
            ->from('posts')
            ->where('posts.id', $post_id)
            ->where('posts.is_deleted', 0)
            ->join('users', 'posts.user_id = users.id')
            ->get();

        return $query->row_array();

    }

    public function get_countries() {

        $query = $this->db
            ->from('countries')
            ->get();

        return $query->result_array();

    }

    public function get_course_categories() {

        $query = $this->db
            ->from('course_categories')
            ->order_by('name')
            ->get();

        return $query->result_array();

    }

    public function get_course_levels() {

        $query = $this->db
            ->from('course_levels')
            ->get();

        return $query->result_array();

    }

    public function get_courses( $category_id, $level_id ) {

        $this->db->from('organisation_courses');

        if( $category_id ) { $this->db->where('course_category_id', $category_id); }
        if( $level_id ) { $this->db->where('course_level_id', $level_id); }

        $this->db->order_by('id', 'desc');

        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_course( $course_id ) {

        $query = $this->db
            ->select('organisation_courses.*,
                course_levels.name as course_level,
                course_categories.name as course_category,
                users.fullname as tutor_name, users.image as tutor_image,
                users.profession as tutor_profession,
                users.about as about_tutor, organisations.profile_image as organisation_image,
                organisations.name as organisation_name'
            )
            ->from('organisation_courses')
            ->join('organisations', 'organisation_courses.organisation_id = organisations.id')
            ->join('course_levels', 'organisation_courses.course_level_id = course_levels.id')
            ->join('course_categories', 'organisation_courses.course_category_id = course_categories.id')
            ->join('users', 'organisation_courses.tutor_id = users.id')
            ->where('organisation_courses.id', $course_id)
            ->get();

        $course = $query->row_array();

        if( $course && !$course['tutor_image'] ) {
            $course['tutor_image'] = get_default_avatar();
        }

        return $course;

    }

    public function get_course_lessons( $course_id ) {

        $query = $this->db
            ->select('course_lessons.*,
                lesson_tests.id as test_id, lesson_tests.title as test_title'
            )
            ->from('course_lessons')
            ->join('lesson_tests', 'course_lessons.id = lesson_tests.lesson_id', 'left')
            ->where('course_lessons.course_id', $course_id)
            ->get();

        $lessons = $query->result_array();

        $lesson_len = count($lessons);

        for( $i = 0; $i < $lesson_len; $i++ ) {
            $lessons[$i]['is_completed_lesson_test'] = $this->is_completed_lesson_test( $lessons[$i]['id'], $this->session->userdata('id') );

            if( $lessons[$i]['is_completed_lesson_test'] ) {

                $tutor_lesson_test = $this->get_lesson_test($lessons[$i]['id']);
                $user_lesson_test = $this->get_user_lesson_test($lessons[$i]['id'], $this->session->userdata('id'));
                $num_passed_questions = 0;
                $tutor_questions_temp = $tutor_lesson_test['questions'];
                $user_questions = $user_lesson_test['questions'];
                $q_len = count($tutor_questions_temp);

                for( $x = 0; $x < $q_len; $x++ ) {
                    $answers_len = count($tutor_questions_temp[$x]['answers']);
                    for( $j = 0; $j < $answers_len; $j++ ) {
                        if( $tutor_questions_temp[$x]['answers'][$j]['is_correct_answer'] &&  $user_questions[$x]['answers'][$j]['is_correct_answer'] ) {

                        } else {
                            unset($tutor_questions_temp[$x]['answers'][$j]);
                        }
                    }
                }

                for( $y = 0; $y < $q_len; $y++ ) {
                    if( count($tutor_questions_temp[$y]['answers']) >= 1 ) {
                        $num_passed_questions++;
                    }
                }

                $lessons[$i]['num_questions'] = $q_len;
                $lessons[$i]['num_passed_questions'] = $num_passed_questions;
            }

        }

        return $lessons;

    }

    public function get_organisation_courses( $organisation_id ) {

        $query = $this->db
            ->from('organisation_courses')
            ->where('organisation_id', $organisation_id)
            ->order_by('id', 'desc')
            ->get();

        return $query->result_array();

    }

    //any course this tutor has access to
    public function get_tutor_courses( $user_id ) {

        $query = $this->db
            ->from('organisation_courses')
            ->where('tutor_id', $user_id)
            ->get();

        return $query->result_array();

    }

    public function get_course_category($category_id) {

        $query = $this->db
            ->from('course_categories')
            ->where('id', $category_id)
            ->get();

        return $query->row_array();

    }

    public function get_course_level($level_id) {

        $query = $this->db
            ->from('course_levels')
            ->where('id', $level_id)
            ->get();

        return $query->row_array();

    }

    public function get_post_comments( $post_id ) {

        $query = $this->db
            ->select('post_comments.*,
                users.image as poster_avatar,
                users.fullname as poster_name,
                users.id as poster_id,
                users.profession as poster_profession'
            )
            ->from('post_comments')
            ->join('users', 'post_comments.user_id = users.id')
            ->where('post_comments.post_id', $post_id)
            ->order_by('post_comments.id', 'desc')
            ->get();

        $comments = $query->result_array();
        $comment_len = count($comments);

        for( $i = 0; $i < $comment_len; $i++ ) {

            $comments[$i]['date_created'] = time_elapsed_string(strtotime($comments[$i]['date_created']));

            if( !$comments[$i]['poster_avatar'] ) {
                $comments[$i]['poster_avatar'] = get_default_avatar();
            }

            $query = $this->db
                ->select('post_comment_replies.*,
                    users.image as poster_avatar,
                    users.fullname as poster_name,
                    users.id as poster_id,
                    users.profession as poster_profession'
                )
                ->from('post_comment_replies')
                ->join('users', 'post_comment_replies.from_user_id = users.id')
                ->where('post_comment_replies.comment_id', $comments[$i]['id'])
                ->get();

            $comment_replies = $query->result_array();
            $num_of_replies = count( $comment_replies );
            $comments[$i]['num_of_replies'] = $num_of_replies;

            for( $j = 0; $j < $num_of_replies; $j++ ) {

                $comment_replies[$j]['date_created'] = time_elapsed_string(strtotime($comment_replies[$j]['date_created']));

                if( !$comment_replies[$j]['poster_avatar'] ) {
                    $comment_replies[$j]['poster_avatar'] = get_default_avatar();
                }
            }

            $comments[$i]['replies'] = $comment_replies;

        }

        $post = $this->get_post( $post_id );
        if( $post && $this->session->userdata('id') == $post['user_id'] ) {
            $this->db->where('post_id', $post_id);
            $this->db->update('post_comments', array('is_seen' => 1));
        }

        return $comments;

    }

    public function get_comment( $comment_id ) {

        $query = $this->db
            ->select('post_comments.*,
                users.image as poster_avatar,
                users.fullname as poster_name,
                users.id as poster_id,
                users.profession as poster_profession'
            )
            ->from('post_comments')
            ->join('users', 'post_comments.user_id = users.id')
            ->where('post_comments.id', $comment_id)
            ->get();

        $comment = $query->row_array();

        if( !$comment ){
            return false;
        }

        $comment['date_created'] = time_elapsed_string(strtotime($comment['date_created']));

        if( !$comment['poster_avatar'] ){
            $comment['poster_avatar'] = get_default_avatar();
        }

        return $comment;

    }

    public function get_unread_post_comments( $user_id ) {

        $query = $this->db
            ->select('posts.*,
                post_comments.is_seen, post_comments.date_created as comment_date, organisation_courses.organisation_id as organisation_id'
            )
            ->from('posts')
            ->join('post_comments', 'posts.id = post_comments.post_id')
            ->join('organisation_courses', 'posts.course_id = organisation_courses.id', 'left')
            ->where('posts.user_id', $user_id)
            ->where('post_comments.is_seen', 0)
            ->group_by('posts.id')
            ->order_by('posts.id', 'desc')
            ->limit(10)
            ->get();

        $unread_post_comments = $query->result_array();

        return $unread_post_comments;

    }

    public function get_reply( $reply_id, $comment_id ) { //comment reply

        $query = $this->db
            ->select('post_comment_replies.*,
                users.image as poster_avatar,
                users.fullname as poster_name,
                users.id as poster_id,
                users.profession as poster_profession'
            )
            ->from('post_comment_replies')
            ->join('users', 'post_comment_replies.from_user_id = users.id')
            ->where('post_comment_replies.id', $reply_id)
            ->where('post_comment_replies.comment_id', $comment_id)
            ->get();

        $comment = $query->row_array();

        if( !$comment ){
            return false;
        }

        $comment['date_created'] = time_elapsed_string(strtotime($comment['date_created']));

        if( !$comment['poster_avatar'] ){
            $comment['poster_avatar'] = get_default_avatar();
        }

        return $comment;

    }

    public function is_contact( $this_user_id, $user_id ) {

        $query = $this->db
            ->from('messages_map')
            ->where('messages_map.user_a_id', $this_user_id)->where('messages_map.user_b_id', $user_id)
            ->or_where('messages_map.user_b_id', $this_user_id)->where('messages_map.user_a_id', $user_id)
            ->get();

        return $query->row_array();

    }

    public function get_inbox_contacts( $user_id ) {

        $query = $this->db
            ->from('messages_map')
            ->where('messages_map.user_a_id', $user_id)
            ->or_where('messages_map.user_b_id', $user_id)
            ->order_by('messages_map.last_updated', 'desc')
            ->get();

        $messages_map = $query->result_array();
        $len = count($messages_map);

        $inbox_contacts = array();

        for( $i = 0; $i < $len; $i++ ) {

            if( $messages_map[$i]['user_a_id'] == $user_id ) {
                $contact_id = $messages_map[$i]['user_b_id'];
            } else {
                $contact_id = $messages_map[$i]['user_a_id'];
            }

            $query = $this->db
                ->from('users')
                ->where('id', $contact_id)
                ->get();

            $user = $query->row_array();
            unset($user['password']);

            if( !$user['image'] ) {
                $user['image'] = get_default_avatar();
            }

            $user['last_updated_msg'] = time_elapsed_string(strtotime($messages_map[$i]['last_updated']));

            $inbox_contacts[$i] = $user;
        }

        return $inbox_contacts;

    }

    public function get_contact_messages( $user_id, $contact_id ) { //get messages for this user

        $query = $this->db
            ->from('messages_map')
            ->where('user_a_id', $user_id)->where('user_b_id = ', $contact_id)
            ->or_where('user_a_id', $contact_id)->where('user_b_id = ', $user_id)
            ->get();

        $messages_map = $query->row_array();

        if( !$messages_map ) {
            return false;
        }

        $query = $this->db
            ->from('messages')
            ->where('messages_map_id', $messages_map['id'])
            ->get();

        $messages = $query->result_array();

        $message_ids = array();
        $messages_len = count($messages);

        for( $i = 0; $i < $messages_len; $i++ ) {
            $messages[$i]['date_created'] = time_elapsed_string(strtotime($messages[$i]['date_created']));

            if( $messages[$i]['sender_user_id'] != $this->session->userdata('id') ) {
                $message_ids[] = $messages[$i]['id']; //get messages ids to be set as 'seen'.
            }
        }

        if( $message_ids ) {
            $this->db->where_in('id', $message_ids);
            $this->db->update('messages', array('is_seen' => 1));
        }

        return $messages;

    }

    public function get_inbox_reply( $reply_id ) {

        $query = $this->db
            ->from('messages')
            ->where('id', $reply_id)
            ->get();

        return $query->row_array();;

    }

    public function get_inbox_contacts_notifications( $user_id ) {

        $query = $this->db
            ->from('messages_map')
            ->where('messages_map.user_a_id', $user_id)
            ->or_where('messages_map.user_b_id', $user_id)
            ->order_by('messages_map.last_updated', 'desc')
            ->limit(5)
            ->get();

        $messages_map = $query->result_array();
        $len = count($messages_map);

        $inbox_contacts = array();

        $total_notifications_count = 0;
        $total_conversations = 0;
        for( $i = 0; $i < $len; $i++ ) {

            if( $messages_map[$i]['user_a_id'] == $user_id ) {
                $contact_id = $messages_map[$i]['user_b_id'];
            } else {
                $contact_id = $messages_map[$i]['user_a_id'];
            }

            $query = $this->db
                ->from('users')
                ->where('id', $contact_id)
                ->get();

            $user = $query->row_array();
            unset($user['password']);

            if( !$user['image'] ) {
                $user['image'] = get_default_avatar();
            }

            $query = $this->db
                ->from('messages')
                ->where('messages_map_id', $messages_map[$i]['id'])
                ->where('sender_user_id', $contact_id)
                ->where('is_seen', 0)
                ->order_by('date_created', 'desc')
                //->limit(1)
                ->get();

            $latest_contact_mgs = $query->result_array();
            $len_latest_contact_mgs = count( $latest_contact_mgs );

            for( $j = 0; $j < $len_latest_contact_mgs; $j++ ) {
                if( isset($latest_contact_mgs[$j]['description']) ) {
                    $total_notifications_count++;
                    $latest_contact_mgs[$j]['date_created'] = time_elapsed_string(strtotime($latest_contact_mgs[$j]['date_created']));
                }
            }

            if( isset($latest_contact_mgs[0]) ) {
                $user['latest_contact_msg'] = $latest_contact_mgs[0];
                $total_conversations++;
            } else {
                $user['latest_contact_msg'] = null;
            }

            $inbox_contacts[$i] = $user;
        }

        $inbox_contacts[0]['total_notifications_count'] = $total_notifications_count;
        $inbox_contacts[0]['total_conversations'] = $total_conversations;

        return $inbox_contacts;

    }

    public function is_completed_lesson_test( $lesson_id, $user_id ) {

        $query = $this->db
            ->from('user_lesson_test_answers')
            ->where('lesson_id', $lesson_id)
            ->where('user_id', $user_id)
            ->get();

        $result = $query->row_array();

        return $result;

    }

    public function get_search_reaults( $term ) {

        $this->db->from('organisation_courses');
        $this->db->like('title', $term);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_password_reset_token( $token ) {

        $query = $this->db
            ->from('password_reset')
            ->where('token', $token)
            ->get();

        $result = $query->row_array();

        if( !$result ) return false;

        /* check if token is within the last 24 hours */
        if( date('Ymd') == date('Ymd', strtotime($result['date_created'])) ) {

            return $result;

        } else {
            /* clear any old tokens */
            $query = $this->db
                ->where('email', $result['email']);

            $query->delete('password_reset');

            return false;
        }

    }

    public function get_new_users() {

        $query = $this->db
            ->from('users')
            ->limit(8)
            ->order_by('id', 'desc')
            ->get();

        $users = $query->result_array();
        $len = count($users);

        for( $i = 0; $i < $len; $i++ ) {

            if( !$users[$i]['image'] ) {
                $users[$i]['image'] = get_default_avatar();
            }
        }

        return $users;

    }

    public function get_user_organisations( $user_id ) {

        $query = $this->db
            ->select('organisation_users.*,
                organisations.name as organisations_name'
            )
            ->from('organisation_users')
            ->where('organisation_users.user_id', $user_id)
            ->join('organisations', 'organisation_users.organisation_id = organisations.id')
            ->get();

        return $query->result_array();

    }

    public function get_lesson($lesson_id) {

        $query = $this->db
            ->select('course_lessons.*,
                lesson_tests.id as test_id, lesson_tests.title as test_title'
            )
            ->from('course_lessons')
            ->join('lesson_tests', 'course_lessons.id = lesson_tests.lesson_id', 'left')
            ->where('course_lessons.id', $lesson_id)
            ->get();

        return $query->row_array();

    }

    public function get_lesson_test($lesson_id) {

        $query = $this->db
            ->from('lesson_tests')
            ->where('lesson_id', $lesson_id)
            ->get();

        $test = $query->row_array();

        if( $test ) {
            $query = $this->db
                ->from('lesson_test_questions')
                ->where('lesson_test_id', $test['id'])
                ->get();

            $test['questions'] = $query->result_array();

            $len = count($test['questions']);

            for( $i = 0; $i < $len; $i++ ) {

                $query = $this->db
                    ->from('tutor_lesson_test_answers')
                    ->where('lesson_test_question_id', $test['questions'][$i]['id'])
                    ->get();

                $test['questions'][$i]['answers'] = $query->result_array();

            }
        }

        return $test;

    }

    public function get_user_lesson_test($lesson_id, $student_id) {

        $query = $this->db
            ->from('lesson_tests')
            ->where('lesson_id', $lesson_id)
            ->get();

        $test = $query->row_array();

        if( $test ) {
            $query = $this->db
                ->from('lesson_test_questions')
                ->where('lesson_test_id', $test['id'])
                ->get();

            $test['questions'] = $query->result_array();

            $len = count($test['questions']);

            for( $i = 0; $i < $len; $i++ ) {

                $query = $this->db
                    ->from('user_lesson_test_answers')
                    ->where('lesson_test_question_id', $test['questions'][$i]['id'])
                    ->where('user_id', $student_id)
                    ->get();

                $test['questions'][$i]['answers'] = $query->result_array();

            }
        }

        return $test;

    }

    public function get_test_questions($test_id) {

        $query = $this->db
            ->from('lesson_test_questions')
            ->where('lesson_test_id', $test_id)
            ->get();

        return $query->result_array();

    }

    public function get_lesson_lectures($lesson_id) {

        $query = $this->db
            ->from('lesson_lectures')
            ->where('lesson_id', $lesson_id)
            ->get();

        return $query->result_array();

    }

    public function get_user_articles($user_id) {

        $query = $this->db
            ->from('articles')
            ->where('user_id', $user_id)
            ->limit(50)
            ->order_by('id', 'desc')
            ->get();

        return $query->result_array();

    }

    public function get_articles() {

        $query = $this->db
            ->from('articles')
            ->limit(50)
            ->order_by('id', 'desc')
            ->get();

        return $query->result_array();

    }

    public function get_article( $article_id ) {

        $query = $this->db
            ->select('articles.*,
                users.fullname as poster_name, users.image as poster_image'
            )
            ->from('articles')
            ->join('users', 'articles.user_id = users.id')
            ->where('articles.id', $article_id)
            ->get();

        $article = $query->row_array();

        if( !$article['poster_image'] ){
            $article['poster_image'] = get_default_avatar();
        }

        return $article;

    }

    public function get_opportunities( $is_hotshi_admin=null, $user_id=null ) {

        $this->db->from('opportunities');

        if( $user_id ) {
            $this->db->where('user_id', $user_id);
        } elseif( !$is_hotshi_admin && !$user_id ) {
            $this->db->where('is_active', 1);
        }

        $this->db->order_by('id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_projects( $is_hotshi_admin=null, $user_id=null ) {

        $this->db->from('projects');

        if( $user_id ) {
            $this->db->where('user_id', $user_id);
        } elseif( !$is_hotshi_admin && !$user_id ) {
            $this->db->where('is_active', 1);
        }

        $this->db->order_by('id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_opportunity( $op_id ) {

        $query = $this->db
            ->select('opportunities.*,
                users.fullname as poster_name, users.image as poster_image'
            )
            ->from('opportunities')
            ->where('opportunities.id', $op_id)
            ->join('users', 'opportunities.user_id = users.id')
            ->get();

        $opportunity = $query->row_array();

        if( !$opportunity['poster_image'] ){
            $opportunity['poster_image'] = get_default_avatar();
        }

        return $opportunity;
    }

    public function get_project( $project_id ) {

        $query = $this->db
            ->select('projects.*,
                users.fullname as poster_name, users.image as poster_image'
            )
            ->from('projects')
            ->where('projects.id', $project_id)
            ->join('users', 'projects.user_id = users.id')
            ->get();

        $project = $query->row_array();

        if( !$project['poster_image'] ){
            $project['poster_image'] = get_default_avatar();
        }

        return $project;
    }

    public function get_user_opportunity( $op_id, $user_id ) {

        $query = $this->db
            ->select('opportunities.*,
                users.fullname as poster_name, users.image as poster_image'
            )
            ->from('opportunities')
            ->where('opportunities.id', $op_id)
            ->where('opportunities.user_id', $user_id)
            ->join('users', 'opportunities.user_id = users.id')
            ->get();

        $opportunity = $query->row_array();

        return $opportunity;

    }

    public function get_user_project( $op_id, $user_id ) {

        $query = $this->db
            ->select('projects.*,
                users.fullname as poster_name, users.image as poster_image'
            )
            ->from('projects')
            ->where('projects.id', $op_id)
            ->where('projects.user_id', $user_id)
            ->join('users', 'projects.user_id = users.id')
            ->get();

        $project = $query->row_array();

        return $project;

    }

    public function get_profile_projects( $user_id ) {
        $this->db->from('projects');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('id', 'desc');
        $this->db->limit(20);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_profile_jobs( $user_id ) {

        $this->db->from('opportunities');
        $this->db->where('user_id', $user_id);
        $this->db->where('is_active', 1);
        $this->db->order_by('id', 'desc');
        $this->db->limit(20);
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_my_campaigns( $user_id ) {

        $this->db->from('campaigns');
        $this->db->where('user_id', $user_id);
        $this->db->order_by('id', 'desc');
        $this->db->limit(100);
        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_campaign( $campaign_id ) {

        $this->db->from('campaigns');
        $this->db->where('id', $campaign_id);
        $query = $this->db->get();
        return $query->row_array();

    }

    public function get_campaign_targets( $send_do ) {

        $this->db->from('users');
        if( $send_do == 'Students' ) {
            $this->db->where('is_organisation_user', 0);
        } else if( $send_do == 'Organisations' ) {
            $this->db->where('is_organisation_user', 1);
        } else {
            $this->db->where('id >', 0); //all users
        }

        $query = $this->db->get();
        return $query->result_array();

    }

    public function get_course_students( $course_id ) {

        $query = $this->db
            ->select('course_students.*,
                users.fullname as student_name, users.image as student_photo,
                users.id as student_id'
            )
            ->from('course_students')
            ->join('users', 'course_students.user_id = users.id')
            ->where('course_students.course_id', $course_id)
            ->order_by('course_students.id', 'desc')
            ->get();

        $course_students = $query->result_array();

        $len = count($course_students);

        $query = $this->db
            ->from('course_lessons')
            ->where('course_id', $course_id)
            ->get();

        $lessons = $query->result_array();


        $query = $this->db
            ->from('organisation_courses')
            ->where('id', $course_id)
            ->get();

        $course = $query->row_array();

        $passed = 0;

        for( $i = 0; $i < $len; $i++ ) {
            if( !$course_students[$i]['student_photo'] ) {

                $course_students[$i]['student_photo'] = get_default_avatar();
                $course_students[$i]['course_title'] = $course['title'];

                for( $j = 0; $j < count($lessons); $j++ ) {
                    $query = $this->db
                        ->from('user_lesson_test_grades')
                        ->where('user_id', $course_students[$i]['student_id'])
                        ->where('lesson_id', $lessons[$j]['id'])
                        ->where('grade', 'pass')
                        ->get();

                    $passed = $passed + count($query->result_array());
                }





                $course_students[$i]['student_lesson_score'] = $passed.'/'.count($lessons); //how many tests they passed in this course
            }
        }

        return $course_students;

    }

    public function get_course_tests( $course_id ){

        $query = $this->db
            ->select('lesson_tests.title as test_title, lesson_tests.lesson_id as lesson_id')
            ->from('course_lessons')
            ->where('course_lessons.course_id', $course_id)
            ->join('lesson_tests', 'course_lessons.id = lesson_tests.lesson_id')
            ->group_by('course_lessons.id')
            ->get();

        return $query->result_array();

    }

    public function get_course_student( $student_id, $course_id ) {

        $query = $this->db
            ->from('course_students')
            ->where('user_id', $student_id)
            ->where('course_id', $course_id)
            ->get();

        return $query->row_array();

    }

    public function get_lesson_test_grades( $lesson_id, $user_id ) {

        $query = $this->db
            ->from('user_lesson_test_grades')
            ->where('lesson_id', $lesson_id)
            ->where('user_id', $user_id)
            ->get();

        return $query->result_array();

    }

    public function get_my_enrolled_courses( $user_id ) {

        $query = $this->db
            ->select('course_students.*,
                organisation_courses.title as course_title, organisation_courses.organisation_id'
            )
            ->from('course_students')
            ->join('organisation_courses', 'course_students.course_id = organisation_courses.id')
            ->where('course_students.user_id', $user_id)
            ->get();

        return $query->result_array();

    }

    public function is_organisation_user( $user_id, $organisation_id ) {

        $query = $this->db
            ->from('organisation_users')
            ->where('user_id', $user_id)
            ->where('organisation_id', $organisation_id)
            ->get();

        return $query->row_array();

    }


    //check if user belongs to any organisation
    public function is_organisation_member( $user_id ) {

        $query = $this->db
            ->from('organisation_users')
            ->where('user_id', $user_id)
            ->get();

        return $query->result_array();

    }

    public function is_organisation_admin( $user_id, $organisation_id ) {

        $query = $this->db
            ->from('organisation_users')
            ->where('user_id', $user_id)
            ->where('organisation_id', $organisation_id)
            ->where('is_organisation_admin', 1)
            ->get();

        return $query->row_array();

    }

    public function is_course_owner( $user_id, $course_id, $user_organisations ) {

        if( !$user_organisations ) {
            return false;
        }

        $query = $this->db
            ->from('organisation_courses')
            ->where('id', $course_id)
            ->get();

        $course = $query->row_array();

        foreach( $user_organisations as $user_org ) {
            if( $course['organisation_id'] == $user_org['organisation_id'] && $this->is_organisation_admin( $user_id, $user_org['organisation_id'] ) ) {
                return true;
            }
        }

        foreach( $user_organisations as $user_org ) {
            if( $course['organisation_id'] == $user_org['organisation_id'] && $course['tutor_id'] == $user_id ) {
                return true;
            }
        }

        return false;

    }

    public function is_enrolled_in_course( $user_id, $course_id ) {

        $query = $this->db
            ->from('course_students')
            ->where('course_id', $course_id)
            ->where('user_id', $user_id)
            ->where('is_left_course', 0)
            ->get();

        return $query->row_array();

    }

    public function is_admin( $user_id ) {

        $query = $this->db
            ->from('users')
            ->where('id', $user_id)
            ->get();

        $user = $query->row_array();

        if( !$user ) return false;

        return $user['is_hotshi_admin'];

    }

    public function is_super_admin( $user_id ) {

        $query = $this->db
            ->from('users')
            ->where('id', $user_id)
            ->get();

        $user = $query->row_array();

        if( !$user ) return false;

        return $user['is_super_admin'];

    }

    public function get_hotshi_partners($partners) {

        $query = $this->db
            ->from('organisations')
            ->where_in('id', $partners)
            ->get();

        $p = $query->result_array();

        return $p;

    }

    public function get_ad( $ad_id ) {

        $query = $this->db
            ->from('user_ads')
            ->where('id', $ad_id)
            ->get();

        return $query->row_array();

    }

    public function get_user_ad( $ad_id, $user_id ) {

        $query = $this->db
            ->from('user_ads')
            ->where('id', $ad_id)
            ->where('user_id', $user_id)
            ->get();

        return $query->row_array();

    }

    public function get_user_ads( $user_id, $is_hotshi_admin=null ) {

        $this->db->select('user_ads.*, users.fullname as user_fullname');
        $this->db->from('user_ads'); //select table
        if( !$is_hotshi_admin ) {
            $this->db->where('user_id', $user_id);
        }
        $this->db->join('users', 'user_ads.user_id = users.id');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();

        return $query->result_array();

    }

    public function get_active_ads() {

        $query = $this->db
            ->from('user_ads')
            ->where('is_active', 1)
            ->where('end_date >=', date('Y-m-d'))
            ->get();

        return $query->result_array();

    }

    public function get_paid_cert_user( $user_id, $course_id ) {

        $query = $this->db
            ->from('paid_certs')
            ->where('user_id', $user_id)
            ->where('course_id', $course_id)
            ->get();

        return $query->row_array();


    }

    public function get_org_admin( $org_id ) {

        $query = $this->db
            ->from('organisation_users')
            ->where('organisation_id', $org_id)
            ->where('is_organisation_admin', 1)
            ->order_by('date_created', 'desc')
            ->get();

        return $query->row_array();

    }

    ////////////////////////////////////
    // UPDATE                        //
    ///////////////////////////////////

    public function update_organisation( $organisation_id, $data ) {

        $this->db->where('id', $organisation_id);
        $this->db->update('organisations', $data);
        return $this->db->affected_rows();

    }

    public function update_course( $course_id, $data ) {

        $this->db->where('id', $course_id);
        $this->db->update('organisation_courses', $data);
        return $this->db->affected_rows();

    }

    public function update_lesson( $lesson_id, $data ) {

        $this->db->where('id', $lesson_id);
        $this->db->update('course_lessons', $data);
        return $this->db->affected_rows();

    }

    public function update_tutor_test_answers( $answer_id, $data ) {

        $this->db->where('id', $answer_id);
        $this->db->update('tutor_lesson_test_answers', $data);
        return $this->db->affected_rows();

    }

    public function enable_course_enrolment( $course_id, $data ) {

        $this->db->where('id', $course_id);
        $this->db->update('organisation_courses', $data);
        return $this->db->affected_rows();

    }

    /* update user details, name, email, etc */
    public function update_details( $data, $user_id ) {

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();

    }

    public function certify( $student_id, $course_id, $data ) {

        if( $data['is_certified'] ) {
            $cert_record = array(
                'user_id' => $student_id,
                'course_id' => $course_id
            );
            $this->db->insert( 'certificate_records', $cert_record );
        }

        $this->db->where('user_id', $student_id);
        $this->db->where('course_id', $course_id);
        $this->db->update('course_students', $data);
        return $this->db->affected_rows();

    }

    public function remove_organisation_user( $organisation_id, $tutor_id ) {

        $data = array(
            'tutor_id' => $this->session->userdata('id')
        );

        $this->db->where('organisation_id', $organisation_id);
        $this->db->where('tutor_id', $tutor_id);
        $this->db->update('organisation_courses', $data);

        $query = $this->db
            ->where('organisation_id', $organisation_id)
            ->where('user_id', $tutor_id);

        $query->delete('organisation_users');

        return $this->db->affected_rows();


    }

    public function delete_post( $data, $user_id, $post_id  ) {

        $this->db->where('user_id', $user_id);
        $this->db->where('id', $post_id);
        $this->db->update('posts', $data);
        return $this->db->affected_rows();

    }

    public function hide_default_post( $data, $user_id ) {

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();

    }

    /* update user avatar link */
    public function update_avatar( $data, $user_id ) {

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        return $this->db->affected_rows();

    }

    public function update_article( $data, $article_id, $user_id ) {

        $this->db->where('id', $article_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('articles', $data);
        return $this->db->affected_rows();

    }

    public function update_article_img( $data, $article_id, $user_id ) {

        $this->db->where('id', $article_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('articles', $data);
        return $this->db->affected_rows();

    }

    public function unhide_post( $post_id, $user_id ) {

        $query = $this->db
            ->where('post_id', $post_id)
            ->where('user_id', $user_id);

        $query->delete('hidden_posts');

        return $this->db->affected_rows();

    }

    public function update_post( $data, $post_id, $user_id ) {

        $this->db->where('id', $post_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('posts', $data);
        return $this->db->affected_rows();

    }

    public function reset_password( $email, $password ) {

        /* clear any old tokens */
        $query = $this->db
            ->where('email', $email);

        $query->delete('password_reset');

        $this->db->where('email', $email);
        $this->db->update('users', array('password' => $password));
        return $this->db->affected_rows();

    }

    public function verify_email( $token ) {

        $query = $this->db
            ->from('verify_email')
            ->where('token', $token)
            ->get();

        $result = $query->row_array();

        if( $result ) {

            $query = $this->db
                ->where('token', $token);

            $query->delete('verify_email');

            $this->db->where('id', $result['user_id']);
            $this->db->update('users', array('is_verified' => 1));

            return true;
        } else {
            return false;
        }

    }

    public function add_email_verification_token( $user_id, $token ) {

        $this->db->insert( 'verify_email', array('user_id' => $user_id, 'token' => $token) );

    }

    public function update_password( $e_password, $user_id ) {

        $this->db->where('id', $user_id);
        $this->db->update('users', array('password' => $e_password));
        return $this->db->affected_rows();

    }

    public function update_email( $email, $user_id ) {

        $this->db->where('id', $user_id);
        $this->db->update('users', array('email' => $email, 'is_verified' => 0));
        return $this->db->affected_rows();

    }

    public function deactivate_account( $user_id ) {

        $this->db->where('id', $user_id);
        $this->db->update('users', array('is_active' => 0));
        return $this->db->affected_rows();

    }

    public function update_course_creation_status( $org_id, $data ) {

        $this->db->where('id', $org_id);
        $this->db->update('organisations', $data);
        return $this->db->affected_rows();

    }

    public function update_ad( $ad_id, $user_id=null, $data ) {

        $this->db->where('id', $ad_id);

        //hotshi admin can bypass - only check if user id is supplied in parameter
        if( $user_id ) {
            $this->db->where('user_id', $user_id);
        }

        $this->db->update('user_ads', $data);
        return $this->db->affected_rows();

    }

    public function update_opportunity( $data, $opportunity_id, $user_id ) {

        $this->db->where('id', $opportunity_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('opportunities', $data);
        return $this->db->affected_rows();

    }

    public function activate_opportunity( $data, $opportunity_id ) {

        $this->db->where('id', $opportunity_id);
        $this->db->update('opportunities', $data);
        return $this->db->affected_rows();

    }

    public function deactivate_opportunity( $data, $opportunity_id ) {

        $this->db->where('id', $opportunity_id);
        $this->db->update('opportunities', $data);
        return $this->db->affected_rows();

    }

    public function update_project( $data, $project_id, $user_id ) {

        $this->db->where('id', $project_id);
        $this->db->where('user_id', $user_id);
        $this->db->update('projects', $data);
        return $this->db->affected_rows();

    }

    public function activate_project( $data, $project_id ) {

        $this->db->where('id', $project_id);
        $this->db->update('projects', $data);
        return $this->db->affected_rows();

    }

    public function deactivate_project( $data, $project_id ) {

        $this->db->where('id', $project_id);
        $this->db->update('projects', $data);
        return $this->db->affected_rows();

    }

    private function remove_accented_characters( $string ) {
        $strict = strtolower( $string );
        $patterns[0] = '/[áâàåä]/ui';
        $patterns[1] = '/[ðéêèë]/ui';
        $patterns[2] = '/[íîìï]/ui';
        $patterns[3] = '/[óôòøõö]/ui';
        $patterns[4] = '/[úûùü]/ui';
        $patterns[5] = '/æ/ui';
        $patterns[6] = '/ç/ui';
        $patterns[7] = '/ß/ui';
        $replacements[0] = 'a';
        $replacements[1] = 'e';
        $replacements[2] = 'i';
        $replacements[3] = 'o';
        $replacements[4] = 'u';
        $replacements[5] = 'ae';
        $replacements[6] = 'c';
        $replacements[7] = 'ss';
        $strict = preg_replace($patterns, $replacements, $strict);

        return $strict;
    }

    public function create_vanity_url( $user_id ) {

        $query = $this->db
            ->from('users')
            ->where('id', $user_id)
            ->get();

        $user = $query->row_array();

        //remove accented characters
        $fullname_clean = $this->remove_accented_characters( $user['fullname'] );

        $new_vanity = strtolower($fullname_clean);
        $new_vanity = str_replace(' ', '', $new_vanity); //remove spaces
        $new_vanity = str_replace("'", "", $new_vanity); //remove apostrophes
        $query = $this->db
            ->from('users')
            ->where('vanity_url', $new_vanity)
            ->get();
        $already_exists = $query->row_array();

        if( $already_exists ) {
            //add user id to vanity string
            $this->db->where('id', $user['id']);
            $this->db->update('users', array('vanity_url' => $new_vanity.$user['id']));
        } else {
            //add vanity string
            $this->db->where('id', $user['id']);
            $this->db->update('users', array('vanity_url' => $new_vanity));
        }

    }



    ////////////////////////////////////
    // DELETE                        //
    ///////////////////////////////////

    public function remove_gallery_image( $user_id, $image_id ) {

        $query = $this->db
            ->where('user_id', $user_id)
            ->where('id', $image_id);

        $query->delete('user_gallery');

        return $this->db->affected_rows();

    }

    public function remove_lecture_vid( $lecture_vid_id ) {

        $query = $this->db
            ->where('id', $lecture_vid_id);

        $query->delete('lesson_lectures');

        return $this->db->affected_rows();

    }

    public function delete_article( $article_id ) {

        $query = $this->db
            ->where('id', $article_id);

        $query->delete('articles');
        return $this->db->affected_rows();

    }

    public function unfollow_org( $org_id, $user_id ) {

        $query = $this->db
            ->where('organisation_id', $org_id)
            ->where('user_id', $user_id);

        $query->delete('follows');
        return $this->db->affected_rows();

    }

    public function delete_ad( $ad_id, $user_id ) {

        $query = $this->db
            ->where('id', $ad_id)
            ->where('user_id', $user_id);

        $query->delete('user_ads');
        return $this->db->affected_rows();

    }

    public function delete_opportunity( $opportunity_id, $user_id ) {

        $query = $this->db
            ->where('id', $opportunity_id)
            ->where('user_id', $user_id);

        $query->delete('opportunities');
        return $this->db->affected_rows();

    }

    public function delete_project( $project_id, $user_id ) {

        $query = $this->db
            ->where('id', $project_id)
            ->where('user_id', $user_id);

        $query->delete('projects');
        return $this->db->affected_rows();

    }

    public function delete_feed_comment( $user_id, $comment_id ) {

        $query = $this->db
            ->where('id', $comment_id)
            ->where('user_id', $user_id);

        $query->delete('post_comments');
        return $this->db->affected_rows();

    }

    public function delete_feed_comment_reply( $user_id, $comment_reply_id ) {

        $query = $this->db
            ->where('id', $comment_reply_id)
            ->where('from_user_id', $user_id);

        $query->delete('post_comment_replies');
        return $this->db->affected_rows();

    }

    public function delete_email_campaign( $campaign_id ) {

        $query = $this->db
            ->where('id', $campaign_id);

        $query->delete('campaigns');
        return $this->db->affected_rows();

    }

    public function delete_course( $course_id ) {

        $query = $this->db
            ->where('id', $course_id);

        $query->delete('organisation_courses');
        return $this->db->affected_rows();

    }

    public function delete_account( $user_email ) {
        $query = $this->db
            ->where('email', $user_email);

        $query->delete('users');
        return $this->db->affected_rows();
    }


    ////////////////////////////////////
    // GENERIC                        //
    ///////////////////////////////////

}