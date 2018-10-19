<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_user_lesson_test_grades_6_5_2016_6pm extends CI_Migration {

    public function up() {

        $fields = array(
            'tutor_comment' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        );

        $this->dbforge->add_column('user_lesson_test_grades', $fields);

    }

    public function down() {

        $this->dbforge->drop_column('user_lesson_test_grades', 'tutor_comment');

    }

}