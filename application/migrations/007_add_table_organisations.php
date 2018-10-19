<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 01/12/14
 * Time: 23:08
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_organisations extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'profile_image' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'profile_image_bytes' => array(
                'type' =>'INT',
                'unsigned' => TRUE
            ),
            'profile_image_public_id' => array(
                'type' =>'TEXT',
                'null' => TRUE
            ),
            'is_active' => array(
                'type' => 'BOOLEAN'
            ),
            'can_create_course' => array(
                'type' =>'BOOLEAN'
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('organisations', TRUE);

    }

    public function down() {

        $this->dbforge->drop_table('organisations');

    }

}