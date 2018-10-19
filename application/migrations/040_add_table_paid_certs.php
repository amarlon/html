<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 11/01/15
 * Time: 16:27
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Add_table_paid_certs extends CI_Migration {

    public function up() {
        $fields = array(
            'id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'course_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'amount_paid' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE); //PK
        $this->dbforge->create_table('paid_certs', TRUE);

        $this->db->query('ALTER TABLE `paid_certs` ADD CONSTRAINT `FK_paid_certs_course` FOREIGN KEY (`course_id`) REFERENCES `organisation_courses` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');
        $this->db->query('ALTER TABLE `paid_certs` ADD CONSTRAINT `FK_paid_certs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON UPDATE CASCADE ON DELETE CASCADE;');

    }

    public function down() {

        $this->db->query('alter table `paid_certs` drop foreign key `FK_paid_certs_course`');
        $this->db->query('alter table `paid_certs` drop foreign key `FK_paid_certs_user`');
        $this->dbforge->drop_table('paid_certs');

    }

}