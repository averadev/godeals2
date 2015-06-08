<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class promo_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene el registro del catalogo
     */
    public function get($id){
        $this->db->select ('coupon.id, coupon.image, coupon.detail, coupon.clauses, coupon.validity, coupon.partnerId');
        $this->db->select ('coupon.cityId, partner.name as partnerName, city.name as cityName, partner.logo');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.id = ', $id);
        $this->db->where('coupon.status = 1');
        return  $this->db->get()->result();
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getAvailable(){
        $this->db->from('coupon');
        $this->db->where('status = 1');
        $this->db->where('iniDate <= curdate()');
        $this->db->where('endDate >= curdate()');
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getHomeCoupons(){
        $this->db->select ('coupon.id, coupon.image, coupon.partnerId, coupon.cityId');
        $this->db->select ('partner.name as partnerName, city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('coupon.timer = 0');
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getHomeTimers(){
        $this->db->select ('coupon.id, coupon.image, coupon.description, coupon.partnerId, coupon.cityId');
        $this->db->select ('partner.name as partnerName, city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('coupon.timer = 1');
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getByType($type){
        $this->db->select ('coupon.id, coupon.image, coupon.partnerId, coupon.cityId');
        $this->db->select ('partner.name as partnerName, city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('catalog.status = 1');
        $this->db->where('catalog.type', $type);
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('coupon.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getByPartner($id){
        $this->db->select ('coupon.id, coupon.image, coupon.partnerId, coupon.cityId');
        $this->db->select ('partner.name as partnerName, city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('coupon.partnerId', $id);
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('coupon.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getByPlace($id){
        $this->db->select ('coupon.id, coupon.image, coupon.partnerId, coupon.cityId');
        $this->db->select ('partner.name as partnerName, city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('city.id', $id);
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('coupon.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getByTxt($text){
        $this->db->select ('coupon.id, coupon.image, coupon.partnerId, coupon.cityId');
        $this->db->select ('partner.name as partnerName, city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('(city.name LIKE \'%'.$text.'%\' OR coupon.description LIKE \'%'.$text.'%\' OR coupon.detail LIKE \'%'.$text.'%\' OR partner.name LIKE \'%'.$text.'%\' OR catalog.name LIKE \'%'.$text.'%\')', NULL); 
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('coupon.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getByTypeCat($type, $categorie){
        $this->db->select ('coupon.id, coupon.image, coupon.description, coupon.partnerId, coupon.cityId');
        $this->db->select ('partner.name as partnerName, city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('catalog.status = 1');
        $this->db->where('catalog.type', $type);
        $this->db->where('catalog.id', $categorie);
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('coupon.id'); 
        return  $this->db->get()->result();
    }
	
	public function getDaysOfCoupon($couponId){
		$this->db->select('day');
		$this->db->from('xref_coupon_day');
		$this->db->where('couponId',$couponId);
		return $this->db->get()->result();
	}
	
	public function deleteCoupon($data,$id){
		$this->db->where('id', $data['id']);
		$this->db->update('coupon', $data);
		
		//elimina las notificaciones
		$this->db->where('idRelacional', $id);
		$this->db->delete('notifications'); 
		//elimina la descarga
		$this->db->where('idCupon', $id);
		$this->db->delete('xref_cliente_cupon'); 
    }
	
	/////////////actual////////////////
	
	//obtiene todos los deals activos
	public function getAllActive(){
        $this->db->select('coupon.id, coupon.name, coupon.partnerId, coupon.total');
        $this->db->select('partner.name as partnerName');
		$this->db->select('xref_cliente_cupon.status');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('xref_cliente_cupon', 'coupon.id = xref_cliente_cupon.idCupon ', 'left');
        $this->db->where('coupon.status = 2');
		$this->db->order_by("id", "asc");
        return  $this->db->get()->result();
    }
	
	/**
	* obtiene la descripcion, clientes y ubicacion de la busqueda relacionada
	**/
	public function getallSearch($dato,$column,$order){
		$this->db->select ('coupon.id, coupon.name, coupon.partnerId, coupon.total');
		$this->db->select ('partner.name as partnerName');
		$this->db->select('xref_cliente_cupon.status');
        $this->db->from('coupon');
		$this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('xref_cliente_cupon', 'coupon.id = xref_cliente_cupon.idCupon ', 'left');
		$this->db->where('coupon.status = 2');
		$this->db->where('(coupon.name LIKE \'%'.$dato.'%\' OR partner.name LIKE \'%'.$dato.'%\' 
		OR coupon.total LIKE \'%' . $dato . '%\')', NULL); 
		$this->db->order_by($column , $order);
        return  $this->db->get()->result();
	}
	
	//obtiene los filtros de los deals
	public function gerFilterCoupon(){
		$this->db->from('filter');
		$this->db->where('type = 2');
		return  $this->db->get()->result();
	}
	
	//obtiene un deal por id
	public function getId($id){
        $this->db->select('coupon.id, coupon.name, coupon.partnerId, coupon.cityId, coupon.image, coupon.detail');
		$this->db->select('coupon.clauses, coupon.validity, coupon.total, coupon.iniDate, coupon.endDate');
        $this->db->select('partner.name as partnerName');
		$this->db->select('city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('city', 'coupon.cityId = city.idCity ');
        $this->db->where('coupon.id = ', $id);
        $this->db->where('coupon.status = 2');
        return  $this->db->get()->result();
    }
	
	//obtiene los filtros del deal
	public function getFilterOfDeals($id){
		$this->db->select('xref_coupon_filter.idFilter');	
		$this->db->from('xref_coupon_filter');
		$this->db->where('xref_coupon_filter.idCoupon = ', $id);
		return $this->db->get()->result();
	}
	
	//obtiene los correos de los usuarios
	public function getUser($dato){
		$this->db->select('user.id,user.email');
		$this->db->from('user');
		$this->db->like('user.email', $dato);
		return $this->db->get()->result();
	}
	
	//obtiene la id del correo
	public function getUserById($id){
		/*$this->db->select('user.id,user.email');
		$this->db->from('user');
		$this->db->join('notifications', 'notifications.idUsuario = user.id');
		$this->db->where('notifications.idRelacional', $id);*/
		$this->db->select('user.id,user.email');
		$this->db->from('user');
		$this->db->join('xref_cliente_cupon', 'xref_cliente_cupon.idCliente = user.id');
		$this->db->where('xref_cliente_cupon.idCupon', $id);
		return $this->db->get()->result();
	}
	
	public function comprobarNotificacion($idRelacional,$idUsuario){
		$this->db->select('id');
		$this->db->from('notifications');
		$this->db->where('idRelacional', $idRelacional);
		$this->db->where('idUsuario',$idUsuario);
		return $this->db->get()->result();
		/*$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('idCliente',$idUsuario);
		$this->db->where('idCupon', $idRelacional);
		return $this->db->get()->result();	*/
	}
	
	//inserta deals 
	public function insertCoupon($data,$idFilter){
		$this->db->insert('coupon', $data);	
		$id = $this->db->insert_id();
		
		$filter = array();
		foreach($idFilter as $idF){
			array_push($filter, array(
				'idCoupon' => $id,
				'idFilter'=> $idF));	
		}
		
		if(count($filter)>0){
			$this->db->insert_batch('xref_coupon_filter', $filter);
		}
		
		return $id;
		
	}
	
	//inserta la promocion del cupon
	public function insertPromocion($notificacion,$descarga){
		$this->db->insert('notifications', $notificacion);
		$this->db->insert('xref_cliente_cupon', $descarga);
	}
	
	//actualiza los datos del deals
	public function updateCoupon($data,$delete,$filter){
		$this->db->where('id', $data['id']);
		$this->db->update('coupon', $data);
		$this->db->delete('xref_coupon_filter',$delete);
		if(count($filter)>0){
			$this->db->insert_batch('xref_coupon_filter', $filter);
		}
    }
	
	//actualiza la notificacion del coupon
	public function updatePromocion($notificacion,$descarga){
		$this->db->where('id', $data['id']);
		$this->db->update('notifications', $notificacion);
		$this->db->where('id', $data['id']);
		$this->db->update('xref_cliente_cupon', $descarga);	
	}

}
//end model