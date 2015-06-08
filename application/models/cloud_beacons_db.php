<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class cloud_beacons_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
    
    /**
	* inserta los datos de un cloud por hora
	*/
	public function insertCloudDay($data){
		$this->db->insert('cloud_day', $data);
        return $this->db->insert_id();
	}
    
    /**
	* inserta los datos de un cloud por hora
	*/
	public function insertCloudTime($data){
		$this->db->insert('cloud_time', $data);
        return $this->db->insert_id();
	}
    
    /**
	* inserta los mac address de los devices en el comercio
	*/
	public function insertCloudDevice($data){
		$this->db->insert('xref_cloud_device', $data);
	}
    
    /**
	* Obtiene los comercios con clouds beacons
	*/
    public function getPartnerCloud(){
		$this->db->select ('id, idCloud');
		$this->db->from('partner');
		$this->db->where('status = 1');
        $this->db->where("idCloud != ''");
        return  $this->db->get()->result();
	}
    
    /**
	* Obtiene los usuarios y su md5
	*/
    public function getMacAddressUser(){
		$this->db->select ('id, mac');
		$this->db->from('user');
        $this->db->where("mac != ''");
        return  $this->db->get()->result();
	}
	

}
//end model