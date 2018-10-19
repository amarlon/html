<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 16/11/15
 * Time: 7:51 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_user_gallery extends CI_Migration {

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
            'image' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'bytes' => array(
                'type' =>'INT',
                'unsigned' => TRUE
            ),
            'public_id' => array(
                'type' =>'TEXT',
                'null' => FALSE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('user_gallery', TRUE);

        $this->db->query('ALTER TABLE `user_gallery` ADD CONSTRAINT `FK_user_images_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `user_gallery` drop foreign key `FK_user_images_user`');
        $this->dbforge->drop_table('user_gallery');

    }

}