<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_organisations_1_5_2016_8pm extends CI_Migration {

    public function up() {

        $fields = array(
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
        );

        $this->dbforge->add_column('organisations', $fields);

    }

    public function down() {

        $this->dbforge->drop_column('organisations', 'intro_video');
        $this->dbforge->drop_column('organisations', 'intro_video_bytes');
        $this->dbforge->drop_column('organisations', 'intro_video_public_id');

    }

}