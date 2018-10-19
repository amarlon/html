<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 23/11/15
 * Time: 2:45 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_messages_map extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_a_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'user_b_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'last_updated' => array(
                'type' => 'DATETIME'
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('messages_map', TRUE);

        $this->db->query('ALTER TABLE `messages_map` ADD CONSTRAINT `FK_message_user_user_a` FOREIGN KEY (`user_a_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `messages_map` ADD CONSTRAINT `FK_message_user_user_b` FOREIGN KEY (`user_b_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `messages_map` drop foreign key `FK_message_user_user_a`');
        $this->db->query('alter table `messages_map` drop foreign key `FK_message_user_user_b`');
        $this->dbforge->drop_table('messages_map');

    }

}