<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_user_ads extends CI_Migration {

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
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'start_date' => array(
                'type' => 'DATE'
            ),
            'end_date' => array(
                'type' => 'DATE'
            ),
            'charge_per_day' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'image' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'link' => array(
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
            'duration' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'is_active' => array(
                'type' => 'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('user_ads', TRUE);

        $this->db->query('ALTER TABLE `user_ads` ADD CONSTRAINT `FK_user_ads_creator` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `user_ads` drop foreign key `FK_user_ads_creator`');
        $this->dbforge->drop_table('user_ads');

    }

}