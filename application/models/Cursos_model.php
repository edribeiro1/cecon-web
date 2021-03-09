<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cursos_model extends CI_Model
{
    public function salvar($data=[], $id=false)
    {
        $this->db->set($data);

        if (validarId($id)) {
            $this->db->where('id', $id);
            return $this->db->update('cursos');
        }

        return $this->db->insert('cursos', $data);
    }

    public function listar($params=[])
    {
        $this->db->where('deletado', 0);
        $total = $this->db->count_all_results('cursos');

        if ($total) {
            $this->db->select('id, descricao, DATE_FORMAT(CONVERT_TZ(data_cadastro, "+00:00", "-03:00"), "%d/%m/%Y %H:%i:%s") AS data_cadastro');
            $this->db->where('deletado', 0);

            if (isset($params['sort']) && isset($params['order'])) {
                $this->db->order_by($params['sort'], $params['order']);
            }
            if (isset($params['limit']) && isset($params['offset'])) {
                $this->db->limit($params['limit'], $params['offset']);
            }

            $result = $this->db->get('cursos');

            if ($result->num_rows()) {
                return ['total' => $total, 'rows' => $result->result_array()];
            }
        }
        
        return ['total' => 0, 'rows' => []];
    }
}
