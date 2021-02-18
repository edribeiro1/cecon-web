<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct() {
      parent::__construct();
        
        if ((!$this->session->userdata('session_id'))) {
            redirect('login');
        }

        $this->twig->addGlobal('nome', $this->session->userdata('nome'));
        $this->twig->addGlobal('id_usuario', $this->session->userdata('id_usuario'));
        $this->twig->addGlobal('administrador', $this->session->userdata('administrador'));

        $this->idUsuario = $this->session->userdata('id_usuario');
        $this->administrador = $this->session->userdata('administrador') == 1 ? true : false;
	}
}

?>