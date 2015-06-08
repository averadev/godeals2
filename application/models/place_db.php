<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class place_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function get($id){
        $this->db->select('id, title, txtMax');
        $this->db->from('place');
        $this->db->where('status = 1');
        $this->db->where('id', $id);
        return  $this->db->get()->result();
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getAll(){
        $this->db->select('id, name, title, txtMin, weatherKey');
        $this->db->from('place');
        $this->db->where('status = 1');
        $this->db->order_by("id", "asc");
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getByType($type){
        $this->db->select('place.id, place.name, place.title, place.txtMin, place.weatherKey');
        $this->db->from('xref_place_type');
        $this->db->join('place', 'xref_place_type.placeId = place.id');
        $this->db->where('place.status = 1');
        $this->db->where('xref_place_type.placeTypeId', $type);
        $this->db->order_by("place.id", "asc");
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getBanners($id){
        $this->db->select('image');
        $this->db->from('place_banner');
        $this->db->where('status = 1');
        $this->db->where('placeId', $id);
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getBars($id){
        $this->db->select('nombre, info, address, phone');
        $this->db->from('place_bar');
        $this->db->where('status = 1');
        $this->db->where('placeId', $id);
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getHotels($id){
        $this->db->select('nombre, info, address, phone');
        $this->db->from('place_hotel');
        $this->db->where('status = 1');
        $this->db->where('placeId', $id);
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getRestaurants($id){
        $this->db->select('nombre, info, address, phone');
        $this->db->from('place_restaurant');
        $this->db->where('status = 1');
        $this->db->where('placeId', $id);
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getPhotos($id){
        $this->db->select('image');
        $this->db->from('place_photo');
        $this->db->where('status = 1');
        $this->db->where('placeId', $id);
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getTransport($id){
        $this->db->select('transport.id, transport.name');
        $this->db->from('xref_place_transport');
        $this->db->join('transport', 'transport.id = xref_place_transport.transportId');
        $this->db->where('transport.status = 1');
        $this->db->where('xref_place_transport.placeId', $id);
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getPlaceType($type){
        $this->db->select('id, name');
        $this->db->from('placeType');
        $this->db->where('status = 1');
        $this->db->where('type', $type);
        return  $this->db->get()->result();
    }
	
	/*
	* alfredo chi
	*/
	
	
	
	/*
	** obtienes las imagenes de place_banner por id
	*/
	public function getBannerId($id){
		$this->db->select('id,image');
		$this->db->from('place_banner');
		$this->db->where('placeId',$id);
		$this->db->where('status = 1');	
		return $this->db->get()->result();
	}
	
	/*
	** obtiene todos los datos de un comercio por forenkeys
	*/
	public function getXrefByIds($placeId , $partnerId){
        $this->db->select('xref_place_partner.partnerId, xref_place_partner.type, partner.name');
        $this->db->from('xref_place_partner');
		$this->db->join('partner', 'partner.id = xref_place_partner.partnerId');
		$this->db->where('xref_place_partner.placeId', $placeId);
		$this->db->where('xref_place_partner.partnerId', $partnerId);
        return  $this->db->get()->result();	
    }
	
	public function getXrefActive($id){
		$this->db->select('xref_place_partner.partnerId, xref_place_partner.type, partner.name, partner.info');
        $this->db->from('xref_place_partner');
		$this->db->join('partner', 'partner.id = xref_place_partner.partnerId');
		$this->db->where('xref_place_partner.placeId', $id);
        return  $this->db->get()->result();	
	}
	
	public function getallSearchXref($idPlace,$dato){
		$this->db->select('xref_place_partner.partnerId, xref_place_partner.type, partner.name, partner.info');
        $this->db->from('xref_place_partner');
		$this->db->join('partner', 'partner.id = xref_place_partner.partnerId');
		$this->db->where('xref_place_partner.placeId', $idPlace);
		$this->db->where('(partner.name LIKE \'%'.$dato.'%\')', NULL);
        return  $this->db->get()->result();
	}
	
	public function getAllGalleryById($placeId){
		$this->db->select('place_photo.id, place_photo.image');
        $this->db->from('place_photo');
		$this->db->where('place_photo.placeId', $placeId);
		$this->db->where('place_photo.status', 1);
        return  $this->db->get()->result();
	}
	
	public function insertXref($data){
		$this->db->insert('xref_place_partner', $data);
	}
	
	public function insertGallery($data){
		$this->db->insert_batch('place_photo', $data);
	}
	
	public function updateXref($data,$partnerId){
		$this->db->where('placeId', $data['placeId']);
		$this->db->where('partnerId', $partnerId);
		$this->db->update('xref_place_partner', $data);
	}
	
	public function updateGallery($data){
		$this->db->update_batch('place_photo',$data,'id');
	}
	
	/*
	** elimina los datos de xref_place_partner
	*/
	
	public function deleteXref($data){
		$this->db->where('placeId', $data['placeId']);
		$this->db->where('partnerId', $data['partnerId']);
		$this->db->delete('xref_place_partner', $data);
	}
	
	//////////////////////////////////////////////////////////////////
	//////////////////////////////*ACTUAL*////////////////////////////
	//////////////////////////////////////////////////////////////////
	
	/*
	* obtiene todos los lugares activos
	*/
	public function getAllActivePlace(){
        $this->db->select('place.id, place.name, place.address');
        $this->db->from('place');
        $this->db->where('place.status = 1');
        return  $this->db->get()->result();
    }
	
	/*
	** obtiene todos los datos de un lugar por id
	*/
	public function getId($id){
        $this->db->select('place.id, place.name, place.address, place.longitude, place.latitude, place.image');
        $this->db->from('place');
		$this->db->where('place.id', $id);
        $this->db->where('place.status = 1');
        return  $this->db->get()->result();
    }
	
	/*
	* obtiene todos los registros de la busqueda
	*/
	public function getallSearch($dato,$column,$order){
		$this->db->select('place.id, place.name, place.address');
        $this->db->from('place');
        $this->db->where('place.status = 1');
		$this->db->where('(place.name LIKE \'%'.$dato.'%\' OR place.address LIKE \'%'.$dato.'%\')', NULL); 
		$this->db->order_by($column , $order);
        return  $this->db->get()->result();
	}
	
	/*
	* inserta datos en la tabla place
	*/
	public function insertPlace($data){
		$this->db->insert('place', $data);
	}
	
	/*
	** actualiza los datos del lugar
	*/
	public function updatePlace($data){
		$this->db->where('id', $data['id']);
		$this->db->update('place', $data);
	}
	
}
//end model