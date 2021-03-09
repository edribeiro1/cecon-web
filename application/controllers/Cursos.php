<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cursos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cursos_model');
    }

    public function lista()
    {
        $this->twig->display('cursos/lista');
    }

    public function listar()
    {
        $params = getContents();
        $data = $this->cursos_model->listar($params);
        if ($data) {
            send(200, $data);
        }
        send(400, null, 'Erro ao carregar a lista');
    }

    public function novo()
    {
        $this->twig->display('cursos/form');
    }

    public function editar($id)
    {
        
        $this->twig->display('cursos/form', ['id' => $id]);
    }

    public function salvar($id = false)
    {
        $data = getContents();

        if (!validarString($data, 'descricao')) {
            send(400, null, 'Descricao inválida');
        }

        if ($this->cursos_model->salvar($data, $id)) {
            if (validarId($id)) {
                send(200, null, 'Sucesso ao editar');
            }
            send(200, null, 'Sucesso ao cadastrar');
        } else {
            send(400, null, 'Erro ao cadastrar');
        }
    }
}
