<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cursos_model extends CI_Model
{
    public function salvar($data=[], $id=false)
    {
        $this->db->set($data);

        if ($id) {
            $this->db->where('id', $id);
            $this->db->update('cursos');
        } else {
            $this->db->insert('cursos', $data);
        }

        if ($this->db->affected_rows()) {
            return true;
        }
        return false;
    }

    public function get($id)
    {
        $this->db->select('id, descricao');
        $this->db->where('id', $id);
        $this->db->where('deletado', 0);
        $result = $this->db->get('cursos');
        if ($result->num_rows()) {
            return $result->row_array();
        }
        return false;
    }

    public function listar($params=[])
    {
        $this->db->where('deletado', 0);
        $total = $this->db->count_all_results('cursos');

        if ($total) {
            $this->db->select(sprintf('id, descricao, %s, %s', formataDataSQL('data_cadastro'), formataDataSQL('data_alteracao')));
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


    public function deletar($ids=[])
    {
        if (is_array($ids) && count($ids)) {
            $this->db->where_in('id', $ids);
            $this->db->limit(count($ids));
            $this->db->set('deletado', 1);
            $this->db->update('cursos');
    
            if ($this->db->affected_rows()) {
                return true;
            }
        }

        return false;
    }
}
