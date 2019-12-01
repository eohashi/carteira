<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class tipousuarioModel extends MY_Model
{
    private $_tableName ='tb_tipo_usuario';
    private $_primaryKey ='cd_tipo_usuario';
    private $_orderBy ='no_tipo_usuario';

    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }
    
    public function getTiposOptions(){
    	$this->db->order_by($this->_orderBy, 'asc');
    	$results =  $this->db->get($this->_tableName)->result_array();
    	$array = array('' => 'Selecione');
    	foreach($results as $r){
    		$array[$r[$this->_primaryKey]] = $r[$this->_orderBy];
    	}
    	return ($array);
    }
}

?>