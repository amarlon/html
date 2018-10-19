<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 18/01/15
 * Time: 12:42
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_password_reset extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
            'token' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('password_reset', TRUE);

    }

    public function down() {

        $this->dbforge->drop_table('password_reset');

    }

}