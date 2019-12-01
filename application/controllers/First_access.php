<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Controller_Site.php');
class First_access extends MY_Controller_Site{
	public function index(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('areamodel');
		$this->load->model('celulamodel');
		$this->load->model('unidademodel');

		/* Carrega todas as áreas */
		$data['areas'] = $this->areamodel->getAreaOptions();
		/* Carrega todas as células */
		$data['celulas'] = $this->celulamodel->getCelulaOptions();
		/* Carrega todas as unidades */
		$data['unidades'] = $this->unidademodel->getUnidadeOptions();
		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Verifica o email criptografado do usuário */
		$data['usuario'] =  $this->usuariomodel->verifyEmailMD5($user);

		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/js/first_access.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);
		
		/* Carregamento da View + Template */
		$data['main_content'] = 'first-access/form';
		$this->load->view('include/template', $data);
	}

	public function changePassword(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		
		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('first_access') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Recupera os dados do usuário da sessão */
			$user = $this->session->userdata('user');
			/* Verifica o email criptografado do usuário */
			$usuario = $this->usuariomodel->verifyEmailMD5($user);
			
			/* Recupera a senha informada pelo usuário */
			$new = md5(trim($this->input->post('nova_senha')));
			$conf = md5(trim($this->input->post('conf_senha')));
			
			/* Se o usuário existir */
			if($usuario){
				/* Se as senhas digitadas forem iguais */
				if($new == $conf){
					/* Se a nova senha for igual à antiga */
					if($new == $usuario->no_senha){
						$retorno['status'] = 'error';
						$retorno['box'] = $this->config->item('div_error');
						$retorno['message'] = 'A nova senha não pode ser igual à senha antiga.';
						$retorno['page'] = '';
					}
					/* Se a senha for diferente da senha antiga */
					else{
						/* Armazena as informações no array */
						
						$info = array(
							'no_email_md5' => $user,
							'no_senha' => $new,
							'in_primeiro_acesso' => 0,
							'cd_area'	=>	$this->getPost('cd_area'),
							'cd_celula'	=>	$this->getPost('cd_celula')
						);
						/* Executa a alteração de senha no Banco de dados */
						$result = $this->usuariomodel->alterar($usuario->cd_usuario, $info);

						/* Se não ocorrer erro durante o update */
						if($result){
							/* Seta a mensagem de retorno */
							$retorno['status'] = 'success';
							$retorno['box'] = $this->config->item('div_success');
							$retorno['message'] = $this->config->item('notify_success_update');
							$retorno['page'] = base_url().'home';
						}
						else{
							/* Seta a mensagem de retorno */
							$retorno['status'] = 'error';
							$retorno['box'] = $this->config->item('div_error');
							$retorno['message'] = $this->config->item('message_db_error');
							$retorno['page'] = '';
						}
					}
				}
				/* Se as senhas digitadas forem diferentes */
				else{
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['box'] = $this->config->item('div_error');
					$retorno['message'] = $this->config->item('message_pass_matches');
					$retorno['page'] = '';
				}
			}
			/* Se o usuário não existir */
			else{
				/* Seta a mensagem de retorno */
				$retorno['status'] = 'error';
				$retorno['box'] = $this->config->item('div_error');
				$retorno['page'] = '';
				$retorno['message'] = $this->config->item('email_not_registered');
			}
		}

		/* Retorna o JSON */
		$this->output
	    ->set_content_type('application/json')
	    ->set_output(json_encode($retorno));
	}
}