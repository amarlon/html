<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_course_students extends CI_Migration {

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
            'course_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'is_completed_course' => array(
                'type' => 'BOOLEAN'
            ),
            'is_left_course' => array(
                'type' => 'BOOLEAN'
            ),
            'final_grade' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'tutor_comment' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'course_certificate' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('course_students', TRUE);

        $this->db->query('ALTER TABLE `course_students` ADD CONSTRAINT `FK_course_students_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `course_students` ADD CONSTRAINT `FK_course_students_course` FOREIGN KEY (`course_id`) REFERENCES `organisation_courses` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `course_students` drop foreign key `FK_course_students_user`');
        $this->db->query('alter table `course_students` drop foreign key `FK_course_students_course`');
        $this->dbforge->drop_table('course_students');

    }

}