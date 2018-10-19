<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 12/09/2017
 * Time: 19:19
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_campaigns extends CI_Migration {

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
            'send_to' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'subject' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'cta_link' => array(
                'type' => 'TEXT',
                'null' => TRUE
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
        $this->dbforge->create_table('campaigns', TRUE);

        $this->db->query('ALTER TABLE `campaigns` ADD CONSTRAINT `FK_user_campaign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `campaigns` drop foreign key `FK_user_campaign`');
        $this->dbforge->drop_table('campaigns');

    }

}