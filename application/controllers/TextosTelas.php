<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TextosTelas extends MY_Controller
{
    public function salvar($id)
    {
        $this->load->model('TextosTelas_model');
        if($this->TextosTelas_model->salvar($id, getContents())) {
            send(200, null, 'Alterado com sucesso!');
        } else {
            send(400);
        }
    }
}
