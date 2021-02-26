<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model');
    }

    public function index()
    {
        $dados = $this->dashboard_model->dadosIniciais();
        $this->twig->display('dashboard/index', $dados);
    }

}
