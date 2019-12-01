<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class gtmModel extends MY_Model{
    private $_tableName ='tb_gtm';
    private $_primaryKey ='cd_gtm';
    private $_orderBy ='cd_gtm';

    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }
    
    /* Verifica se existe o registro no Banco de dados */
	public function getGTMAdmin(){
    	$result = $this->db->get($this->_tableName)->row(0);
    	
    	return $result;
    }
    
	/* Verifica se existe o registro no Banco de dados e se o mesmo está ativo */
	public function getGTM(){
    	$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
    	$result = $this->db->get($this->_tableName)->row(0);
    	
    	return $result;
    }
}
?>