<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class areaModel extends MY_Model{
    private $_tableName ='tb_area';
    private $_primaryKey ='cd_area';
	private $_orderBy='no_area';
    
    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
    }
    
    public function getAreaOptions(){
		$arr=array(
			$this->config->item('area_diretoria'),
			$this->config->item('area_misfits'),
			$this->config->item('area_rh')
		);
		$this->db->order_by($this->_orderBy, 'asc');
		$this->db->where('cd_status', $this->config->item('active'));
		$this->db->where_not_in($this->_primaryKey, $arr);
		$results =  $this->db->get($this->_tableName)->result_array();
    	$array = array('' => 'Selecione');
    	foreach($results as $r){
			$array[$r[$this->_primaryKey]] = $r[$this->_orderBy];
    	}
    	return ($array);
    }

    public function getAreaOptionsAdmin(){
		$this->db->order_by($this->_orderBy, 'asc');
		$this->db->where('cd_status', $this->config->item('active'));
		$results =  $this->db->get($this->_tableName)->result_array();
    	$array = array('' => 'Selecione');
    	foreach($results as $r){
			$array[$r[$this->_primaryKey]] = $r[$this->_orderBy];
    	}
    	return ($array);
    }
}

?>