<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_lesson_lectures extends CI_Migration {

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
            'video_title' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'video' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'video_bytes' => array(
                'type' =>'INT',
                'unsigned' => FALSE
            ),
            'video_public_id' => array(
                'type' =>'TEXT',
                'null' => FALSE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('lesson_lectures', TRUE);

        $this->db->query('ALTER TABLE `lesson_lectures` ADD CONSTRAINT `FK_lesson_lectures_lesson` FOREIGN KEY (`lesson_id`) REFERENCES `course_lessons` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `lesson_lectures` drop foreign key `FK_lesson_lectures_lesson`');
        $this->dbforge->drop_table('lesson_lectures');

    }

}