<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Controller_Site.php');
class User extends MY_Controller_Site{
	public function index(){
		redirect('user/all');
	}
	public function all(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);
		
		/* Se o usuário for colaborador não pode acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_colaborador'))
			redirect('home/error/no_access');

		// Retorna todos os usuários
		$data['usuarios'] = $this->usuariomodel->getUsuarios();
		
		/* Custom JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/js/user.js"></script>'
		);
		/* Custom CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'user/all';
		$this->load->view('include/template', $data);
	}
	
	public function create(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('areamodel');
		$this->load->model('celulamodel');
		$this->load->model('tipousuariomodel');
		$this->load->model('unidademodel');
		$this->load->model('statusmodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);
		
		/* Carrega todas as áreas */
		$data['areas'] = $this->areamodel->getAreaOptions();
		/* Carrega todas as células */
		$data['celulas'] = $this->celulamodel->getCelulaOptions();
		/* Carrega todas as unidades */
		$data['unidades'] = $this->unidademodel->getUnidadeOptions();
		/* Carrega todos os tipos de usuarios */
		$data['tipos'] = $this->tipousuariomodel->getTiposOptions();
		/* Carrega todos os status */
		$data['status'] = $this->statusmodel->getStatusOptions();
		
		/* Se o usuário for colaborador não pode acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_colaborador'))
			redirect('home/error/no_access');
		
		/* Custom JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/theme/js/bootstrap-datepicker.js"></script>',
			'<script src="'.base_url().'assets/js/user.js"></script>'
		);
		/* Custom CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'user/form';
		$this->load->view('include/template', $data);
	}

	public function view($no_email_md5_colaborador = ''){
		/* Se não for passado nenhum parâmetro redireciona para a home */
		if($no_email_md5_colaborador=='')
			redirect('user/all');
		
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');		
		$this->load->model('areamodel');
		$this->load->model('celulamodel');
		$this->load->model('unidademodel');
		$this->load->model('tipousuariomodel');
		$this->load->model('statusmodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);

		$usuario = $this->usuariomodel->verifyEmailMD5($user);

		/* Retorna os dados do colaborador que será carregado na tela */
		$data['colaborador'] = $this->usuariomodel->verifyEmailMD5($no_email_md5_colaborador,'editar');

		/* Custom JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/theme/js/bootstrap-datepicker.js"></script>',
			'<script src="'.base_url().'assets/js/user.js"></script>'
		);
		/* Custom CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);
		/* Se o usuário for colaborador não pode acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_colaborador'))
			redirect('home/error/no_access');

		/* Se a busca retornou um resultado */
		if($data['usuario'] && $data['colaborador']){			
			/* Carrega todas as áreas */
			$data['areas'] = $this->areamodel->getAreaOptionsAdmin();
			/* Carrega todas as células */
			$data['celulas'] = $this->celulamodel->getCelulaOptionsAdmin();
			/* Carrega todas as unidades */
			$data['unidades'] = $this->unidademodel->getUnidadeOptions();
			/* Carrega todos os tipos de usuarios */
			$data['tipos'] = $this->tipousuariomodel->getTiposOptions();
			/* Carrega todos os status */
			$data['status'] = $this->statusmodel->getStatusOptions();

			/* Carregamento da View + Template */
			$data['main_content'] = 'user/view';
			$this->load->view('include/template', $data);
		}
		/* Caso o item não seja encontrado */
		else{
			redirect('home/error/not_found');
		}
	}
	
