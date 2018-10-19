<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_user_lesson_test_answers extends CI_Migration {

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
            'user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'answer_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('user_lesson_test_answers', TRUE);

        $this->db->query('ALTER TABLE `user_lesson_test_answers` ADD CONSTRAINT `FK_user_lesson_test_answers_question` FOREIGN KEY (`lesson_test_question_id`) REFERENCES `lesson_test_questions` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `user_lesson_test_answers` ADD CONSTRAINT `FK_user_lesson_test_answers_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `user_lesson_test_answers` ADD CONSTRAINT `FK_user_lesson_test_answers_answer` FOREIGN KEY (`answer_id`) REFERENCES `tutor_lesson_test_answers` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `user_lesson_test_answers` drop foreign key `FK_user_lesson_test_answers_question`');
        $this->db->query('alter table `user_lesson_test_answers` drop foreign key `FK_user_lesson_test_answers_user`');
        $this->db->query('alter table `user_lesson_test_answers` drop foreign key `FK_user_lesson_test_answers_answer`');
        $this->dbforge->drop_table('user_lesson_test_answers');

    }

}