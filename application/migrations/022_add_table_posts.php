<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 17/11/15
 * Time: 10:10 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_posts extends CI_Migration {

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
            'is_deleted' => array(
                'type' => 'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('posts', TRUE);

        $this->db->query('ALTER TABLE `posts` ADD CONSTRAINT `FK_user_post` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `posts` drop foreign key `FK_user_post`');
        $this->dbforge->drop_table('posts');

    }

}