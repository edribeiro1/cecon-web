<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cursos extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cursos_model');
    }

    public function get($id)
    {
        if (validarId($id)) {
            $data = $this->cursos_model->get($id);
            if ($data) {
                send(200, $data);
            }
        }
      
        send(400, null, 'Erro ao buscar os dados do curso');
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

    public function deletar()
    {
        $data = getContents();
        if (isset($data['id']) && is_array($data['id']) && count($data['id'])) {
            if ($this->cursos_model->deletar(array_map('intval', $data['id']))) {
                send(200, null, 'Deletado com sucesso');
            }
        }
        send(400, null, 'Erro ao deletar os registros');
    }

    public function salvar()
    {
        $data = getContents();
        $id = false;

        if (validarId($data, 'id')) {
            $id = (int)$data['id'];
            unset($data['id']);
        }

        if (!validarString($data, 'descricao')) {
            send(400, null, 'Descricao inválida');
        }

        if ($this->cursos_model->salvar($data, $id)) {
            if ($id) {
                send(200, null, 'Editado com sucesso');
            }
            send(200, null, 'Cadastrado com sucesso');
        } else {
            send(400, null, 'Erro ao cadastrar');
        }
    }
}
