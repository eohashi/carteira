<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class MY_Model extends CI_Model{
	private $_tableName;
	private $_primaryKey;
	private $_noSlug;
	private $_orderBy;
	private $_orderBySite;
		
	public function __construct( $_tableName = '', $_primaryKey = '', $_orderBy = '', $_orderBySite = '', $_noSlug = ''){
		$this->_tableName = $_tableName;
		$this->_primaryKey = $_primaryKey;
		$this->_noSlug = $_noSlug;
		$this->_orderBy = $_orderBy;
		$this->_orderBySite = $_orderBySite;
		parent::__construct ();
	}
	
	function alterar($id, $info){
		$this->db->trans_begin();		
		$this->db->where($this->_primaryKey, $id);
		$query = $this->db->update($this->_tableName, $info);
		if($query){
			$this->db->trans_commit();	
			$result['status'] = 'ok';
			$result['info'] = $this->config->item('message_success_update');
		}
		else{
			$result['status'] = 'erro';
			$result['info'] = array(
								'Error Number: '.$this->db->_error_number().'<br>',
								$this->db->_error_message().'<br>',
								$this->db->last_query(),
							);
		$this->db->trans_rollback();
		}	
		return $result;
	}
	
	function inserir($info){
		$this->db->trans_begin();
		if($this->db->insert($this->_tableName, $info)){
			$this->db->trans_commit();
			$query = $this->db->query('SELECT LAST_INSERT_ID()');
			$row = $query->row_array();
			$id = $row['LAST_INSERT_ID()'];
			$result['status'] = 'ok';
			$result['info'] = $id;
		}
		else{	
			$result['status'] = 'erro';
			$result['info'] = array(
								'Error Number: '.$this->db->_error_number().'<br>',
								$this->db->_error_message().'<br>',
								$this->db->last_query(),
							  );
		$this->db->trans_rollback();
		}		
		return $result;
	}
	
	function excluir($id){
		$this->db->trans_begin();
		try{
			$this->db->where($this->_primaryKey, $id);
			$this->db->delete($this->_tableName);
			$this->db->trans_commit();	
		}
		catch(Exception $e){
			$this->db->trans_rollback();
			return false;
		}
		return true;
	}
		
	public function get_dropdown_options(){
		$this->db->select($this->_primaryKey.','.$this->_orderBy);	
		$results =  $this->db->get($this->_tableName)->result_array();	
		$array = array();	
		foreach($results as $r){
			if($r['cd_status'] != $this->config->item('deleted')){
    			$array[$r[$this->_primaryKey]] = $r[$this->_orderBy];
    		}
		}	
		return ($array);
	}
	
	function setdeleted($id, $info){
		$this->db->trans_begin();
		try{
			$this->db->where($this->_primaryKey, $id);
			$this->db->update($this->_tableName, $info);
			$this->db->trans_commit();
	
		}
		catch(Exception $e){
			$this->db->trans_rollback();
			return false;
		}
		return true;
	}
	
	function getQtdeTotal(){
		$this->db->select('count(*) as quantidade');
		$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
		$this->db->where($this->_tableName.'.cd_status != '.$this->config->item('deleted'));
		$result = $this->db->get($this->_tableName)->row(0);	
		return $result->quantidade;
	}
	
	function getTodosItens(){
		$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
		$this->db->where($this->_tableName.'.cd_status != '.$this->config->item('deleted'));
		$this->db->order_by($this->_orderBy, 'asc');
		$result = $this->db->get($this->_tableName)->result();
		return $result;
	}
	
	function getItensLimit($limit = 0, $offset = 0){
		$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
		$this->db->where($this->_tableName.'.cd_status != '.$this->config->item('deleted'));
		$this->db->order_by($this->_orderBy);
		if($limit == 0)
			$result = $this->db->get($this->_tableName)->result();
		else
			$result = $this->db->get($this->_tableName, $limit, $offset)->result();
		
		return $result;
	}
	
	function searchItens($field1 = '', $field2 = '', $search = '', $date_search = '' ){
		$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
		$this->db->where($this->_tableName.'.cd_status != '.$this->config->item('deleted'));
		if((trim($search) != '') && (trim($field1) != ''))
			$this->db->where($this->_tableName.'.'.$field1.' like \'%'.$search.'%\'','', false);
		if((trim($date_search) != '') && (trim($field2) != ''))
			$this->db->where('date_format('.$this->_tableName.'.'.$field2.', \'%d/%m/%Y\') = \''.$date_search.'\'','', false);
		$this->db->order_by($this->_orderBy);		
		$result = $this->db->get($this->_tableName)->result();
		return $result;
	}
	
	function getAtivos(){
		$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
		$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
		$result = $this->db->get($this->_tableName)->result();		
		return $result;
	}
	
	function getItem($id){
		$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
		$this->db->where($this->_tableName.'.'.$this->_primaryKey, $id);
		$result = $this->db->get($this->_tableName)->row(0);
		#echo $this->db->last_query();die;
		if($result)
			return $result;
		else redirect('admin/home/item_inexistente');
	}
	
	function getItemAtivo($id){
		$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
		$this->db->where($this->_primaryKey, $id);
		$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
		$result = $this->db->get($this->_tableName)->row(0);	
		return $result;
	}
	
	function verificaSlugItem($no_slug_item){
		$this->db->where($this->_noSlug, $no_slug_item);
		$this->db->where($this->_tableName.'.cd_status != '.$this->config->item('deleted'));
		$result = $this->db->get($this->_tableName)->row(0);
		return $result;
	}
	
	function getItemSlug($no_slug){
		$this->db->where($this->_noSlug, $no_slug);
		$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
		$result = $this->db->get($this->_tableName)->row(0);
		return $result;
	}
	
	function getColunas(){
		$result = $this->db->list_fields($this->_tableName);		
		return $result;
	}
	
	function verificaEmail($no_email){
		$this->db->where('no_email', $no_email);
		$this->db->where($this->_tableName.'.cd_status != '.$this->config->item('deleted'));
		$result = $this->db->get($this->_tableName)->row(0);		
		return $result;
	}
	
	function verifyEmailMd5($email){
    	$this->db->where('no_email_md5', $email);
    	$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
    	$result = $this->db->get($this->_tableName)->row(0);
    	
    	return $result;
    }
}