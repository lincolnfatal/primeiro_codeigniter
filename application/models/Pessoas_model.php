<?php

class Pessoas_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function inserir($data) {
        return $this->db->insert('pessoas', $data);
    }

    function listar() {
        $query = $this->db->get('pessoas');
        return $query->result();
    }

    function editar($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('pessoas');
        return $query->result();
    }

    function atualizar($data) {
        $this->db->where('id', $data['id']);
        $this->db->set($data);
        return $this->db->update('pessoas');
    }

    function deletar($id) {
        $this->db->where('id', $id);
        return $this->db->delete('pessoas');
    }

}

?>