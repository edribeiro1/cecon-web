<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cursos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cursos_model');
    }

    public function index()
    {
        $this->twig->display('cursos/lista');
    }

}
