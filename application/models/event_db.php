<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class event_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene el registro del catalogo
     */
    public function getEventCategories($id){
        $this->db->select ('event_type.name, xref_event_categorie.eventId, xref_event_categorie.categorieId, xref_event_categorie.contenido');
        $this->db->from('xref_event_categorie');
        $this->db->join('event', 'xref_event_categorie.eventId = event.id ');
        $this->db->join('event_type', 'xref_event_categorie.categorieId = event_type.id ');
        $this->db->where('xref_event_categorie.eventId = ', $id);
        return  $this->db->get()->result();
    }
 
    /**
     * Obtiene el registro del catalogo
     */
    public function getAllCategories($name){
        $this->db->select ('id, name');
        $this->db->from('event_type');
        $this->db->like('name', $name);
        return  $this->db->get()->result();
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getFav(){
        $this->db->select('event.id, event.word, event.name, event.place, city.name as city, event.date, event.image');
        $this->db->from('event');
        $this->db->join('city', 'event.idCity = city.id ');
        $this->db->where('event.fav = 1');
        $this->db->where('event.status = 1');
        $this->db->where('event.date >= curdate()');
        $this->db->order_by("event.date", "asc");
        return  $this->db->get()->result();
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getAvailable(){
        $this->db->select('event.id, event.name, event.place, city.name as city, event.image, event.date, event.fav');
        $this->db->from('event');
        $this->db->join('city', 'event.idCity = city.id ');
        $this->db->where('event.status = 1');
        $this->db->where('event.date >= curdate()');
        $this->db->order_by("event.date", "asc");
        return  $this->db->get()->result();
    }
	
	/////////////////**///actual********///////////////////////////////
	
	//alfredo chi
	
	/**
	*optiene todos los eventos activos
	*/
	public function getAllEvents(){
		$this->db->select('event.id, event.name, event.partnerId, event.iniDate');
		$this->db->select("if(event.partnerId is null, place.name, partner.name) as place ", false);
        $this->db->from('event');
       	$this->db->join('partner', 'event.partnerId = partner.id ', 'left');
        $this->db->join('place', 'event.placeId = place.id ', 'left');
        $this->db->where('event.iniDate >= curdate()');
        $this->db->where('event.status = 1');
        $this->db->order_by("id", "ASC");
        return  $this->db->get()->result();
	}
	
	/**
	*optiene los eventos de la busqueda
	*/
	public function getallSearch($dato,$column,$order){
		$this->db->select('event.id, event.name, event.partnerId, event.iniDate');
		$this->db->select("if(event.partnerId is null, place.name, partner.name) as place ", false);
        $this->db->from('event');
       	$this->db->join('partner', 'event.partnerId = partner.id ', 'left');
        $this->db->join('place', 'event.placeId = place.id ', 'left');
        $this->db->where('event.iniDate >= curdate()');
		$this->db->where('event.status = 1');
		$this->db->where('(event.name LIKE \'%'.$dato.'%\' OR partner.name LIKE \'%'.$dato.'%\' 
		OR place.name LIKE \'%' . $dato . '%\')', NULL); 
		$this->db->order_by($column , $order);
        return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el registro de un evento
     */
   	public function get($id){
        $this->db->select('event.id, event.name, event.detail,event.partnerId, event.cityId, event.placeId');
		$this->db->select('event.iniDate, event.endDate,event.Image, event.ImageFull,');
		$this->db->select("if(event.partnerId is null, place.name, partner.name) as place ", false);
		$this->db->join('partner', 'event.partnerId = partner.id ', 'left');
        $this->db->join('place', 'event.placeId = place.id ', 'left');
        $this->db->select('city.name as cityName');
		//$this->db->select('event_type.name as typeName');
        $this->db->from('event');
        $this->db->join('city', 'event.cityId = city.idCity ');
		//$this->db->join('event_type', 'event.eventTypeId = event_type.id ');
        $this->db->where('event.id = ', $id);
        $this->db->where('event.status = 1');
        return  $this->db->get()->result();
    }
	
	//obtiene los filtros del deal
	public function getFilterOfEvents($id){
		$this->db->select('xref_event_filter.idFilter');	
		$this->db->from('xref_event_filter');
		$this->db->where('xref_event_filter.idEvent = ', $id);
		return $this->db->get()->result();
	}
	
	 /**
	* obtiene el lugar del evento
	**/
	public function getNamePlace($dato,$tabla){
       	$this->db->select('id, name');
     	$this->db->from($tabla);
  	    $this->db->like('name', $dato);	
		if($tabla == "place"){
			$this->db->where('status = 1');
		}
      	return  $this->db->get()->result();
	}
	
	//obtiene los filtros de los eventos
	public function gerFilterEvent(){
		$this->db->from('filter');
		$this->db->where('type = 1');
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene las imagenes de la galleria del comercio
	 */
	public function getAllGalleryById($eventId){
		$this->db->select('gallery.id, gallery.image');
        $this->db->from('gallery');
		$this->db->where('gallery.idEvent', $eventId);
        return  $this->db->get()->result();
	}
	
	/**
	* inserta los datos de un evento
	*/
	public function insertEvent($data,$idFilter){
		$this->db->insert('event', $data);
		$id = $this->db->insert_id();
		$filter = array();
		foreach($idFilter as $idF){
			array_push($filter, array(
				'idEvent' => $id,
				'idFilter'=> $idF));	
		}
		if(count($filter)>0){
			$this->db->insert_batch('xref_event_filter', $filter);
		}	
	}
	
	/**
	* actualiza los datos de un evento
	*/
	public function updateEvent($data,$delete,$filter){
		$this->db->where('id', $data['id']);
		$this->db->update('event', $data);
		$this->db->delete('xref_event_filter',$delete);
		if(count($filter)>0){
			$this->db->insert_batch('xref_event_filter', $filter);
		}
	}
	
	/**
	*elimina un evento
	*actualiza el status a 0
	*/
	public function deleteEvent($data){
		$this->db->where('id', $data['id']);
		$this->db->update('event', $data);
	}
	
	
}
//end model