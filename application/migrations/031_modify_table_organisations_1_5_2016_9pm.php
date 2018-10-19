<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_organisations_1_5_2016_9pm extends CI_Migration {

    public function up() {

        $fields = array(
            'institution_name' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
        );

        $this->dbforge->add_column('organisations', $fields);

    }

    public function down() {

        $this->dbforge->drop_column('organisations', 'institution_name');

    }

}