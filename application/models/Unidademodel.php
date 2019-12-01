<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class unidadeModel extends MY_Model{
    private $_tableName ='tb_unidade';
    private $_primaryKey ='cd_unidade';
	private $_orderBy='no_unidade';
    
    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }
    
    public function getUnidadeOptions(){
    	$this->db->order_by($this->_orderBy, 'asc');		
    	$results =  $this->db->get($this->_tableName)->result_array();    	
    	$array = array('' => 'Selecione');    	
    	foreach($results as $r){
    		if($r['cd_status'] == $this->config->item('active')){
    			$array[$r[$this->_primaryKey]] = $r[$this->_orderBy];
    		}
    	}
    	return ($array);
    }
}

?>