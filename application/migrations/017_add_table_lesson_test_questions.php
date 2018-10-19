<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_lesson_test_questions extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'lesson_test_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'created_by' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'question' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('lesson_test_questions', TRUE);

        $this->db->query('ALTER TABLE `lesson_test_questions` ADD CONSTRAINT `FK_lesson_test_questions_test` FOREIGN KEY (`lesson_test_id`) REFERENCES `lesson_tests` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `lesson_test_questions` ADD CONSTRAINT `FK_lesson_test_questions_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `lesson_test_questions` drop foreign key `FK_lesson_test_questions_test`');
        $this->db->query('alter table `lesson_test_questions` drop foreign key `FK_lesson_test_questions_creator`');
        $this->dbforge->drop_table('lesson_test_questions');

    }

}