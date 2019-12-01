<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
header("Content-type: text/html; charset=utf-8");
class MY_Controller_Site extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->siteLoggedIn();
	}
	protected function siteLoggedIn(){
		/* Recupera da sessão se o usuário está logado */
		$is_logged = $this->session->userdata('is_logged');
		
		/* Recupera do navegador se o usuário possui o cookie setado */
		$stay_logged_in = $this->input->cookie('stay_logged_in');
		
		$this->session->unset_userdata('last_url');
		
		/* Insere na sessão a URL que o usuário tentou acessar */
		$last_url = $this->session->userdata('last_url');
		if(!$last_url){
			$last_url = current_url();
			$this->session->set_userdata('last_url', $last_url);
		}
		
		/* Se o usuário não estiver logado ou não marcou o permanecer logado redireciona para o login */
		if((!isset($is_logged) || $is_logged != true) && $stay_logged_in!=true){
			redirect('login');
		}
		else{
			/* Carregamento das models que serão utilizadas */
			$this->load->model('usuariomodel');
			
			/* Verifica o email criptografado do usuário */
			$result = $this->usuariomodel->verifyEmailMD5($this->session->userdata('user'));
									
			/* Insere a informação na sessão */
			$this->session->set_userdata('is_logged', true);
		}
	}
	public function generateSlug($string){
		/* Remove os caracteres especiais */
		$slug = convert_accented_characters($string);
		$slug = url_title($slug, 'dash', true);
		return $slug;
	}

	public function getPost($item){		
		return trim($this->input->post($item));
	}

	public function imageUploadOptional($dir, $dir_profile, $field, $new_name){
		/* Carregamento da Library */
		$this->load->library('upload');
		
		/* Definições das configurações do upload */
		$config['upload_path'] = $dir;
		$config['overwrite'] = FALSE;
		$config['encrypt_name'] = TRUE;
		$config['allowed_types'] = 'jpg|jpeg|gif|png';
		$this->upload->initialize($config);
		
		/* Realiza o upload e verifica se ocorreu algum erro */	
		if(!$this->upload->do_upload($field)){
			if(empty($_FILE[$field]['name'])){
				$error = $this->upload->display_errors();
				
				$return['status'] = 'empty';
				$return['info'] = $error;
			}
			else if(!empty($_FILE[$campo]['name'])){
				$error = $this->upload->display_errors();

				$return['status'] = 'error';
				$return['info'] = $return;
			}
		}
		
		else{
			$file_info = $this->upload->data();
			$new_name .= '-'.date('Y-m-d_H-i-s').$file_info['file_ext'];			
			rename($dir.$file_info['file_name'], $dir_profile.$new_name);
	
			$return['status'] = 'success';
			$return['info'] = $new_name;
		}
		
		return $return;
	}
}
