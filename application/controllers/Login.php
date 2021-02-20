<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('login_model');
    }

    public function index()
    {
        if (($this->session->userdata('session_id'))) {
            redirect('Dashboard');
        } else {
            $this->twig->display('login/index');
        }
    }
   
    public function validar()
    {
        $usuario = $this->input->post('usuario');
        $senha = md5($this->input->post('senha'));
        $data = $this->login_model->validar($usuario, $senha);
        if ($data) {
            send();
        }
        send(400, null, 'Usuário ou senha incorretos');
    }

    public function sair()
    {
        $this->session->sess_destroy();
        header('Location:'.base_url().'login');
    }

    public function criar()
    {
        if (($this->session->userdata('session_id'))) {
            redirect('Dashboard');
        } else {
            $this->twig->display('usuario/cadastro');
        }
    }

    public function salvar()
    {
        $this->load->model('usuario_model');
        if ($this->usuario_model->save() ) {
            send(200, null, 'Sucesso ao cadastrar');
        } else {
            send(400, null, 'Erro ao cadastrar');
        }
    }
}
