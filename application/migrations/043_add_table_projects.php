<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 12/09/2017
 * Time: 19:19
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_projects extends CI_Migration {

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
            'title' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'qualifications' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'skills' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'location' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'image' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'image_bytes' => array(
                'type' =>'INT',
                'unsigned' => TRUE
            ),
            'image_public_id' => array(
                'type' =>'TEXT',
                'null' => TRUE
            ),
            'is_active' => array(
                'type' => 'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('projects', TRUE);

        $this->db->query('ALTER TABLE `projects` ADD CONSTRAINT `FK_user_project` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `projects` drop foreign key `FK_user_project`');
        $this->dbforge->drop_table('projects');

    }

}