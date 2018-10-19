<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_user_lesson_test_answers_4_5_2016_9pm extends CI_Migration {

    public function up() {

        $fields = array(
            'lesson_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'is_correct_answer' => array(
                'type' => 'BOOLEAN'
            ),
            'answer' => array(
                'type' => 'TEXT',
                'null' => FALSE
            )
        );

        $this->dbforge->add_column('user_lesson_test_answers', $fields);

        $this->db->query('ALTER TABLE `user_lesson_test_answers` ADD CONSTRAINT `FK_lesson_id_user_answers` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

        $this->db->query('alter table `user_lesson_test_answers` drop foreign key `FK_user_lesson_test_answers_answer`');
        $this->dbforge->drop_column('user_lesson_test_answers', 'answer_id');

    }

    public function down() {

        $this->db->query('alter table `user_lesson_test_answers` drop foreign key `FK_lesson_id_user_answers`');
        $this->dbforge->drop_column('user_lesson_test_answers', 'lesson_id');
        $this->dbforge->drop_column('user_lesson_test_answers', 'is_correct_answer');
        $this->dbforge->drop_column('user_lesson_test_answers', 'answer');

    }

}