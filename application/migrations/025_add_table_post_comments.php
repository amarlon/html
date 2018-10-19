<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 17/11/15
 * Time: 10:30 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_post_comments extends CI_Migration {

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
            'comment' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'is_seen' => array(
                'type' =>'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('post_comments', TRUE);

        $this->db->query('ALTER TABLE `post_comments` ADD CONSTRAINT `FK_post_comment_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `post_comments` ADD CONSTRAINT `FK_post_comment_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `post_comments` drop foreign key `FK_post_comment_post`');
        $this->db->query('alter table `post_comments` drop foreign key `FK_post_comment_user`');
        $this->dbforge->drop_table('post_comments');

    }

}