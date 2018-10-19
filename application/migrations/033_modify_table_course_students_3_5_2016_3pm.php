<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_course_students_3_5_2016_3pm extends CI_Migration {

    public function up() {

        $fields = array(
            'is_failed' => array(
                'type' => 'BOOLEAN'
            )
        );

        $this->dbforge->add_column('course_students', $fields);

    }

    public function down() {

        $this->dbforge->drop_column('course_students', 'is_failed');

    }

}