<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 12/12/14
 * Time: 16:53
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_course_levels extends CI_Migration {

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
        $this->dbforge->create_table('course_levels', TRUE);

        $data = array(
            array('name' => 'Beginner'),
            array('name' => 'Intermediate'),
            array('name' => 'Advanced')
        );

        $this->db->insert_batch('course_levels', $data);

    }

    public function down() {

        $this->dbforge->drop_table('course_levels');

    }

}