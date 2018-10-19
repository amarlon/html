<?php
/**
 * Created by PhpStorm.
 * User: bensh
 * Date: 15/3/18
 * Time: 13:19
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Modify_table_users_15_mar_2018 extends CI_Migration {

    public function up() {

        $fields = array(
            'vanity_url' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        );

        $this->dbforge->add_column('users', $fields);

    }

    public function down() {

        $this->dbforge->drop_column('users', 'vanity_url');

    }

}