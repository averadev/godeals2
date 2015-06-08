<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class city_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
    
    /**
	* obtiene la descripcion, clientes y ubicacion de la busqueda relacionada
	**/
	public function getNameSearch($dato){
            $this->db->select('city.idCity, city.name');
            $this->db->from('city');
            $this->db->like('city.name', $dato);
            return  $this->db->get()->result();
	}
          
}
