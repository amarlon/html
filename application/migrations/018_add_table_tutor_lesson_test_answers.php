<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_tutor_lesson_test_answers extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'lesson_test_question_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'created_by' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'answer' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'is_correct_answer' => array(
                'type' => 'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('tutor_lesson_test_answers', TRUE);

        $this->db->query('ALTER TABLE `tutor_lesson_test_answers` ADD CONSTRAINT `FK_tutor_lesson_test_answers_question` FOREIGN KEY (`lesson_test_question_id`) REFERENCES `lesson_test_questions` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `tutor_lesson_test_answers` ADD CONSTRAINT `FK_tutor_lesson_test_answers_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `tutor_lesson_test_answers` drop foreign key `FK_tutor_lesson_test_answers_question`');
        $this->db->query('alter table `tutor_lesson_test_answers` drop foreign key `FK_tutor_lesson_test_answers_creator`');
        $this->dbforge->drop_table('tutor_lesson_test_answers');

    }

}