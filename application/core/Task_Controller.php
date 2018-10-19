<?php
/**
 * Created by PhpStorm.
 * User: benshittu
 * Date: 01/12/14
 * Time: 20:32
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Task_Controller extends CI_Controller {

    public function __construct() {

        parent::__construct();

        $_SERVER['REMOTE_ADDR'] = '';

        $this->input->is_cli_request()
        or exit("Execute via command line: ./task.sh " . strtolower(get_called_class()) . " [arguments]");
    }
}