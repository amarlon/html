<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 01/12/14
 * Time: 23:08
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_users extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'fullname' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
            'firstname' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
            'fb_id' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'profession' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'phone' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE
            ),
            'about' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'website' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'gallery_desc' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'password' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'country_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'country_origin_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'last_login' => array(
                'type' => 'DATETIME'
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
            'cv' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'cv_bytes' => array(
                'type' =>'INT',
                'unsigned' => TRUE
            ),
            'cv_public_id' => array(
                'type' =>'TEXT',
                'null' => TRUE
            ),
            'cv_extension' => array(
                'type' =>'TEXT',
                'null' => TRUE
            ),
            'tags' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'iban' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'android_device_id' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'is_active' => array(
                'type' => 'BOOLEAN'
            ),
            'is_clicked_notification' => array(
                'type' => 'BOOLEAN'
            ),
            'notify_email_comments' => array(
                'type' => 'BOOLEAN'
            ),
            'notify_email_on_follow' => array(
                'type' =>'BOOLEAN'
            ),
            'notify_email_newsletter' => array(
                'type' =>'BOOLEAN'
            ),
            'is_organisation_user' => array(
                'type' => 'BOOLEAN'
            ),
            'is_hotshi_admin' => array(
                'type' => 'BOOLEAN'
            ),
            'is_fb_user' => array(
                'type' => 'BOOLEAN'
            ),
            'is_verified' => array(
                'type' =>'BOOLEAN'
            )
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('users', TRUE);

        $this->db->query('ALTER TABLE `users` ADD UNIQUE INDEX `email` (`email`);');
        //$this->db->query('ALTER TABLE `users` ADD CONSTRAINT `FK_user_country` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);');

    }

    public function down() {

        //$this->db->query('alter table `users` drop foreign key `FK_user_country`');
        $this->dbforge->drop_table('users');

    }

}