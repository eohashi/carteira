<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once(APPPATH.'core/MY_Controller_Site.php');
class Transfer extends MY_Controller_Site{
	public function to($no_email_md5 = ''){
		/* Carregamento das models que serão utilizadas */
		$this->load->model('areamodel');
		$this->load->model('celulamodel');
		$this->load->model('unidademodel');
		$this->load->model('usuariomodel');
		
		/* Retorna os dados do usuário que efetuará a transferência */
		$data['usuario'] = $this->usuariomodel->verifyEmailMD5($this->session->userdata('user'));

		/* Se não for passado nenhum parâmetro redireciona para a listagem completa dos perfis */
		if($no_email_md5=='')
			redirect('home');	

		/* Retorna os dados do usuário que receberá a transferência */
		if($no_email_md5 == $this->session->userdata('user')){
			redirect('home/error/self_transfer');
		} else {
			$user_to = $this->usuariomodel->verifyEmailMD5($no_email_md5);

			/* Se a busca retornou um resultado */
			if($user_to){
				$data['user_to'] = $user_to;

				/* Customs JS */
				$data['src'] = array(
					'<script src="'.base_url().'assets/lib/jquery.mask.js"></script>',
					'<script src="'.base_url().'assets/js/all.js"></script>',
					'<script src="'.base_url().'assets/js/transfer.js"></script>'
				);
				/* Customs CSS */
				$data['css'] = array(
					'<link rel="stylesheet" href="'.base_url().'assets/css/all.css">'
				);

				/* Define qual a view será carregada */
				$content = 'transfer/to';
			} else{
				redirect('home/error/not_found');
			}
		}

		/* Carregamento da View + Template */
		$data['main_content'] = $content;
		$this->load->view('include/template', $data);					
	}

