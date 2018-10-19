<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_organisation_courses extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'organisation_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'tutor_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'course_category_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'course_level_id' => array(
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
            'can_enrol' => array(
                'type' => 'BOOLEAN'
            ),
            'start_date' => array(
                'type' => 'DATE'
            ),
            'end_date' => array(
                'type' => 'DATE'
            ),
            'intro_video' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'intro_video_bytes' => array(
                'type' =>'INT',
                'unsigned' => TRUE
            ),
            'intro_video_public_id' => array(
                'type' =>'TEXT',
                'null' => TRUE
            ),
            'cert_cost' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('organisation_courses', TRUE);

        $this->db->query('ALTER TABLE `organisation_courses` ADD CONSTRAINT `FK_organisation_courses_organisation` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `organisation_courses` ADD CONSTRAINT `FK_organisation_courses_tutor` FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `organisation_courses` ADD CONSTRAINT `FK_organisation_courses_category` FOREIGN KEY (`course_category_id`) REFERENCES `course_categories` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `organisation_courses` ADD CONSTRAINT `FK_organisation_courses_level` FOREIGN KEY (`course_level_id`) REFERENCES `course_levels` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `organisation_courses` ADD CONSTRAINT `FK_organisation_courses_creator` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `organisation_courses` drop foreign key `FK_organisation_courses_organisation`');
        $this->db->query('alter table `organisation_courses` drop foreign key `FK_organisation_courses_tutor`');
        $this->db->query('alter table `organisation_courses` drop foreign key `FK_organisation_courses_creator`');
        $this->db->query('alter table `organisation_courses` drop foreign key `FK_organisation_courses_category`');
        $this->db->query('alter table `organisation_courses` drop foreign key `FK_organisation_courses_level`');
        $this->dbforge->drop_table('organisation_courses');

    }

}