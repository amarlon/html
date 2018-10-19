<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 22/11/15
 * Time: 1:24 PM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_post_comment_replies extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'comment_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'from_user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'to_user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'comment' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('post_comment_replies', TRUE);

        $this->db->query('ALTER TABLE `post_comment_replies` ADD CONSTRAINT `FK_post_comment_post_reply` FOREIGN KEY (`comment_id`) REFERENCES `post_comments` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `post_comment_replies` ADD CONSTRAINT `FK_post_comment_from_user_reply` FOREIGN KEY (`from_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `post_comment_replies` ADD CONSTRAINT `FK_post_comment_to_user_reply` FOREIGN KEY (`to_user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `post_comment_replies` drop foreign key `FK_post_comment_post_reply`');
        $this->db->query('alter table `post_comment_replies` drop foreign key `FK_post_comment_from_user_reply`');
        $this->db->query('alter table `post_comment_replies` drop foreign key `FK_post_comment_to_user_reply`');
        $this->dbforge->drop_table('post_comment_replies');

    }

}