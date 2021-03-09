<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('usuario_model');
    }

    public function lista()
    {
        $this->twig->display('usuario/lista');
    }

    public function novo()
    {
        $this->twig->display('usuario/form');
    }

    public function editar($id)
    {
        $this->twig->display('usuario/form', ['id'=> $id]);
    }

    public function listar()
    {
        $this->usuario_model->listar();
    }
}
