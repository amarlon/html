<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 17/11/15
 * Time: 10:10 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_certificate_records extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'course_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('certificate_records', TRUE);

    }

    public function down() {

        $this->dbforge->drop_table('certificate_records');

    }

}