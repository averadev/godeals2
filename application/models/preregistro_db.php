<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class preregistro_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
    
    /**
	* inserta los datos de un cloud por hora
	*/
	public function insertPreregistro($data){
		$this->db->insert('preregistration', $data);
        return $this->db->insert_id();
	}
    
    /**
	* Obtiene los usuarios y su md5
	*/
    public function getActivations(){
		$this->db->from('activation');
        $this->db->where("date >= curdate()");
        return  $this->db->get()->result();
	}

	

}
//end model