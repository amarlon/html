<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_organisations_1_5_2016_3pm extends CI_Migration {

    public function up() {

        $fields = array(
            'about' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'website' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'country_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
        );

        $this->dbforge->add_column('organisations', $fields);

    }

    public function down() {

        $this->dbforge->drop_column('organisations', 'about');
        $this->dbforge->drop_column('organisations', 'website');
        $this->dbforge->drop_column('organisations', 'country_id');

    }

}