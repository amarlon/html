<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 12/12/14
 * Time: 16:53
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_course_categories extends CI_Migration {

    public function up() {

        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('course_categories', TRUE);

        $data = array(
            array('name' => 'Business'),
            array('name' => 'Computers'),
            array('name' => 'Programming'),
            array('name' => 'Design'),
            array('name' => 'Psychology'),
            array('name' => 'Science'),
            array('name' => 'Education'),
            array('name' => 'Child care'),
            array('name' => 'Politics'),
            array('name' => 'Languages'),
            array('name' => 'History'),
            array('name' => 'Economics'),
            array('name' => 'Media'),
            array('name' => 'Music'),
            array('name' => 'Law'),
            array('name' => 'Sociology'),
            array('name' => 'Pharmacy'),
            array('name' => 'Physiotherapy'),
            array('name' => 'Maths'),
            array('name' => 'Chemistry'),
            array('name' => 'Biology'),
            array('name' => 'Engineering'),
            array('name' => 'Geography'),
            array('name' => 'Genetics'),
            array('name' => 'Geology'),
            array('name' => 'Neuroscience'),
            array('name' => 'Physics'),
            array('name' => 'Zoology'),
            array('name' => 'Medicine'),
            array('name' => 'Midwifery'),
            array('name' => 'Dental science'),
            array('name' => 'Philosophy'),
            array('name' => 'Religion')
        );

        $this->db->insert_batch('course_categories', $data);

    }

    public function down() {

        $this->dbforge->drop_table('course_categories');

    }

}