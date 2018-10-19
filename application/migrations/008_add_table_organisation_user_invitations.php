<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_organisation_user_invitations extends CI_Migration {

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
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => FALSE
            ),
            'organisation_role' => array(
                'type' => 'TEXT',
                'null' => TRUE
            ),
            'token' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('organisation_user_invitations', TRUE);

        $this->db->query('ALTER TABLE `organisation_user_invitations` ADD CONSTRAINT `FK_organisation_user_invitations` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `organisation_user_invitations` drop foreign key `FK_organisation_user_invitations`');
        $this->dbforge->drop_table('organisation_user_invitations');

    }

}