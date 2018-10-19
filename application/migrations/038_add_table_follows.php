<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 17/11/15
 * Time: 10:10 AM
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_follows extends CI_Migration {

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
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('follows', TRUE);

        $this->db->query('ALTER TABLE `follows` ADD CONSTRAINT `FK_company_follows` FOREIGN KEY (`organisation_id`) REFERENCES `organisations` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `follows` ADD CONSTRAINT `FK_user_follower` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `follows` drop foreign key `FK_company_follows`');
        $this->db->query('alter table `follows` drop foreign key `FK_user_follower`');
        $this->dbforge->drop_table('follows');

    }

}