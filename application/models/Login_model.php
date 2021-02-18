<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_model extends CI_Model
{
    public function validar($usuario, $senha)
    {
        if ($usuario && $senha) {
            $this->db->where('usuario', $usuario);
            $this->db->where('senha', $senha);
            $result = $this->db->get('usuarios');
            if ($result->num_rows() > 0) {
                $this->insereInformacoesNaSessao($result->row_array());
                return true;
            }
        }
        return false;
    }

    private function insereInformacoesNaSessao($dados)
    {
        $dados_sessao = array(
            'session_id'=> session_id(),
            'id_usuario'=> $dados['id'],
            'nome'=> $dados['nome'],
            'administrador'=> $dados['administrador'],
        );
        $this->session->set_userdata($dados_sessao);
    }
}
