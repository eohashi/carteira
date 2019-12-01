<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Controller_Site.php');
class Profile extends MY_Controller_Site{
	public function my($no_email_md5 = ''){
		/* Se não for passado nenhum parâmetro redireciona para a home */
		if($no_email_md5=='')
			redirect('home');
		
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		
		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);
		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário */
		$usuario = $this->usuariomodel->verifyEmailMD5($no_email_md5);
		$usuario->dt_inicio = str_replace('-', '/', $usuario->dt_inicio); 
        $usuario->dt_inicio  = date('d/m/Y',strtotime($usuario->dt_inicio));

        $usuario->dt_nasc = str_replace('-', '/', $usuario->dt_nasc); 
        $usuario->dt_nasc  = date('d/m/Y',strtotime($usuario->dt_nasc));

		/* Se a busca retornou um resultado */
		if($usuario){
			/* Se o e-mail criptografado do banco for igual ao da sessão e o da sessão for igual ao parâmetro passado na URL */
			if($usuario->no_email_md5 == $user && $user == $no_email_md5){
				$data['usuario'] = $usuario;

				/* Carregamento das models que serão utilizadas */
				$this->load->model('areamodel');
				$this->load->model('celulamodel');
				$this->load->model('unidademodel');
				
				/* Carrega todas as áreas */
				$data['areas'] = $this->areamodel->getAreaOptions();
				/* Carrega todas as células */
				$data['celulas'] = $this->celulamodel->getCelulaOptions();
				/* Carrega todas as unidades */
				$data['unidades'] = $this->unidademodel->getUnidadeOptions();
				
				/* Customs JS */
				$data['src'] = array(
					'<script src="'.base_url().'assets/js/all.js"></script>',
					'<script src="'.base_url().'assets/js/profile.js"></script>'
				);
				/* Customs CSS */
				$data['css'] = array(
					'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
				);
				
				/* Define qual a view será carregada */
				$content = 'profile/my';
			}
			/* Se o usuário estiver tentando acessar um usuário diferente */
			else{
				redirect('home/error/no_access');
			}
		}
		/* Se o usuário tentar acessar um item inexistente */
		else{
			redirect('home/error/not_found');
		}

		/* Carregamento da View + Template */
		$data['main_content'] = $content;
		$this->load->view('include/template', $data);					
	}

	public function updateProfile(){
		/* Carregamento das models que serão utilizados */
		$this->load->model('usuariomodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário */
		$usuario = $this->usuariomodel->verifyEmailMD5($user);
		
		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('update_profile') == FALSE){
			/* Recupera a mensagem de erro */
			$mensagem = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $mensagem;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Recupera o ID do usuário e monta o array com as informações que serão alteradas */
			$cd_usuario = $this->getPost('cd_usuario');
			$info = array(
				'no_usuario'	=>	$this->getPost('no_usuario'),
				'ds_descricao'	=>	$this->getPost('ds_descricao'),
				'cd_area'	=>	$this->getPost('cd_area'),
				'cd_celula'	=>	$this->getPost('cd_celula'),
				'cd_unidade'	=>	$this->getPost('cd_unidade'),
			);

			$verify = true;

			/* Se o campo de senha estiver preenchido */
			if($this->getPost('no_senha') != ''){
				/* Criptografa a senha */
				$no_senha = md5($this->getPost('no_senha'));
				/* Se o campo de confirmação de senha estiver preenchido */
				if($this->getPost('conf_senha') != ''){
					/* Criptografa a senha */
					$conf_senha = md5($this->getPost('conf_senha'));
					/* Verifica se as duas senhas conferem */
					if($no_senha == $conf_senha){
						$info['no_senha'] = $no_senha;
					} else{
						$verify = false;
						/* Seta a mensagem de retorno */
						$retorno['status'] = 'error';
						$retorno['box'] = $this->config->item('div_error');
						$retorno['message'] = $this->config->item('message_pass_matches');
						$retorno['dataLayer'] = array(
						'success' => false,
							'info' => array(
								'event' => 'editarPerfil',
								'status' => 'error',
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
						);
					}
				} else{
					$verify = false;
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['box'] = $this->config->item('div_error');
					$retorno['message'] = $this->config->item('message_pass_matches');
					$retorno['dataLayer'] = array(
					'success' => false,
						'info' => array(
							'event' => 'editarPerfil',
							'status' => 'error',
							'id' => $usuario->cd_usuario,
							'message' => $retorno['message']
						)
					);
				}
			}

			if($verify){
				/* Realiza o upload */
				$file = $this->imageUploadOptional($this->config->item('dir_upload_tmp'), $this->config->item('dir_upload_profile'), 'foto', $this->generateSlug($info['no_usuario']));
				/* Valida se houve erro no Upload */
				if($file['status'] != 'error'){
					if($file['status'] == 'success'){
						$info['no_foto_usuario'] = $file['info'];
					}
					/* Altera o registro no banco de dados */
					$result = $this->usuariomodel->alterar($cd_usuario, $info);

					if($result['status']=='ok'){
						/* Recupera a mensagem de erro */
						$retorno['status'] = 'success';
						$retorno['message'] = $this->config->item('message_success_update');
						$retorno['box'] = $this->config->item('div_success');
						$retorno['dataLayer'] = array(
						'success' => false,
							'info' => array(
								'event' => 'editarPerfil',
								'status' => 'success',
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
						);
					} else{
						/* Recupera a mensagem de erro */
						$retorno['status'] = 'error';
						$retorno['message'] = $this->config->item('message_db_error');
						$retorno['box'] = $this->config->item('div_success');
						$retorno['dataLayer'] = array(
						'success' => false,
							'info' => array(
								'event' => 'editarPerfil',
								'status' => 'error',
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
						);
					}
				}
				/* Se houver algum erro no upload */
				else{
					/* Recupera a mensagem de erro */
					$retorno['status'] = 'error';
					$retorno['message'] = $file['info'];
					$retorno['box'] = $this->config->item('div_error');
					$retorno['dataLayer'] = array(
					'success' => false,
						'info' => array(
							'event' => 'editarPerfil',
							'status' => 'error',
							'id' => $usuario->cd_usuario,
							'message' => $retorno['message']
						)
					);
				}
			}			
		}

		/* Retorna o JSON */
		$this->output
	    ->set_content_type('application/json')
	    ->set_output(json_encode($retorno));
	}
}