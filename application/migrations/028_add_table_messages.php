<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 23/11/15
 * Time: 1:59 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_messages extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'messages_map_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'sender_user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'image' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'bytes' => array(
                'type' =>'INT',
                'unsigned' => TRUE
            ),
            'public_id' => array(
                'type' =>'TEXT',
                'null' => TRUE
            ),
            'is_seen' => array(
                'type' =>'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('messages', TRUE);

        $this->db->query('ALTER TABLE `messages` ADD CONSTRAINT `FK_messages_map_message` FOREIGN KEY (`messages_map_id`) REFERENCES `messages_map` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `messages` ADD CONSTRAINT `FK_messages_map_message_sender` FOREIGN KEY (`sender_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `messages` drop foreign key `FK_messages_map_message`');
        $this->db->query('alter table `messages` drop foreign key `FK_messages_map_message_sender`');
        $this->dbforge->drop_table('messages');

    }

}