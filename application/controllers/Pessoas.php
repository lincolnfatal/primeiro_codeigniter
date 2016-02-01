<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pessoas extends CI_Controller {

    function __construct() {
        parent::__construct();
        /* Carrega o modelo */
        $this->load->model('Pessoas_model', 'model', TRUE);
    }

    function index() {


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

    function editar($id) {

        /* Aqui vamos definir o título da página de edição */
        $data['titulo'] = "CRUD com CodeIgniter | Editar Pessoa";

        /* Busca os dados da pessoa que será editada */
        $data['dados_pessoa'] = $this->model->editar($id);

        /* Carrega a página de edição com os dados da pessoa */
        $this->load->view('pessoas_edit', $data);
    }

    function atualizar() {

        /* Carrega a biblioteca do CodeIgniter responsável pela validação dos formulários */
        $this->load->library('form_validation');

        /* Define as tags onde a mensagem de erro será exibida na página */
        $this->form_validation->set_error_delimiters('<span>', '</span>');

        /* Aqui estou definindo as regras de validação do formulário, assim como 
          na função inserir do controlador, porém estou mudando a forma de escrita */
        $validations = array(
            array(
                'field' => 'nome',
                'label' => 'Nome',
                'rules' => 'trim|required|max_length[40]'
            ),
            array(
                'field' => 'email',
                'label' => 'E-mail',
                'rules' => 'trim|required|valid_email|max_length[100]'
            )
        );
        $this->form_validation->set_rules($validations);

        /* Executa a validação e caso houver erro chama a função editar do controlador novamente */
        if ($this->form_validation->run() === FALSE) {
            $this->editar($this->input->post('id'));
        } else {
            /* Senão obtém os dados do formulário */
            $data['id'] = $this->input->post('id');
            $data['nome'] = ucwords($this->input->post('nome'));
            $data['email'] = strtolower($this->input->post('email'));

            /* Executa a função atualizar do modelo passando como parâmetro os dados obtidos do formulário */
            if ($this->model->atualizar($data)) {
                redirect('pessoas');
            } else {
                log_message('error', 'Erro ao atualizar a pessoa.');
            }
        }
    }

    function deletar($id) {

        /* Executa a função deletar do modelo passando como parâmetro o id da pessoa */
        if ($this->model->deletar($id)) {
            redirect('pessoas');
        } else {
            log_message('error', 'Erro ao deletar a pessoa.');
        }
    }

}

?>