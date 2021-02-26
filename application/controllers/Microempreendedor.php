<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Microempreendedor extends MY_Controller
{
    public function index()
    {
        $this->load->model('TextosTelas_model');
        $dados = $this->TextosTelas_model->getTemplate(1);
        $this->twig->display('microempreendedor/index', $dados);
    }
}
