<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MaterialDivulgacao extends MY_Controller
{
    public function index()
    {
        $this->load->model('TextosTelas_model');
        $dados = $this->TextosTelas_model->getTemplate(2);
        $this->twig->display('materialdivulgacao/index', $dados);
    }
}
