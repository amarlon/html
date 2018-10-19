<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 17/11/15
 * Time: 10:10 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_post_likes extends CI_Migration {

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
        $this->dbforge->create_table('post_likes', TRUE);

        $this->db->query('ALTER TABLE `post_likes` ADD CONSTRAINT `FK_post_likes_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `post_likes` ADD CONSTRAINT `FK_post_likes_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `post_likes` drop foreign key `FK_post_likes_post`');
        $this->db->query('alter table `post_likes` drop foreign key `FK_post_likes_user`');
        $this->dbforge->drop_table('post_likes');

    }

}