<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 01/12/14
 * Time: 23:08
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_articles extends CI_Migration {

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
                'null' => TRUE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'tags' => array(
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
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('articles', TRUE);

        $this->db->query('ALTER TABLE `articles` ADD CONSTRAINT `FK_articles_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `articles` drop foreign key `FK_articles_user`');
        $this->dbforge->drop_table('articles');

    }

}