<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Microempreendedor extends MY_Controller {
//    public function __construct() {
//       parent::__construct();
//       $this->load->model('microempreendedor_model');
//    }

	public function index() {
      $this->twig->display('microempreendedor/index');
   }
}
