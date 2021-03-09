<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Perguntas extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('perguntas_model');
    }

    public function index()
    {
        $this->twig->display('perguntas');
    }

}
