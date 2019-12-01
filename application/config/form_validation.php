<?php
	$config = array(			
			'login' => array(
					array('field' => 'no_senha', 'label' => 'Senha', 'rules' => 'trim|required'),
					array('field' => 'no_email', 'label' => 'E-mail', 'rules' => 'trim|required|valid_email')
			),
			'first_access' => array(
				array('field' => 'nova_senha', 'label' => 'Nova Senha', 'rules' => 'trim|required'),
				array('field' => 'cd_area', 'label' => 'Área', 'rules' => 'trim|required'),
				array('field' => 'cd_celula', 'label' => 'Célula', 'rules' => 'trim|required'),
				array('field' => 'conf_senha', 'label' => 'Confirmar Senha', 'rules' => 'trim|required')
			),
			'update_profile' => array(
				array('field' => 'no_usuario', 'label' => 'Nome', 'rules' => 'trim|required'),
				array('field' => 'cd_area', 'label' => 'Área', 'rules' => 'trim|required'),
				array('field' => 'cd_celula', 'label' => 'Célula', 'rules' => 'trim|required'),
				array('field' => 'cd_unidade', 'label' => 'Unidade', 'rules' => 'trim|required')
			),
			'transfer' => array(
				array('field' => 'transfer_value', 'label' => 'Valor', 'rules' => 'trim|required'),
				array('field' => 'ds_motivo', 'label' => 'Motivo', 'rules' => 'trim|required'),
				array('field' => 'no_senha', 'label' => 'Senha', 'rules' => 'trim|required')
			),
			'new_password' => array(
				array('field' => 'no_email_new_password', 'label' => 'E-mail', 'rules' => 'trim|required|valid_email')
			),
			'create_profile' => array(
				array('field' => 'no_usuario', 'label' => 'Nome', 'rules' => 'trim|required'),
				array('field' => 'no_email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
				array('field' => 'cd_area', 'label' => 'Área', 'rules' => 'trim|required'),
				array('field' => 'cd_celula', 'label' => 'Célula', 'rules' => 'trim|required'),
				array('field' => 'cd_unidade', 'label' => 'Unidade', 'rules' => 'trim|required')
			),
			'kavs_all' => array(
				array('field' => 'nr_valor', 'label' => 'Valor', 'rules' => 'trim|required'),
				array('field' => 'no_senha', 'label' => 'Senha', 'rules' => 'trim|required'),
				array('field' => 'ds_motivo', 'label' => 'Motivo', 'rules' => 'trim|required')
			),
			'delete_user' => array(
				array('field' => 'no_senha', 'label' => 'Senha', 'rules' => 'trim|required')
			),
			'update_profile_admin' => array(
				array('field' => 'no_usuario', 'label' => 'Nome', 'rules' => 'trim|required'),
				array('field' => 'cd_area', 'label' => 'Área', 'rules' => 'trim|required'),
				array('field' => 'cd_celula', 'label' => 'Célula', 'rules' => 'trim|required'),
				array('field' => 'cd_unidade', 'label' => 'Unidade', 'rules' => 'trim|required'),
				array('field' => 'cd_tipo_usuario', 'label' => 'Tipo usuário', 'rules' => 'trim|required')
			),
			'deposito_user' => array(
				array('field' => 'nr_valor', 'label' => 'Valor', 'rules' => 'trim|required'),
				array('field' => 'ds_motivo', 'label' => 'Motivo', 'rules' => 'trim|required')
			),
			'create_reward' => array(
				array('field' => 'nr_valor', 'label' => 'Valor', 'rules' => 'trim|required'),
				array('field' => 'ds_premio', 'label' => 'Motivo', 'rules' => 'trim|required'),
				array('field' => 'no_premio', 'label' => 'Nome', 'rules' => 'trim|required'),
				array('field' => 'cd_categoria', 'label' => 'Categoria', 'rules' => 'trim|required'),
				array('field' => 'cd_status', 'label' => 'Status', 'rules' => 'trim|required')
			),
			'edit_reward' => array(
				array('field' => 'nr_valor', 'label' => 'Valor', 'rules' => 'trim|required'),
				array('field' => 'ds_premio', 'label' => 'Motivo', 'rules' => 'trim|required'),
				array('field' => 'cd_categoria', 'label' => 'Categoria', 'rules' => 'trim|required'),
				array('field' => 'cd_status', 'label' => 'Status', 'rules' => 'trim|required')
			),
	);
?>