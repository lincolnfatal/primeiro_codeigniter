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
}

?>