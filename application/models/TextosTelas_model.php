<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TextosTelas_model extends CI_Model
{
    public function getTemplate($idTela)
    {
        $this->db->select('id as id_tela, titulo, corpo');
        $this->db->where('id', $idTela);
        $result = $this->db->get('telas');

        if ($result->num_rows()) {
            return $result->row_array();
        }
    }


    public function salvar($idTela, $params)
    {
        if (is_numeric($idTela) && (int)$idTela > 0 && isset($params['titulo']) && isset($params['corpo']) ) {
            $this->db->where('id', $idTela);
            $this->db->set($params);
            return $this->db->update('telas');
        }
        return false;
    }
}
