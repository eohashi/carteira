<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class logModel extends MY_Model{
    private $_tableName ='tb_log';
    private $_primaryKey ='cd_log';
	private $_orderBy='dt_acao desc';
    
    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }
    
    function inserirLog($cd_usuario, $no_acao, $cd_item, $no_tabela){
    	$log = array(
	    	'cd_usuario'=>$cd_usuario,
    		'no_acao'=>$no_acao,
    		'cd_item'=>$cd_usuario,
    		'no_tabela'=>$no_tabela
    	);
    	$this->inserir($log);
    }
}

?>