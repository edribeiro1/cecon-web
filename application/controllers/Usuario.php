<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends MY_Controller {

   public function __construct() {
      parent::__construct();
      $this->load->model('usuario_model');
   }

	public function index() {
        $this->twig->display('usuario/lista');
    }

   public function novo() {
      $this->twig->display('usuario/form');
   }

   public function editar($id) {
      $this->twig->display('usuario/form', array('id'=> $id));
   }

   public function lista() {
      $this->usuario_model->lista();
   }
   
}
