<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* E-mail */
$config['email_sender'] = 'recuperacao.cherry.pay@gmail.com';
$config['email_admin'] = ['matheus.vaz@i-cherry.com.br'];
$config['email_sender_name'] = 'CherryPay';
$config['email_pass_recover'] = 'Recuperação de senha';
$config['email_transfer'] = 'Você recebeu Cherries!';
$config['email_collect_reward_user'] = 'Resgate coletado com sucesso!';
$config['email_collect_reward_admin'] = 'Resgate solicitado!';
$config['email_pass_sent'] = 'A nova senha foi enviada para o e-mail: ';
$config['email_nova_senha'] = 'Sua nova senha é: ';
$config['email_sent'] = 'E-mail enviado com sucesso.';
$config['email_invalid'] = 'Você inseriu um e-mail inválido.';
$config['email_enter'] = 'Informe seu e-mail.';
$config['email_registered'] = 'E-mail já cadastrado.';
$config['email_not_registered'] = 'E-mail não cadastrado.';

/* ------------------------------------------------------------------------------------------------ */

/* Error Messages */
$config['message_db_error'] = 'Ocorreu um erro de banco de dados.';
$config['message_perm_denied'] = 'Você não tem permissão executar esta operação.';
$config['message_pass_matches'] = 'As senhas não conferem.';
$config['message_login_error'] = 'Login ou senha incorreto(a).';
$config['message_item_not_found'] = 'Item não encontrado.';
$config['message_item_no_access'] = 'Você não tem acesso ao item.';
$config['message_item_own'] = 'Você não pode transferir para você mesmo!';

/* ------------------------------------------------------------------------------------------------ */

/* Success Messages */
$config['message_success_update'] = 'Registro atualizado com sucesso.';
$config['notify_success_updates'] = 'Registros alterados com sucesso.';
$config['notify_success_update'] = 'Registro alterado com sucesso.';
$config['message_success_insert'] = 'Registro inserido com sucesso.';
$config['message_success_delete'] = 'Registro excluído com sucesso.';
$config['message_success_registration'] = 'Cadastro realizado com sucesso.';

/* ------------------------------------------------------------------------------------------------ */

/* Alert Messages */
$config['message_item_exists'] = 'Item já existente.';
$config['message_file_not_found'] = 'O arquivo não foi encontrado.';

/* ------------------------------------------------------------------------------------------------ */

/* Directory */
$path = 'dir_upload';
$config[$path] = 'upload/';
$config[$path.'_tmp'] = 'upload/tmp/';
$config[$path.'_profile'] = 'upload/profiles/';

/* ------------------------------------------------------------------------------------------------ */

/* Status */
$config['active'] = 1;
$config['inactive'] = 2;
$config['deleted'] = 3;

/* ------------------------------------------------------------------------------------------------ */

/* Image size */
$config['width_thumb_galery'] = 640;
$config['heigth_thumb_galery'] = 359;
$config['width_img_hothome'] = 950;
$config['heigth_img_hothome'] = 350;
$config['width_featured_galery'] = 1024;
$config['height_featured_galery'] = 576;
$config['max_size_jpg'] = '4000';
$config['max_size_zip'] = '200000';

/* ------------------------------------------------------------------------------------------------ */

/* Tables */
$config['gtmmodel'] = 'tb_gtm';
$config['usuariomodel'] = 'tb_usuario';

/* ------------------------------------------------------------------------------------------------ */

/* Tipos de usuários, áreas e células */

$config['usuario_diretoria'] = 1;
$config['usuario_colaborador'] = 2;
$config['usuario_gestor'] = 3;
$config['usuario_admin'] = 5;
$config['usuario_rh'] = 6;
$config['usuario_misfits'] = 7;

$config['area_diretoria'] = 1;
$config['area_misfits'] = 6;
$config['area_rh'] = 7;

$config['celula_diretoria'] = 1;
$config['celula_misfits'] = 7;
$config['celula_rh'] = 6;

/* Others */

$config['transaction_resgate'] = 1;
$config['transaction_transfer'] = 2;

$config['premio_alimentacao'] = 1;
$config['premio_entretenimento'] = 2;
$config['premio_viagem'] = 3;
$config['premio_presente'] = 4;

$config['title_generic'] = 'CherryPay';
$config['project_name'] = 'CherryPay';
$config['root'] = '/cherry_pay/';
/* Each hour has 3600 seconds. So each day has 86400 seconds */
$config['cookie_expires'] = '432000';
$config['cookie_prefix'] = 'ch_pay_';


$config['query_limit'] = 10;
/* ------------------------------------------------------------------------------------------------ */

/* Logs */
$config['log_login'] = 'efetuou login';
$config['log_logoff'] = 'efetuou logoff';
$config['log_reset_pass'] = 'redefiniu senha';
$config['log_insert'] = 'inseriu';
$config['log_update'] = 'alterou';
$config['log_delete'] = 'excluiu';

/* ------------------------------------------------------------------------------------------------ */

/* Response Divs */
$config['div_success'] = '<div class="box-retorno m-alert m-alert--outline alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <span class="texto-retorno"></span>
                </div>';

$config['div_error'] = '<div class="box-retorno m-alert m-alert--outline alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"></button>
                    <span class="texto-retorno"></span>
                </div>';