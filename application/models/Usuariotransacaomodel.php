<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class usuariotransacaoModel extends MY_Model{
    private $_tableName ='tb_usuario_transacao';
    private $_primaryKey ='cd_usuario_transacao';
    private $_orderBy ='dt_cadastro desc';

    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
	}
	
	function getTransaction($type){
		$this->db->join('tb_usuario as user', $this->_tableName.'.cd_usuario = user.cd_usuario');
		if($type == $this->config->item('transaction_resgate')){
			$this->db->select($this->_tableName.'.*, user.no_usuario as payer, no_premio, user.no_email_md5 as payer_md5');
			$this->db->join('tb_premio', $this->_tableName.'.cd_premio = tb_premio.cd_premio');
		}
		else if($type == $this->config->item('transaction_transfer')){
			$this->db->select($this->_tableName.'.*, user.no_usuario as payer, user.no_email_md5 as payer_md5, receiver.no_usuario as receiver, receiver.no_email_md5 as receiver_md5');
			$this->db->join('tb_usuario as receiver', $this->_tableName.'.cd_recebedor = receiver.cd_usuario');
		}
		
    	$result = $this->db->get($this->_tableName)->result();
    	#print_r($result);die;
    	return $result;
    }

    function getTransactionByReward($cd_premio){
		$this->db->select($this->_tableName.'.*, no_usuario, no_email');		
		$this->db->join('tb_usuario', $this->_tableName.'.cd_usuario = tb_usuario.cd_usuario');
		$this->db->where('cd_premio',$cd_premio);	
    	$result = $this->db->get($this->_tableName)->result();
    	#print_r($result);die;
    	return $result;
    }
}

?>