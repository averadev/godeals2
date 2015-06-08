<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class ads_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
	
	/////////////actual////////////////
	
	//obtiene todos los deals activos
	public function getAllActive(){
        $this->db->select('ads.id, ads.message, ads.type, ads.distanceMin, ads.distanceMax');
        $this->db->from('ads');
        $this->db->where('ads.status = 1');
		$this->db->order_by("id", "asc");
        return  $this->db->get()->result();
    }
	
	/**
	* obtiene la descripcion, clientes y ubicacion de la busqueda relacionada
	**/
	public function getallSearch($dato,$column,$order){
		$this->db->select('ads.id, ads.message, ads.type, ads.distanceMin, ads.distanceMax');
        $this->db->from('ads');
		$this->db->where('ads.status = 1');
		//$this->db->where('(ads.name LIKE \'%'.$dato.'%\' OR partner.name LIKE \'%'.$dato.'%\' 
		//OR coupon.total LIKE \'%' . $dato . '%\')', NULL); 
		$this->db->like('message',$dato);
		$this->db->order_by($column , $order);
        return  $this->db->get()->result();
	}
	
	//obtiene un deal por id
	public function getId($id){
		$this->db->select('ads.id, ads.major, ads.type, ads.partnerId, ads.message, ads.image');
        $this->db->select('ads.distanceMin, ads.distanceMax, ads.latitude, ads.longitude, ads.displayInfo');
        $this->db->select('partner.name as partnerName');
        $this->db->from('ads');
        $this->db->join('partner', 'ads.partnerId = partner.id ');
        $this->db->where('ads.id = ', $id);
        $this->db->where('ads.status = 1');
        return  $this->db->get()->result();
    }
	
	//inserta deals 
	public function insertAds($data){
		$this->db->insert('ads', $data);
	}
	
	//actualiza los datos del deals
	public function updateAds($data){
		$this->db->where('id', $data['id']);
		$this->db->update('ads', $data);
    }
	
	public function deleteAds($data){
		$this->db->where('id', $data['id']);
		$this->db->update('ads', $data);
    }

}
//end model