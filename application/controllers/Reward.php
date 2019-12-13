<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Controller_Site.php');
class Reward extends MY_Controller_Site{
	public function index(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('premiomodel');
		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Verifica o email criptografado do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);

		/* Recupera os dados do banco de dados */
		$data['premios'] = $this->premiomodel->getAtivos();
		
		/* Somente usuários do tipo colaboradores podem acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_diretoria') 
		|| $data['usuario']->cd_tipo_usuario == $this->config->item('usuario_misfits')
		|| $data['usuario']->cd_tipo_usuario == $this->config->item('usuario_gestor'))
			redirect('home/error/no_access');
		
		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/js/reward.js"></script>'
		);

		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);
		
		/* Carregamento da View + Template */
		$data['main_content'] = 'reward/all';
		$this->load->view('include/template', $data);
		$retorno['teste'] = 'teste';
	}
	
	public function confirmPrize(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('premiomodel');

		/* Recupera os dados do post */
		$no_email_md5 = $this->getPost('no_email_md5');
		$no_senha = md5($this->getPost('no_senha'));
		$cd_premio = $this->getPost('cd_premio');
		
		/* Retorna os dados do usuário que fará o resgate */
		$usuario = $this->usuariomodel->verifyEmailMD5($no_email_md5);
		$premio = $this->premiomodel->getItem($cd_premio);

		/* Verifica se o usuário existe */
		if($usuario){
			/* Verifica se a senha informada no resgate é a mesma cadastrada no banco de dados */
			if($usuario->no_senha == $no_senha){
				/* Retorna os dados do prêmio que será resgatado */
				if($premio){
					/* Verifica se o usuário possui saldo */
					if($usuario->nr_saldo < $premio->nr_valor){
						/* Seta a mensagem de retorno */
						$retorno['status'] = 'errorSaldo';
						$retorno['page'] = '';
						$retorno['message'] = 'Saldo insuficiente.';
						$retorno['dataLayer'] = array(
							'erro' => false,
							'info' => array(
								'event' => 'resgatarReward',
								'status' => 'error',
								'id' => $usuario->cd_usuario,
								'premio' => $premio->cd_premio,
								'valor' => $premio->nr_valor,
								'message' => $retorno['message']
							)
						);
					}
					/* Se o usuário possuir saldo */
					else{
						$info = array('no_email' => $usuario->no_email);
						/* Envia o e-mail para o usuário */
						$mail_user = $this->sendMailNewPass($usuario->no_email,$usuario->no_usuario,$premio->no_premio, $premio->nr_valor,1);
						/* Envia o e-mail para o admin */
						$mail_admin = $this->sendMailNewPass($usuario->no_email,$usuario->no_usuario,$premio->no_premio, $premio->nr_valor,2);
						
						/* Atualiza o saldo do usuário */
						$novo_saldo = $usuario->nr_saldo - $premio->nr_valor;
						$this->usuariomodel->alterar($usuario->cd_usuario, array('nr_saldo' => $novo_saldo));
	
						/* Carregamento das models que serão utilizadas */
						$this->load->model('usuariotransacaomodel');
	
						/* Insere os dados na tabela de transferências */
						$arr = array(
							'cd_usuario'	=>	$usuario->cd_usuario,
							'cd_tipo_transacao'	=>	$this->config->item('transaction_resgate'),
							'nr_valor'	=>	$premio->nr_valor,
							'cd_premio'	=>	$premio->cd_premio
						);
						/* Insere o registro na tabela de transações */
						$result = $this->usuariotransacaomodel->inserir($arr);
	
						/* Seta a mensagem de retorno */
						$retorno['status'] = 'success';
						$retorno['page'] = current_url();
						$retorno['message'] = 'Resgate realizado com sucesso.';
						$retorno['dataLayer'] = array(
							'success' => true,
							'info' => array(
								'event' => 'resgatarReward',
								'status' => 'success',
								'id' => $usuario->cd_usuario,
								'premio' => $premio->no_premio,
								'valor' => $premio->nr_valor,
								'message' => $retorno['message']
							)
						);
					}
				}
				/* Se o prêmio não for encontrado */
				else{
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['page'] = '';
					$retorno['message'] = $this->config->item('message_item_not_found');
					$retorno['dataLayer'] = array(
						'successo' => false,
						'info' => array(
							'event' => 'resgatarReward',
							'status' => 'error',
							'id' => $usuario->cd_usuario,
							'premio' => $premio->no_premio,
							'valor' => $premio->nr_valor,
							'message' => $retorno['message']
						)
					);
				}				
			}
			/* Se o usuário não for encontrado */
			else{
				/* Seta a mensagem de retorno */
				$retorno['status'] = 'error';
				$retorno['page'] = '';
				$retorno['message'] = 'Não foi possível autenticar o seu usuário com a senha fornecida.';
				$retorno['dataLayer'] = array(
					'success' => false,
					'info' => array(
						'event' => 'resgatarReward',
						'status' => 'erro',
						'id' => $usuario->cd_usuario,
						'premio' => $premio->no_premio,
						'valor' => $premio->nr_valor,
						'message' => $retorno['message']
					)
				);
			}
		}

		/* Retorna o JSON */
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($retorno));
	}
	
	function sendMailNewPass($email,$no_usuario,$no_premio,$nr_valor,$type_email){
		/* Carregamento das libraries que serão utilizadas */
		$this->load->library('email');
		$this->load->library('parser');

		$year = date("Y");

		if($type_email == 1){
			/* Define o e-mail e o nome do remetente do e-mail */
			$this->email->from($this->config->item('email_sender'), $this->config->item('email_sender_name'));
			/* Define o endereço de e-mail que irá receber a nova senha */
			$this->email->to($email);
			
			/* Define as informações que aparecerão no e-mail */
			$info_resgate = array(
				'texto_resgate' => 'Resgate do prêmio <b>'.$no_premio.' ['.$nr_valor.' heckPoints]</b> realizado, parabéns pelo seu esforço!',
				'aguardar' => 'Agora basta aguardar o responsável lhe entregar seu prêmio!',
				'base_url' => base_url(),
				'ano' => $year
			);
			
			/* Define o assunto do e-mail */
			$this->email->subject($this->config->item('email_collect_reward_user'));
			
			/* Define o template e o texto do corpo do e-mail */
			$this->email->message($this->parser->parse('_mail/resgate-reward-user.html', $info_resgate,true));

			/* Envia o email */
			$this->email->set_newline("\r\n");
			$this->email->set_wordwrap(TRUE);
			$this->email->send();
		}
		else{
			/* Define o e-mail e o nome do remetente do e-mail */
			$this->email->from($this->config->item('email_sender'), $this->config->item('email_sender_name'));
			/* Define o endereço de e-mail que irá receber a nova senha */
			$this->email->to($this->config->item('email_admin'));
			
			/* Define as informações que aparecerão no e-mail */
			$info_resgate = array(
				'texto_resgate' => 'Resgate do prêmio <b>'.$no_premio.' ['.$nr_valor.'CheckPoints]</b> solicitado por <b>'.$no_usuario.'</b>.',
				'aguardar' => 'Email solicitante: '.$email.'',
				'base_url' => base_url(),
				'ano' => $year
			);
			
			/* Define o assunto do e-mail */
			$this->email->subject($this->config->item('email_collect_reward_admin'));
			
			/* Define o template e o texto do corpo do e-mail */
			$this->email->message($this->parser->parse('_mail/resgate-reward-admin.html', $info_resgate,true));

			/* Envia o email */
			$this->email->set_newline("\r\n");
			$this->email->set_wordwrap(TRUE);
			$this->email->send();
		}
	}

	public function historic(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');		
		$this->load->model('premiomodel');
		$this->load->model('usuariotransacaomodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Verifica o email criptografado do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);

		/* Recupera os dados do banco de dados e monta o array com os dados para exibição na view */
		$premios = $this->premiomodel->getTodosItens();
		$resgates = array();

		foreach($premios as $key=>$value){
			$resgates[$key]['no_premio'] = $value->no_premio;
			$resgates[$key]['cd_premio'] = $value->cd_premio;
			$resgates[$key]['ds_premio'] = $value->ds_premio;
			$resgates[$key]['no_status'] = $value->no_status;
			$resgates[$key]['nr_valor'] = $value->nr_valor;
			$resgates[$key]['usuarios'] = $this->usuariotransacaomodel->getTransactionByReward($value->cd_premio);
			$resgates[$key]['qtd_resgate'] = count($resgates[$key]['usuarios']);
		}

		$data['resgates'] = $resgates;
		
		/* Se o usuário for colaborador não pode acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_colaborador'))
			redirect('home/error/no_access');
		
		/* Retorna todos os usuários do banco de dados */
		$data['usuarios'] = $this->usuariomodel->getUsuarios();

		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/js/reward.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'reward/historic_reward';
		$this->load->view('include/template', $data);
	}

	public function all(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');		
		$this->load->model('premiomodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Verifica o email criptografado do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);

		/* Se o usuário for colaborador não pode acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_colaborador'))
			redirect('home/error/no_access');
		
		/* Retorna todos os usuários do banco de dados */
		$data['usuarios'] = $this->usuariomodel->getUsuarios();
		$data['premios'] = $this->premiomodel->getTodosItens();
		
		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/js/reward.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'reward/all_admin';
		$this->load->view('include/template', $data);
	}

	public function deleteReward(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('premiomodel');

		/* Recupera os dados do post */
		$cd_premio = $this->getPost('cd_premio');
		$no_senha = md5($this->getPost('no_senha'));
		
		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário que fará a transferência */
		$usuario = $this->usuariomodel->verifyEmailMD5($user);
		
		/* Executa a validação dos campos requeridos */		
		if($this->form_validation->run('delete_user') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Se o usuário existir */
			if($usuario){
				/* Verifica se a senha informada no resgate é a mesma cadastrada no banco de dados */
				if($usuario->no_senha == $no_senha){
					/* Seta o status como excluído e atualiza o registro no banco de dados */
					$this->premiomodel->alterar($cd_premio, array('cd_status'=> $this->config->item('deleted')));

					/* Seta a mensagem de retorno */
					$retorno['status'] = 'success';
					$retorno['page'] = current_url();
					$retorno['message'] = 'Reward deletada com sucesso.';
					$retorno['dataLayer'] = array(
						'success' => true,
						'info' => array(
							'event' => 'deletarReward',
							'status' => 'success',
							'id' => $usuario->cd_usuario,
							'message' => $retorno['message']
						)
					);
						
				} else{
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['page'] = '';
					$retorno['message'] = 'Não foi possível autenticar o seu usuário com a senha fornecida.';
					$retorno['dataLayer'] = array(
						'success' => false,
						'info' => array(
							'event' => 'deletarReward',
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

	public function view($cd_premio = ''){
		/* Se não for passado nenhum parâmetro redireciona para a listagem de todos os prêmios */
		if($cd_premio=='')
			redirect('reward/all');

		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');		
		$this->load->model('premiomodel');
		$this->load->model('statusmodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Retorna os dados do usuário que fará a transferência */

		/* Verifica o email criptografado do usuário */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($user);
		
		$usuario = $this->usuariomodel->verifyEmailMD5($user);

		/* Recupera os dados do banco de dados */
		$data['premio'] = $this->premiomodel->getItem($cd_premio);
		$data['status'] = $this->statusmodel->getStatusOptions();
		
		/* Se o usuário for colaborador não pode acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_colaborador'))
			redirect('home/error/no_access');
		
		/* Monta o array com as categorias dos prêmios */
		$data['categorias'] = array(
			'' => "Selecione",
			$this->config->item('premio_alimentacao') => 'Alimentação',
			$this->config->item('premio_entretenimento') => 'Entretenimento',
			$this->config->item('premio_viagem') => 'Viagem' ,
			$this->config->item('premio_presente') => 'Presente' 
		);
		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/js/reward.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'reward/edit_reward';
		$this->load->view('include/template', $data);
	}

	public function updateReward(){
		/* Carregamento das models que serão utilizados */
		$this->load->model('usuariomodel');
		$this->load->model('premiomodel');
		
		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('edit_reward') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Monta o array com as informações */
			$cd_premio = $this->getPost('cd_premio');
			$info = array(
				'nr_valor'	=>	str_replace('.','',$this->getPost('nr_valor')),
				'ds_premio'	=>	$this->getPost('ds_premio'),
				'cd_categoria'	=>	$this->getPost('cd_categoria'),
				'cd_status'	=>	$this->getPost('cd_status')
			);
			/* Atualiza os registros conforme o array informado */
			$result = $this->premiomodel->alterar($cd_premio,$info);
			/* Caso não ocorra erro durante a atualização do registro no banco de dados */
			if($result['status']=='ok'){
				/* Recupera a mensagem de erro */
				$retorno['status'] = 'success';
				$retorno['message'] = $this->config->item('message_success_update');
				$retorno['page'] = current_url();
				$retorno['box'] = $this->config->item('div_success');
				$retorno['dataLayer'] = array(
					'success' => true,
					'info' => array(
						'event' => 'editarReward',
						'status' => 'success',
						'valor' => $info['nr_valor'],
						'id' => $this->getPost('cd_usuario'),
						'categoria' => $info['cd_categoria'],
						'message' => $retorno['message']
					)
				);
			}
			/* Caso ocorra algum erro durante a atualização do registro no banco de dados */
			else{
				/* Recupera a mensagem de erro */
				$retorno['status'] = 'error';
				$retorno['message'] = $this->config->item('message_db_error');
				$retorno['box'] = $this->config->item('div_error');
				$retorno['dataLayer'] = array(
					'success' => false,
					'info' => array(
						'event' => 'editarReward',
						'status' => 'error',
						'valor' => $info['nr_valor'],
						'id' => $this->getPost('cd_usuario'),
						'categoria' => $info['cd_categoria'],
						'message' => $retorno['message']
					)
				);
			}			
		}

		/* Retorna o JSON */
		$this->output
	    ->set_content_type('application/json')
	    ->set_output(json_encode($retorno));
	}

	public function create(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');		
		$this->load->model('premiomodel');
		$this->load->model('statusmodel');

		/* Recupera os dados do usuário da sessão */
		$user = $this->session->userdata('user');
		/* Verifica o email criptografado do usuário */
		$data['usuario'] =  $this->usuariomodel->verifyEmailMD5($user);

		/* Recupera os dados do banco de dados */
		$data['premios'] = $this->premiomodel->getAtivos();
		$data['status'] = $this->statusmodel->getStatusOptions();
		
		/* Se o usuário for colaborador não pode acessar esta área */
		if($data['usuario']->cd_tipo_usuario == $this->config->item('usuario_colaborador'))
			redirect('home/error/no_access');
		
			/* Monta o array com as categorias dos prêmios */
		$data['categorias'] = array(
			'' => "Selecione",
			$this->config->item('premio_alimentacao') => 'Alimentação',
			$this->config->item('premio_entretenimento') => 'Entretenimento',
			$this->config->item('premio_viagem') => 'Viagem' ,
			$this->config->item('premio_presente') => 'Presente' 
		);
		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
			'<script src="'.base_url().'assets/js/reward.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'reward/create';
		$this->load->view('include/template', $data);
	}

	public function createReward(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		$this->load->model('premiomodel');

		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('create_reward') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Monta o array com as informações */
			$info = array(
				'no_premio'	=>	$this->getPost('no_premio'),
				'nr_valor'	=>	str_replace('.','',$this->getPost('nr_valor')),
				'ds_premio'	=>	$this->getPost('ds_premio'),
				'cd_categoria'	=>	$this->getPost('cd_categoria'),
				'cd_status'	=>	$this->getPost('cd_status')
			);
			/* Insere o registro no banco de dados */
			$result = $this->premiomodel->inserir($info);
			/* Caso não ocorra erro durante a inserção do registro no banco de dados */
			if($result['status']=='ok'){
				/* Recupera a mensagem de erro */
				$retorno['status'] = 'success';
				$retorno['message'] = $this->config->item('message_success_insert');
				$retorno['page'] = current_url();
				$retorno['box'] = $this->config->item('div_success');
				$retorno['dataLayer'] = array(
					'success' => true,
					'info' => array(
						'event' => 'cadastrarReward',
						'status' => 'success',
						'valor' => $info['nr_valor'],
						'id' => $this->getPost('cd_usuario'),
						'message' => $retorno['message']
					)
				);
			}
			/* Caso ocorra algum erro durante a inserção do registro no banco de dados */
			else{
				/* Recupera a mensagem de erro */
				$retorno['status'] = 'error';
				$retorno['message'] = $this->config->item('message_db_error');
				$retorno['box'] = $this->config->item('div_error');
				$retorno['dataLayer'] = array(
					'success' => false,
					'info' => array(
						'event' => 'cadastrarReward',
						'status' => 'error',
						'valor' => $info['nr_valor'],
						'id' =>  $this->getPost('cd_usuario'),
						'message' => $retorno['message']
					)
				);
			}			
		}
		/* Retorna o JSON */
		$this->output
		->set_content_type('application/json')
		->set_output(json_encode($retorno));
	}
}
