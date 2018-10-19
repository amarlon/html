<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_user_lesson_test_grades extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'lesson_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'graded_by' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'grade' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('user_lesson_test_grades', TRUE);

        $this->db->query('ALTER TABLE `user_lesson_test_grades` ADD CONSTRAINT `FK_user_lesson_test_grades_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `user_lesson_test_grades` ADD CONSTRAINT `FK_user_lesson_test_grades_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `user_lesson_test_grades` ADD CONSTRAINT `FK_user_lesson_test_grades_grader` FOREIGN KEY (`graded_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `user_lesson_test_grades` drop foreign key `FK_user_lesson_test_grades_user`');
        $this->db->query('alter table `user_lesson_test_grades` drop foreign key `FK_user_lesson_test_grades_lesson`');
        $this->db->query('alter table `user_lesson_test_grades` drop foreign key `FK_user_lesson_test_grades_grader`');
        $this->dbforge->drop_table('user_lesson_test_grades');

    }

}