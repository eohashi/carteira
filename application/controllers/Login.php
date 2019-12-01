<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller{
	public function index(){
		/* Customs JS */
		$data['src'] = array(
			'<script src="'.base_url().'assets/theme/js/login.js" type="text/javascript"></script>',
			'<script src="'.base_url().'assets/js/all.js"></script>',
			'<script src="'.base_url().'assets/js/login.js"></script>'
		);
		/* Customs CSS */
		$data['css'] = array(
			'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
		);

		/* Carregamento da View + Template */
		$data['main_content'] = 'login/form';
		$this->load->view('include/template', $data);
	}

	public function validateLogin(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		
		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('login') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Recebe os dados do formulário */
			$info = array(
				'no_email' => trim($this->input->post('no_email')),
				'no_senha' => md5(trim($this->input->post('no_senha')))
			);
			/* Verifica se a opção de permanecer logado está selecionada */
			$stay_logged_in = trim($this->input->post('stay_logged_in'));
			
			/* Valida se o nome e a senha correspondem ao registro no banco de dados */
			$result = $this->usuariomodel->verifyLogin($info);
			
			/* Se houver o registro com nome e senha informados */
			if($result){
				/* Armazena os dados na sessão */
				$user = md5($result->no_email);
				$this->session->set_userdata('user', $user);
				$this->session->set_userdata('is_logged', true);
								
				/* Se o usuário escolher manter-se conectado */
				if($stay_logged_in == 'on'){
					$cookie = array(
							'name'   => 'stay_logged_in',
							'value'  => true,
							'expire' => $this->config->item('cookie_expires'),
							'prefix' =>	$this->config->item('cookie_prefix')
					);
					/* Seta o cookie */
					$this->input->set_cookie($cookie);
				}
				
				/* Recebe a última URL "acessada" */
				#$last_url = $this->session->userdata('last_url');
				$last_url = base_url().'home';
				/* Zera a 'última URL' */
				$this->session->unset_userdata('last_url');
				
				/* Se não possuir uma 'ultima URL' válida, redireciona para Home */
				if(!$last_url){
					if($result->in_primeiro_acesso)
						$last_url = base_url().'first_access';
					else
						$last_url = base_url().'home';
				}
				/* Se for o primeiro acesso */
				else{
					if($result->in_primeiro_acesso){
						$last_url = base_url().'first_access';
					}
				}

				/* Seta a mensagem de retorno */
				$retorno['status'] = 'success';
				$retorno['box'] = $this->config->item('div_success');
				$retorno['message'] = 'Redirecionando...';
				$retorno['page'] = $last_url;
				$retorno['dataLayer'] = array(
					'success' => true,
					'info' => array(
						'event' => 'login',
						'status' => 'success',
						'message' => $retorno['message']
					)
				);
			}
			/* Login ou senha errado(a) */
			else{
				/* Seta a mensagem de retorno */
				$retorno['status'] = 'error';
				$retorno['box'] = $this->config->item('div_error');
				$retorno['page'] = '';
				$retorno['message'] = $this->config->item('message_login_error');
				$retorno['dataLayer'] = array(
					'success' => false,
					'info' => array(
						'event' => 'login',
						'status' => 'error',
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

	public function logout(){
		/* Apaga o cookie */
		delete_cookie($this->config->item('cookie_prefix').'stay_logged_in');
		/* Apaga os dados da sessão */
		$this->session->unset_userdata('user');
		$this->session->unset_userdata('is_logged');
		
		/* Redireciona para a página de Login */
		redirect('login');
	}

	function newPassword(){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');
		
		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('new_password') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['page'] = '';
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Recebe os dados do formulário */
			$info = array('no_email' => trim($this->input->post('no_email_new_password')));
			
			/* Valida se o registro existe no banco de dados */
			$result = $this->usuariomodel->verifyEmail($info['no_email']);
			
			/* Se houver o registro com nome e senha informados */
			if($result){
				/* Gera uma nova senha para o usuário e atualiza o registro no banco de dados */
				$nova_senha = random_string('alnum', 10);
				$res = $this->usuariomodel->alterar($result->cd_usuario, array('no_senha' => md5($nova_senha)));
				/* Se não ocorrer nenhum erro durante a atualização do registro */
				if($res['status']=='ok'){
					/* Realiza o disparo de e-mail com a senha */
					$mail = $this->sendMailNewPass($result->no_email, $nova_senha);

					/* Seta a mensagem de retorno */
					$retorno['status'] = 'success';
					$retorno['box'] = $this->config->item('div_success');
					$retorno['message'] = 'A nova senha foi enviada para o seu e-mail.';
					$retorno['page'] = base_url().'login';	
				}
				/* Se ocorrer algum erro durante a atualização do registro */
				else{
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['box'] = $this->config->item('div_error');
					$retorno['message'] = $this->config->item('message_db_error');
					$retorno['page'] = '';	
				}				
			}
			/* E-mail não encontrado */
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
	
	function sendMailNewPass($email, $nova_senha){
		/* Carregamento das libraries que serão utilizadas */
		$this->load->library('email');
		$this->load->library('parser');

		/* Carregamento do arquivo de configuração contendo os dados da conta de e-mail */
		$this->load->config('email');

		/* Define o e-mail e o nome do remetente do e-mail */
		$this->email->from($this->config->item('email_sender'), $this->config->item('email_sender_name'));
		/* Define o endereço de e-mail que irá receber a nova senha */
		$this->email->to($email);
		
		$year = date("Y");
		
		/* Define as informações que aparecerão no e-mail */
		$info_nova_senha = array(
			'texto_nova_senha' => 'Sua nova senha é:',
			'nova_senha' => $nova_senha,
			'base_url' => base_url(),
			'ano' => $year
		);
		
		/* Define o assunto do e-mail */
		$this->email->subject($this->config->item('email_pass_recover'));
		
		/* Define o template e o texto do corpo do e-mail */
		$this->email->message($this->parser->parse('_mail/nova-senha.html', $info_nova_senha,true));

		/* Envia o email */
		$this->email->set_newline("\r\n");
		$this->email->set_wordwrap(TRUE);
		$this->email->send();
	}
}
