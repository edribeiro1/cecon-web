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
        $this->twig->display('dashboard/index');
    }

    public function dadosIniciais()
    {
        $dados = $this->dashboard_model->dadosIniciais();
        if ($dados) {
            send(200, $dados);
        }
        send(400, null, 'Erro em consultar os dados do usuário');
    }
}
