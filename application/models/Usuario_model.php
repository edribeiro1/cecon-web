<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Usuario_model extends CI_Model
{

    private $fields = [
        'usuario' =>                 ['type' => 'varchar', 'required' => true],
        'senha' =>                   ['type' => 'varchar', 'required' => true],
        'nome' =>                    ['type' => 'varchar', 'required' => true],
        'email' =>                    ['type' => 'varchar', 'required' => false],
        'sexo' =>                     ['type' => 'varchar', 'required' => false],
        'telefone' =>               ['type' => 'varchar', 'required' => false],
        'rg' =>                         ['type' => 'varchar', 'required' => false],
        'cpf' =>                       ['type' => 'varchar', 'required' => false],
        'inscricao' =>              ['type' => 'varchar', 'required' => false],
        'data_nascimento' => ['type' => 'date', 'required' => false]
    ];

    private function formatData($data)
    {
        $formattedData = [];

        foreach($data as $key => $value) {
            if (isset($this->fields[$key])) {

                if($value && strlen(trim($value)) > 0) {
                    if ($key == 'senha') {
                        $value = md5(trim($value));
                    }
                    $formattedData[$key] = trim($value);
                } else {
                    if ($this->fields[$key]['required'] == true) {
                        send(400, ['fields' => [$key]]);
                    } else {
                        $formattedData[$key] = null;
                    }
                }
            }
        }

        return $formattedData;
    }

    private function validUser($username)
    {
        $this->db->where('usuario', $username);
        $total = $this->db->count_all_results('usuarios');
        if ($total > 0) {
            send(400, ['fields' => [
                ['field' => 'usuario', 'message' => 'Nome de usuário não disponível!']
            ]]);
        }
    }

    public function save($id = false)
    {
        $data = getContents();
        $data = $this->formatData($data);
        
        if (validarId($id)) {
            $this->db->set($data);
            $this->db->where('id', $id);
            return $this->db->update('usuarios');
        } else {
            $this->validUser($data['usuario']);
            $this->db->set($data);
            return $this->db->insert('usuarios', $data);
        }
        return false;
    }

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
