<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_course_lessons extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'course_id' => array(
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
            'doc' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'doc_bytes' => array(
                'type' =>'INT',
                'unsigned' => TRUE
            ),
            'doc_public_id' => array(
                'type' =>'TEXT',
                'null' => TRUE
            ),
            'is_deleted' => array(
                'type' =>'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('course_lessons', TRUE);

        $this->db->query('ALTER TABLE `course_lessons` ADD CONSTRAINT `FK_course_lessons_course` FOREIGN KEY (`course_id`) REFERENCES `organisation_courses` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `course_lessons` ADD CONSTRAINT `FK_course_lessons_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `course_lessons` drop foreign key `FK_course_lessons_course`');
        $this->db->query('alter table `course_lessons` drop foreign key `FK_course_lessons_creator`');
        $this->dbforge->drop_table('course_lessons');

    }

}