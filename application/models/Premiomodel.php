<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class premioModel extends MY_Model{
    private $_tableName ='tb_premio';
    private $_primaryKey ='cd_premio';
	private $_orderBy='nr_valor';
    
    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }
}

?>