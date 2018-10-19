<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_course_students_3_5_2016_2pm extends CI_Migration {

    public function up() {

        $fields = array(
            'is_certified' => array(
                'type' => 'BOOLEAN'
            ),
            'certified_by' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            )
        );

        $this->dbforge->add_column('course_students', $fields);
        $this->dbforge->drop_column('course_students', 'course_certificate');

    }

    public function down() {

        $this->dbforge->drop_column('course_students', 'is_certified');
        $this->dbforge->drop_column('course_students', 'certified_by');

    }

}