<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 01/12/14
 * Time: 20:31
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once( APPPATH . '/core/Task_Controller.php');

class Migrate extends Task_Controller {
    public $version;
    public $message;

    public function __construct() {
        parent::__construct();

        $this->load->library('migration');

        $this->version = $this->get_migration_version();
    }

    public function index() {

        $starting_version = $this->version;

        $this->migration->latest();

        $this->version = $this->get_migration_version();

        if ($this->version === $starting_version) {
            $this->message = 'Already on latest migration ('.$this->version.')';

        } else {
            $this->message = 'Updated to latest migration ('.$this->version.')';
        }

        $this->print_output();
    }

    public function up() {
        $this->version = $this->version + 1;
        $this->message = 'Moved up to migration '.$this->version;
        $this->migrate_to_version();
    }

    public function down() {
        $this->version = $this->version - 1;
        $this->message = 'Dropped down to migration '.$this->version;
        $this->migrate_to_version();
    }

    public function version($target_version) {
        $this->version = $target_version;
        $this->message = 'Updated to migration '.$this->version;
        $this->migrate_to_version();
    }

    /* Internal functions */

    private function migrate_to_version() {
        $this->migration->version($this->version);
        $this->print_output();
    }

    private function print_output() {

        echo $this->message . "\n";

        $error_message = $this->migration->error_string();
        if ($error_message) {
            echo $error_message . "\n";
        }
    }

    private function get_migration_version() {
        $row = $this->db->get('migrations')->row();
        return $row ? $row->version : 0;
    }

    /* Alias functions */

    public function u() {
        $this->up();
    }

    public function d() {
        $this->down();
    }

    public function v($target_version) {
        $this->version($target_version);
    }
}