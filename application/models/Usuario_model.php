<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends MY_Model
{

    public function lista()
    {   
        $params = getContents();

        $this->db->where('deletado IS NULL', null, false);
        $total = $this->db->count_all_results('usuarios');

        if ($total) {

            $this->db->select('id, usuario, nome, email, sexo, rg, cpf, inscricao, DATE_FORMAT(data_nascimento, "%d/%m/%Y") AS data_nascimento, DATE_FORMAT(data_registro, "%d/%m/%Y %H:%i:%s") AS data_registro');
            $this->db->where('deletado IS NULL', null, false);
            if(isset($params['sort']) && isset($params['order'])) {
                $this->db->order_by($params['sort'], $params['order']);
            }
            if (isset($params['limit']) && isset($params['offset'])) {
                $this->db->limit($params['limit'], $params['offset']);
            }
            $result = $this->db->get('usuarios');

            if ($result->num_rows()) {
                send(200, ['total' => $total, 'rows' => $result->result_array()]);
            }
        }
        
        send(200, ['total' => 0, 'rows' => []]);
    }
}
