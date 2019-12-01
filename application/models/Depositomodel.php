<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class depositoModel extends MY_Model{
    private $_tableName ='tb_deposito';
    private $_primaryKey ='cd_deposito';
	private $_orderBy='dt_cadastro DESC';
    
    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }

    
}

?>