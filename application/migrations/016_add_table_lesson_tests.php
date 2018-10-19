<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_lesson_tests extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'lesson_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'created_by' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'title' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('lesson_tests', TRUE);

        $this->db->query('ALTER TABLE `lesson_tests` ADD CONSTRAINT `FK_lesson_tests_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `lesson_tests` ADD CONSTRAINT `FK_lesson_tests_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `lesson_tests` drop foreign key `FK_lesson_tests_lesson`');
        $this->db->query('alter table `lesson_tests` drop foreign key `FK_lesson_tests_creator`');
        $this->dbforge->drop_table('lesson_tests');

    }

}