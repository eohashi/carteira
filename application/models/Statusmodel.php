<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class statusModel extends MY_Model{
    private $_tableName ='tb_status';
    private $_primaryKey ='cd_status';
    private $_orderBy ='no_status';

    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }
    
    public function getStatusOptions(){
    	$this->db->order_by($this->_orderBy, 'asc');		
    	$results =  $this->db->get($this->_tableName)->result_array();    	
    	$array = array();   	
    	foreach($results as $r){
    		if($r['cd_status'] != $this->config->item('deleted')){
    			$array[$r[$this->_primaryKey]] = $r[$this->_orderBy];
    		}
    	}
    	return ($array);
    }
}

?>