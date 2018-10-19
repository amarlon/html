<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_organisation_users extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'organisation_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'organisation_role' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'is_organisation_admin' => array(
                'type' => 'BOOLEAN'
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('organisation_users', TRUE);

        $this->db->query('ALTER TABLE `organisation_users` ADD CONSTRAINT `FK_organisation_users_organisation` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `organisation_users` ADD CONSTRAINT `FK_organisation_users_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `organisation_users` drop foreign key `FK_organisation_users_organisation`');
        $this->db->query('alter table `organisation_users` drop foreign key `FK_organisation_users_user`');
        $this->dbforge->drop_table('organisation_users');

    }

}