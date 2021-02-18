<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logotipo extends MY_Controller {
//    public function __construct() {
//       parent::__construct();
//       $this->load->model('logotipo_model');
//    }

	public function index() {
      $this->twig->display('logotipo/index');
   }
}