	public function confirmDelete(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário que fará a transferência */
		$usuario = $this->usuariomodel->verifyEmailMD5($user);
		
		if($this->form_validation->run('delete_user') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		} else{
			/* Recupera os dados do post */
			$cd_usuario = $this->getPost('cd_usuario');
			$no_senha = md5($this->getPost('no_senha'));
			/* Se o usuário existir */
			if($usuario){
				/* Verifica se a senha informada é a mesma cadastrada no banco de dados */
				if($usuario->no_senha == $no_senha){
					/* Seta o status como excluído e atualiza o registro no banco de dados */
					$this->usuariomodel->alterar($cd_usuario, array('cd_status'=> $this->config->item('deleted')));

					/* Seta a mensagem de retorno */
					$retorno['status'] = 'success';
					$retorno['page'] = current_url();
					$retorno['message'] = 'Usuário deletado com sucesso.';
					$retorno['dataLayer'] = array(
						'success' => true,
							'info' => array(
								'event' => 'deletarUsuario',
								'status' => 'success',
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
					);
						
				}
				/* Se a senha informada é diferente da cadastrada no banco de dados */
				else{
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['page'] = '';
					$retorno['message'] = 'Não foi possível autenticar o seu usuário com a senha fornecida.';
					$retorno['dataLayer'] = array(
						'success' => false,
							'info' => array(
								'event' => 'deletarUsuario',
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

	public function createUser(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel'); 

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');

		/* Retorna os dados do usuário que fará a transferência */
		$usuario = $this->usuariomodel->verifyEmailMD5($user);

		if($this->form_validation->run('create_profile') == FALSE){
			/* Recupera a mensagem de erro */
			$mensagem = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $mensagem;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		} else{

			$tipo = $this->getPost('cd_tipo_usuario');
			$email = $this->getPost('no_email');
			$nr_saldo = 20;
			if($tipo == $this->config->item('usuario_diretoria')
			|| $tipo == $this->config->item('usuario_misfits')
			|| $tipo == $this->config->item('usuario_gestor')){
				$nr_saldo = 1000;
			}
			$info = array(
				'no_usuario'	=>	$this->getPost('no_usuario'),
				'no_email'	=>	$email,
				'no_email_md5'	=>	md5($email),
				'ds_descricao'	=>	$this->getPost('ds_descricao'),
				'cd_area'	=>	$this->getPost('cd_area'),
				'cd_celula'	=>	$this->getPost('cd_celula'),
				'cd_unidade'	=>	$this->getPost('cd_unidade'),
				'cd_tipo_usuario'	=>	$tipo,
				'cd_status' => $this->getPost('cd_status'),
				'nr_saldo' => $nr_saldo,
				'no_senha' => md5('12345')
			);

			if($this->input->post('dt_inicio') != ''){
				$dt_inicio = str_replace('/', '-', trim($this->input->post('dt_inicio')));
        			$dt_inicio = date('Y-m-d',strtotime($dt_inicio));
        			$info['dt_inicio'] = $dt_inicio;
			}
				
			if($this->input->post('dt_nasc') != ''){
	       			$dt_nasc = str_replace('/', '-', trim($this->input->post('dt_nasc')));
       				$dt_nasc = date('Y-m-d',strtotime($dt_nasc));
       				$info['dt_nasc'] = $dt_nasc;
			}

			$emailValido = $this->usuariomodel->verifyEmailMD5(md5($info['no_email']));

			if(!$emailValido){

				$result = $this->usuariomodel->inserir($info);

				if($result['status']=='ok'){

					/* Recupera a mensagem de erro */
					$retorno['status'] = 'success';
					$retorno['message'] = $this->config->item('message_success_insert');
					$retorno['page'] = base_url().'user/all';
					$retorno['box'] = $this->config->item('div_success');
					$retorno['dataLayer'] = array(
						'error' => true,
							'info' => array(
								'event' => 'novoUsuario',
								'status' => 'success',
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
					);
				} 
				else{

					/* Recupera a mensagem de erro */
					$retorno['status'] = 'error';
					$retorno['message'] = $this->config->item('message_db_error');
					$retorno['box'] = $this->config->item('div_error');
					$retorno['dataLayer'] = array(
						'error' => false,
							'info' => array(
								'event' => 'novoUsuario',
								'status' => 'error',
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
						);
				}
			}
			else{

				/* Recupera a mensagem de erro */
				$retorno['status'] = 'error';
				$retorno['message'] = $this->config->item('email_registered');
				$retorno['box'] = $this->config->item('div_error');
				$retorno['dataLayer'] = array(
					'error' => false,
						'info' => array(
							'event' => 'novoUsuario',
							'status' => 'error',
							'id' => $usuario->cd_usuario,
							'message' => $retorno['message']
						)
					);
			}
			
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($retorno));
	}

	public function kavsForAll(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('depositomodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário que fará a transferência */
		$usuario = $this->usuariomodel->verifyEmailMD5($user);
		
		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('kavs_all') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
			$retorno['dataLayer'] = array(
					'error' => true,
					'info' => array(
						'event' => 'kavsParaTodos',
						'status' => 'error',
						'valor' => $nr_valor,
						'motivo' => $ds_motivo,
						'id' => $usuario->cd_usuario,
						'message' => $retorno['message']
					)
			);
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Recuperaos os dados passados por post */
			$no_senha = md5($this->getPost('no_senha'));
			$nr_valor = str_replace('.','',$this->getPost('nr_valor'));
			$ds_motivo = $this->getPost('ds_motivo');
			
			/* Caso o usuário exista */
			if($usuario){
				/* Verifica se a senha informada é a mesma cadastrada no banco de dados */
				if($usuario->no_senha == $no_senha){
					/* Retorna a quantidade de Kavinsks dos usuários */
					$usuarios = $this->usuariomodel->getKavs();
					$array = array();
					/* Atualiza o saldo de cada usuário */
					foreach($usuarios as $key => $value) {
						$array['nr_saldo'] = $value->nr_saldo + $nr_valor;
						$this->usuariomodel->alterar($value->cd_usuario,$array);

						$dep['cd_payer'] = $usuario->cd_usuario;
						$dep['cd_receiver'] = $value->cd_usuario;
						$dep['nr_valor_deposito'] = $nr_valor;
						$dep['ds_motivo'] = $ds_motivo;
						$this->depositomodel->inserir($dep);
					}
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'success';
					$retorno['page'] = current_url();
					$retorno['message'] = 'Valor creditado com sucesso.';
					$retorno['dataLayer'] = array(
						'success' => true,
							'info' => array(
								'event' => 'kavsParaTodos',
								'status' => 'success',
								'valor' => $nr_valor,
								'motivo' => $ds_motivo,
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
					);
						
				}
				/* Caso a senha informada seja diferente da do banco de dados */
				else{
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['page'] = '';
					$retorno['message'] = 'Não foi possível autenticar o seu usuário com a senha fornecida.';
					$retorno['dataLayer'] = array(
						'success' => false,
							'info' => array(
								'event' => 'kavsParaTodos',
								'status' => 'error',
								'valor' => $nr_valor,
								'motivo' => $ds_motivo,
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

	public function updateProfile(){
		/* Carregamento das models que serão utilizados */
		$this->load->model('usuariomodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');

		/* Retorna os dados do usuário que fará a transferência */
		$usuario = $this->usuariomodel->verifyEmailMD5($user);
		
		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('update_profile_admin') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		} else{
			$cd_usuario = $this->getPost('cd_usuario');

			$info = array(
				'no_usuario'	=>	$this->getPost('no_usuario'),
				'cd_status' => $this->getPost('cd_status'),
				'cd_area'	=>	$this->getPost('cd_area'),
				'cd_celula'	=>	$this->getPost('cd_celula'),
				'cd_unidade'	=>	$this->getPost('cd_unidade'),
				'cd_tipo_usuario'	=>	$this->getPost('cd_tipo_usuario'),
			);

			if($this->input->post('dt_inicio') != ''){
				$dt_inicio = str_replace('/', '-', trim($this->input->post('dt_inicio')));
    			$dt_inicio = date('Y-m-d',strtotime($dt_inicio));
    			$info['dt_inicio'] = $dt_inicio;
			}
			
			if($this->input->post('dt_nasc') != ''){
    			$dt_nasc = str_replace('/', '-', trim($this->input->post('dt_nasc')));
    			$dt_nasc = date('Y-m-d',strtotime($dt_nasc));
    			$info['dt_nasc'] = $dt_nasc;
			}

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
					}
				} else{
					$verify = false;
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['box'] = $this->config->item('div_error');
					$retorno['message'] = $this->config->item('message_pass_matches');
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
							'success' => true,
								'info' => array(
									'event' => 'editarUsuario',
									'status' => 'success',
									'id' => $usuario->cd_usuario,
									'message' => $retorno['message']
								)
						);
					} else{
							/* Recupera a mensagem de erro */
							$retorno['status'] = 'error';
							$retorno['message'] = $this->config->item('message_db_error');
							$retorno['box'] = $this->config->item('div_error');
							$retorno['dataLayer'] = array(
								'success' => false,
								'info' => array(
									'event' => 'editarUsuario',
									'status' => 'success',
									'id' => $usuario->cd_usuario,
									'message' => $retorno['message']
								)
							);
					   }
				} else{
					/* Recupera a mensagem de erro */
					$retorno['status'] = 'error';
					$retorno['message'] = $file['info'];
					$retorno['box'] = $this->config->item('div_error');
					$retorno['dataLayer'] = array(
					'success' => false,
						'info' => array(
							'event' => 'editarUsuario',
							'status' => 'error',
							'id' => $usuario->cd_usuario,
							'message' => $retorno['message']
						)
					);
				}
			}			
		}

		$this->output
	    ->set_content_type('application/json')
	    ->set_output(json_encode($retorno));
	}

	public function depositoUser(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('depositomodel');


		$nr_valor = str_replace('.','',$this->getPost('nr_valor'));
		$ds_motivo = $this->getPost('ds_motivo');
		$nr_saldo  = $this->getPost('nr_saldo');
		$receiver_cd_usuario = $this->getPost('cd_usuario');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');

		/* Retorna os dados do usuário que fará a transferência */
		$usuario = $this->usuariomodel->verifyEmailMD5($user);

		if($this->form_validation->run('deposito_user') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		} else{
			if($usuario){
				$usuarios = $this->usuariomodel->getKavs();
				
				
				$array = array(
					'nr_saldo'=> $nr_saldo + $nr_valor 
				);

				$this->usuariomodel->alterar($receiver_cd_usuario,$array);

				/** Incluir na tabela de deposito */

				$dep['cd_payer'] = $usuario->cd_usuario;
				$dep['cd_receiver'] = $receiver_cd_usuario;
				$dep['nr_valor_deposito'] = $nr_valor;
				$dep['ds_motivo'] = $ds_motivo;
				$this->depositomodel->inserir($dep);

				/* Seta a mensagem de retorno */
				$retorno['status'] = 'success';
				$retorno['page'] = current_url();
				$retorno['message'] = 'Valor creditado com sucesso.';
				$retorno['box'] = $this->config->item('div_success');
				$retorno['dataLayer'] = array(
					'success' => true,
					'info' => array(
						'event' => 'adicionarKavs',
						'status' => 'success',
						'valor' => $nr_valor,
						'motivo' => $ds_motivo,
						'id' => $usuario->cd_usuario,
						'message' => $retorno['message']
					)
				);
			}		
		}

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($retorno));
	}
}
