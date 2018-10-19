<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_posts_7_5_2016_9am extends CI_Migration {

    public function up() {

        $fields = array(
            'course_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            )
        );

        $this->dbforge->add_column('posts', $fields);

    }

    public function down() {

        $this->dbforge->drop_column('posts', 'course_id');

    }

}