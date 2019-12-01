<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Controller_Site.php');
class Explore extends MY_Controller_Site{	
	public function index(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('celulamodel');
		$this->load->model('usuariomodel');
		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');

		/* Verifica o email criptografado do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($this->session->userdata('user'));

		/* Retorna todos os usuários */
		$data['usuarios'] = $this->usuariomodel->getPerfisAtivos();

		/* Retorna todas as células */
		$data['celulas'] = $this->celulamodel->getAtivos();
		
		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/js/all_profiles.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'explore/all';
		$this->load->view('include/template', $data);
	}
}