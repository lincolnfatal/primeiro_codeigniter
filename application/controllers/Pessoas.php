<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Pessoas extends CI_Controller {
 
    function __construct() {
        parent::__construct();  
        /* Carrega o modelo */
        $this->load->model('Pessoas_model', 'model', TRUE);
    }
 
    function index() 
    {
        
       
        $this->load->helper('form');
        $data['titulo'] = "CRUD com CodeIgniter | Cadastro de Pessoas";
        $data['pessoas'] = $this->model->listar();
        $this->load->view('pessoas.php', $data);
                
    }
    
    function inserir() {
 
	/* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
	$this->load->library('form_validation');
 
	/* Define as tags onde a mensagem de erro será exibida na página */
	$this->form_validation->set_error_delimiters('<span>', '</span>');
 
	/* Define as regras para validação */
	$this->form_validation->set_rules('nome', 'Nome', 'required|max_length[10]');
	$this->form_validation->set_rules('email', 'E-mail', 'trim|required|valid_email|max_length[100]');
 
	/* Executa a validação e caso houver erro chama a função index do controlador */
	if ($this->form_validation->run() === FALSE) {
		$this->index();
	/* Senão, caso sucesso: */	
	} else {
		/* Recebe os dados do formulário (visão) */
		$data['nome'] = $this->input->post('nome');
		$data['email'] = $this->input->post('email');
 
 		
		/* Chama a função inserir do modelo */
		if ($this->model->inserir($data)) {
			redirect('pessoas');
		} else {
			log_message('error', 'Erro ao inserir a pessoa.');
		}
	}
}
    
}
?>