	public function confirmTransaction(){		
		/* Carregamento das models que serão utilizadas */
		$this->load->model('usuariomodel');

		/* Executa a validação dos campos requeridos */
		if($this->form_validation->run('transfer') == FALSE){
			/* Recupera a mensagem de erro */
			$message = validation_errors();
			$retorno['status'] = 'error';
			$retorno['message'] = $message;
			$retorno['box'] = $this->config->item('div_error');
			$retorno['dataLayer'] = array(
				'success' => false,
					'info' => array(
						'event' => 'transferir',
						'status' => 'error',
						'valor' => $transfer_value,
						'id' => $usuario->cd_usuario,
						'message' => $retorno['message']
					)
				);
		}
		/* Caso os campos requeridos sejam preenchidos */
		else{
			/* Recupera os dados do post */
			$no_email_md5 = $this->getPost('no_email_md5');
			$no_email = $this->getPost('user_to_no_email');
			$transfer_value = str_replace('.','',$this->getPost('transfer_value'));
			$no_senha = md5($this->getPost('no_senha'));
			$user_to_email_md5 = $this->getPost('user_to_email_md5');
			$ds_motivo = $this->getPost('ds_motivo');

			/* Retorna os dados do usuário que fará a transferência */
			$usuario = $this->usuariomodel->verifyEmailMD5($no_email_md5);
			/* Se o registro for encontrado */
			if($usuario){
				/* Verifica se a senha informada é a mesma cadastrada no banco de dados */
				if($usuario->no_senha == $no_senha){
					if($usuario->nr_saldo < $transfer_value){
						/* Seta a mensagem de retorno */
						$retorno['status'] = 'error';
						$retorno['page'] = '';
						$retorno['message'] = 'Saldo insuficiente.';
						$retorno['dataLayer'] = array(
						'success' => false,
							'info' => array(
								'event' => 'transfer',
								'status' => 'error',
								'valor' => $transfer_value,
								'id' => $usuario->cd_usuario,
								'message' => $retorno['message']
							)
						);
					} else{
						/* Retorna os dados do usuário que receberá a transferência */
						$user_to = $this->usuariomodel->verifyEmailMD5($user_to_email_md5);
						/* Valida se o registro existe no banco de dados */
						$result = $this->usuariomodel->verifyEmail($no_email);
						/* Se o usuário existir */
						if($result){
								/* Envia um e-mail para o usuário */
								$mail = $this->sendMailNewPass($no_email, $transfer_value,$usuario->no_usuario,$ds_motivo);
								
								/* Atualiza o saldo dos usuários */
								$novo_saldo = $usuario->nr_saldo - $transfer_value;
								$this->usuariomodel->alterar($usuario->cd_usuario, array('nr_saldo' => $novo_saldo));
								$user_to_novo_saldo = $user_to->nr_saldo + $transfer_value;
								$this->usuariomodel->alterar($user_to->cd_usuario, array('nr_saldo' => $user_to_novo_saldo));

								/* Carregamento das models que serão utilizadas */
								$this->load->model('usuariotransacaomodel');

								/* Monta o array com as informações das transferências */
								$arr = array(
									'cd_usuario'	=>	$usuario->cd_usuario,
									'cd_recebedor'	=>	$user_to->cd_usuario,
									'cd_tipo_transacao'	=>	$this->config->item('transaction_transfer'),
									'ds_motivo' => $ds_motivo,
									'nr_valor'	=>	$transfer_value
								);
								/* Insere os dados na tabela de transferências */
								$result = $this->usuariotransacaomodel->inserir($arr);

								/* Seta a mensagem de retorno */
								$retorno['status'] = 'success';
								$retorno['page'] = base_url();
								$retorno['message'] = 'Transferência realizada com sucesso.';
								$retorno['dataLayer'] = array(
								'success' => true,
									'info' => array(
										'event' => 'transfer',
										'status' => 'success',
										'valor' => $transfer_value,
										'id' => $usuario->cd_usuario,
										'message' => $retorno['message']
									)
								);
						}
						/* Se o usuário não existir */
						else{
							/* Seta a mensagem de retorno */
							$retorno['status'] = 'error';
							$retorno['box'] = $this->config->item('div_success');
							$retorno['message'] = $this->config->item('message_db_error');
							$retorno['page'] = '';
							$retorno['dataLayer'] = array(
							'success' => true,
								'info' => array(
									'event' => 'transfer',
									'status' => 'error',
									'valor' => $transfer_value,
									'id' => $usuario->cd_usuario,
									'message' => $retorno['message']
								)
							);
						}	
					
					}
				}
				/* Senha inválida */
				else{
					/* Seta a mensagem de retorno */
					$retorno['status'] = 'error';
					$retorno['page'] = '';
					$retorno['message'] = 'Não foi possível autenticar o seu usuário com a senha fornecida.';
					$retorno['dataLayer'] = array(
					'success' => false,
						'info' => array(
							'event' => 'transfer',
							'status' => 'error',
							'valor' => $transfer_value,
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
	
	function sendMailNewPass($email, $valor,$no_usuario,$ds_motivo){
		/* Carregamento das libraries que serão utilizadas */
		$this->load->library('email');
		$this->load->library('parser');

		/* Define o e-mail e o nome do remetente do e-mail */
		$this->email->from($this->config->item('email_sender'), $this->config->item('email_sender_name'));
		/* Define o endereço de e-mail que irá receber a nova senha */
		$this->email->to($email);
		
		$year = date("Y");
		/* Define as informações que aparecerão no e-mail */
		$info_recebeu = array(
			'texto_recebeu_kavs' => 'Você acaba de receber <b>'.$valor.'CheckPoints</b> de <b>'.$no_usuario.'</b>!',
			'ds_motivo' => 'Motivo: '.$ds_motivo.'.',
			'base_url' => base_url(),
			'ano' => $year
		);
		
		/* Define o assunto do e-mail */
		$this->email->subject($this->config->item('email_transfer'));
		
		/* Define o template e o texto do corpo do e-mail */
		$this->email->message($this->parser->parse('_mail/recebeu-kavs.html', $info_recebeu,true));

		/* Envia o email */
		$this->email->set_newline("\r\n");
		$this->email->set_wordwrap(TRUE);
		$this->email->send();
	}
}
