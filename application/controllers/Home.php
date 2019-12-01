<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Controller_Site.php');
class Home extends MY_Controller_Site{
	public function index(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('usuariotransacaomodel');

		/* Recupera todos os resgates e transações do banco de dados. */
		$data['resgates'] = $this->usuariotransacaomodel->getTransaction($this->config->item('transaction_resgate'));
		$data['transacao'] = $this->usuariotransacaomodel->getTransaction($this->config->item('transaction_transfer'));
		
		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Verifica o email criptografado do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);

		$data['aniversariantes'] = $this->usuariomodel->getAniversariantes();

		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);
		
		/* Carregamento da View + Template */
		$data['main_content'] = 'home/home';
		$this->load->view('include/template', $data);
	}

	public function error($error = ''){
		/* Se não for passado nenhum erro como parâmetro o usuário é direcionado à Home */
		if($error == '')
			redirect('home');
		
		/* Retorna um dos templates existentes de forma randômica */
		$content = $this->generateTemplate();

		/* Se o usuário não tiver acesso ao item */
		if($error == 'no_access')
			$data['texto'] = $this->config->item('message_item_no_access');
		
		/* Se o item não for encontrado */
		else if($error == 'not_found')
			$data['texto'] = $this->config->item('message_item_not_found');
		
		/* Se o usuário tentar transferir para si mesmo */
		else if($error == 'self_transfer')
			$data['texto'] = $this->config->item('message_item_own');
		
		/* Se nenhum dos erros acima, o usuário recebe a mensagem abaixo na tela */
		else
			$data['texto'] = 'Ocorreu um erro. <br>Entre em contato com o <a href="mailto:felipe.lara@i-cherry.com.br">Mikos</a>, <a href="mailto:matheus.vaz@i-cherry.com.br">Vaz</a> ou <a href="mailto:eduardo.ohashi@i-cherry.com.br">Ohashi</a>.';

		/* Carregamento da View + Template */
		$data['main_content'] = 'general/'.$content;
		$this->load->view('include/template', $data);
	}

	function generateTemplate(){
		$template = array(
			'template1',
			'template2',
			'template3',
			'template4',
			'template5',
			'template6'
		);
		/* Retorna um dos templates existentes de forma randômica */
		return $template[array_rand($template, 1)];
	}
}