<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );
class usuarioModel extends MY_Model{
    private $_tableName ='tb_usuario';
    private $_primaryKey ='cd_usuario';
    private $_orderBy ='cd_usuario';

    public function __construct(){
        parent::__construct($this->_tableName, $this->_primaryKey, $this->_orderBy);
	}
	
	function getPerfisAtivos(){
		$this->db->select($this->_tableName.'.*, no_area, no_celula, no_unidade');
		$this->db->join('tb_area', $this->_tableName.'.cd_area = tb_area.cd_area');
		$this->db->join('tb_celula', $this->_tableName.'.cd_celula = tb_celula.cd_celula');
		$this->db->join('tb_unidade', $this->_tableName.'.cd_unidade = tb_unidade.cd_unidade');
		$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
    	$result = $this->db->get($this->_tableName)->result();
    	 
    	return $result;
    }

    function getAniversariantes(){
        $this->db->where('month(dt_nasc)', date('m'));
        $this->db->order_by('day(dt_nasc)');
        $this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
        $result = $this->db->get($this->_tableName)->result();
        return $result;
    }

	public function verifyLogin($info){
    	$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
		foreach($info as $key=>$value){
			$this->db->where($key,$value);
		}
		$result = $this->db->get($this->_tableName)->row(0);
		#echo $this->db->last_query();die;
    	return $result;
    }
    
    function verificaEmailNovaSenha($info){
    	$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
    	$this->db->where($info);
    	$result = $this->db->get($this->_tableName)->row(0);
    	 
    	return $result;
    }
    
    function verifyEmail($email, $cd_usuario = 0){
		$this->db->where('no_email', $email);
		$this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));
		if($cd_usuario != 0)
			$this->db->where('cd_usuario', $cd_usuario);
    	$result = $this->db->get($this->_tableName)->row(0);
    	
    	return $result;
	}
	
	function verifyEmailMD5($email, $status = ''){
		$this->db->select($this->_tableName.'.*, no_area, no_celula, no_unidade, no_tipo_usuario');
		$this->db->where('no_email_md5', $email);
		$this->db->join('tb_area', $this->_tableName.'.cd_area = tb_area.cd_area');
		$this->db->join('tb_celula', $this->_tableName.'.cd_celula = tb_celula.cd_celula');
		$this->db->join('tb_unidade', $this->_tableName.'.cd_unidade = tb_unidade.cd_unidade');
		$this->db->join('tb_tipo_usuario', $this->_tableName.'.cd_tipo_usuario = tb_tipo_usuario.cd_tipo_usuario');
		if($status != '')
            $this->db->where($this->_tableName.'.cd_status !='.$this->config->item('deleted'));
        else
            $this->db->where($this->_tableName.'.cd_status', $this->config->item('active'));

    	$result = $this->db->get($this->_tableName)->row(0);
    	
    	return $result;
    }
	
	function getUsuarios(){
    	$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
    	$this->db->join('tb_tipo_usuario', 'tb_tipo_usuario.cd_tipo_usuario = '.$this->_tableName.'.cd_tipo_usuario');
        $this->db->where($this->_tableName.'.cd_status !='. $this->config->item('deleted'));
        $this->db->order_by($this->_tableName.'.'.$this->_orderBy.' desc');
    	$result = $this->db->get($this->_tableName)->result();
    	
    	return $result;
	}
	
	function getUsuariosLimit($limit = 0, $offset = 0){
    	$this->db->join('tb_status', 'tb_status.cd_status = '.$this->_tableName.'.cd_status');
    	$this->db->join('tb_tipo_usuario', 'tb_tipo_usuario.cd_tipo_usuario = '.$this->_tableName.'.cd_tipo_usuario');
        $this->db->where($this->_tableName.'.cd_status !='. $this->config->item('deleted'));
		$this->db->order_by($this->_tableName.'.'.$this->_orderBy.' desc');
		if($limit == 0)
			$result = $this->db->get($this->_tableName)->result();
		else
			$result = $this->db->get($this->_tableName, $limit, $offset)->result();
    	
    	return $result;
    }
    
    function verificaSenha($cd_usuario, $senha){
    	$this->db->where($this->_tableName.'.no_senha', md5($senha));
    	$result = $this->db->get($this->_tableName)->row(0);
    	
    	return $result;
    }

    function getKavs(){
        $this->db->select('cd_usuario,nr_saldo');
        $this->db->where($this->_tableName.'.cd_status !='. $this->config->item('deleted'));
        $result = $this->db->get($this->_tableName)->result();
        
        return $result;
    }
}

?>