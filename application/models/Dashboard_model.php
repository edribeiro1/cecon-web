<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function dadosIniciais()
    {
        $this->db->select('nome, telefone, inscricao');
        $this->db->where('id', $this->idUsuario);
        $result = $this->db->get('usuarios');

        if ($result->num_rows()) {
            return $result->row_array();
        }
        return false;

    }
}
