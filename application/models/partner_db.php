<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class partner_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }

    
    /**
     * Obtiene el registro de un partner
     */
    public function getId($id){
        $this->db->select('partner.id, partner.name, partner.image, partner.banner, partner.address, partner.phone'); 
		$this->db->select('partner.email, partner.twitter, partner.facebook, partner.latitude, partner.longitude');
		$this->db->select('partner.info');
        $this->db->from('partner');
        $this->db->where('partner.id = ', $id);
        $this->db->where('partner.status = 1');
        return  $this->db->get()->result();
    }
    
    
        /**
	* obtiene la descripcion, clientes y ubicacion de la busqueda relacionada
	**/
	public function getNameSearch($dato){
            $this->db->select('partner.id, partner.name, partner.latitude, partner.longitude');
            $this->db->from('partner');
            $this->db->like('partner.name', $dato);
            $this->db->where('partner.status = 1');
            return  $this->db->get()->result();
	}
        
	public function getAllActive(){
            //id,name,logo
		/*$this->db->select ('partner.id, partner.name, partner.info, partner.image, partner.banner, partner.address');
		$this->db->select ('partner.phone, partner.latitude, partner.longitude, partner.facebook, partner.banner, partner.address');*/
		$this->db->from('partner');
		$this->db->where('partner.status = 1');
		$this->db->order_by("id", "asc");
        return  $this->db->get()->result();
	}
        
        //para mostrar en la tabla paginadora
	public function getAllSearch($dato,$column,$order){
		$this->db->select ('partner.id, partner.name, partner.phone');
        $this->db->from('partner');
        $this->db->where('partner.status = 1');
        $this->db->where('(partner.name LIKE \'%'.$dato.'%\' OR partner.phone LIKE \'%' . $dato . '%\')', NULL); 
        $this->db->order_by($column , $order);
        return  $this->db->get()->result();
	}
	
	public function insertPartner($data){
		$this->db->insert('partner', $data);
	}
        
    /**
	* actualiza los datos de partner
	*/
	public function updatePartner($data){
		$this->db->where('id', $data['id']);
        $this->db->update('partner', $data);
	}
        
	/*
	*	actualiza el status a 0
	*/
    public function deletePartner($id){
        $data = array(
			'status' => 0
		);
		$this->db->where('id', $id);
		$this->db->update('partner', $data);
    }
	
	public function getEmail($dato){
		$this->db->select('partner.mail');
        $this->db->from('partner');
		$this->db->where('partner.mail = ', $dato);
		return  $this->db->get()->result();
	}
	
	/*
	 * inserta los datos de la galeria
	*/
	public function insertGallery($data){
		$this->db->insert_batch('gallery', $data);
	}
	
	/**
	 * Obtiene las imagenes de la galleria del comercio
	 */
	public function getAllGalleryById($partnerId){
		$this->db->select('gallery.id, gallery.image');
        $this->db->from('gallery');
		$this->db->where('gallery.idPartner', $partnerId);
        return  $this->db->get()->result();
	}
	
	/**
	 * elimina una imagen de la galeria
	 */
	public function deleteGallery($data){
		
		$imgDelet = array();
		
		foreach($data as $item){
			
			$this->db->select('gallery.image');
			$this->db->from('gallery');
			$this->db->where('gallery.id', $item);
			$id =  $this->db->get()->result();
			
			$this->db->where('id', $item);
			$this->db->delete('gallery');
			
			$rutaMax="assets/img/app/partner/gallery/";
            unlink($rutaMax . $id[0]->image);
			
		}
		
		return $id;
	}
	
}
//end model

