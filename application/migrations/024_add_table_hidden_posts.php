<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 17/11/15
 * Time: 10:10 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_hidden_posts extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'post_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('hidden_posts', TRUE);

        $this->db->query('ALTER TABLE `hidden_posts` ADD CONSTRAINT `FK_hidden_posts_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `hidden_posts` ADD CONSTRAINT `FK_hidden_posts_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `hidden_posts` drop foreign key `FK_hidden_posts_post`');
        $this->db->query('alter table `hidden_posts` drop foreign key `FK_hidden_posts_user`');
        $this->dbforge->drop_table('hidden_posts');

    }

}