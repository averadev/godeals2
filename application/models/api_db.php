<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class api_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
	
	 /**
     * registro del usuario
     */
    public function insert($data){
        $this->db->insert('user', $data);
        return $this->db->insert_id();
    }
    
    /**
     * Actualizacion del usuario
     */
    public function update($data){
        $this->db->where('email', $data['email']);
        $this->db->update('user', $data);
    }
 
    /**
     * Obtiene los datos del usuario
     */
    public function get($data){
        $this->db->from('user');
        $this->db->where($data);
        return $this->db->get()->result();
    }
 
    /**
     * verifica si el usuario ya se ha registrado
     */
    public function verifyEmail($email){
        $this->db->from('user');
        $this->db->where('email', $email);
        return $this->db->get()->result();
    }
	
	/**
     * veridica si el correo y password existen
     */
    public function verifyEmailPass($email, $pass){
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->where('password', $pass);
        return $this->db->get()->result();
    }
	
	/**
	 * obtenemos los stock disponibles del cupon
	 */
	 
	function verifyStockCoupon($idCoupon){
		$this->db->select('stock');
		$this->db->from('coupon');
        $this->db->where('id', $idCoupon);
		$this->db->where('status', 1);
        return $this->db->get()->result();
	}
	
	/**
	 * actualiza los cupones disponibles
	 */
	 
	function updateStock($data){
		$this->db->where('id', $data['id']);
        $this->db->update('coupon', $data);
	}
	
	/**
	 * inserta un cupon al cliente
	 */
	 
	 function insertClienteCoupon($data){
		$this->db->insert('xref_cliente_cupon', $data);
	 }
	
	/**
	 *
	 */
    
    public function getAllEvent($idCity){
        $this->db->select('event.id, event.name, event.partnerId, event.detail, event.iniDate, event.image, event.imageFull');
        $this->db->select("if(event.partnerId is null, place.name, partner.name) as place ", false);
        $this->db->select("if(event.partnerId is null, place.address, partner.address) as address ", false);
        $this->db->select("if(event.partnerId is null, place.latitude, partner.latitude) as latitude ", false);
        $this->db->select("if(event.partnerId is null, place.longitude, partner.longitude) as longitude ", false);
        $this->db->select("if(event.partnerId is null, place.image, partner.image) as placeImage ", false);
        $this->db->select("if(event.partnerId is null, place.banner, partner.banner) as placeBanner ", false);
		$this->db->select("if(event.partnerId is null, event.placeId, event.partnerId) as  typeId", false);
        $this->db->from('event');
        $this->db->join('partner', 'event.partnerId = partner.id ', 'left');
        $this->db->join('place', 'event.placeId = place.id ', 'left');
        $this->db->where('event.status = 1');
        $this->db->where('event.iniDate >= curdate()');
		$this->db->order_by('event.iniDate',"ASC");
        return  $this->db->get()->result();
    }
    
    public function getAllDeal($idCliente,$idCity){
        $this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
		$this->db->select('xref_cliente_cupon.idCliente');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('xref_cliente_cupon', 'xref_cliente_cupon.idCupon = coupon.id and xref_cliente_cupon.idCliente = ' . $idCliente, "left");
        $this->db->where('coupon.status = 1');
		$this->db->where('endDate >= curdate() and iniDate <= curdate()');
		$this->db->order_by('coupon.stock',"DESC");
        return  $this->db->get()->result();
    }
    
    public function getTodayDeal($idCliente,$idCity){
	
		$this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
		$this->db->select('xref_cliente_cupon.idCliente');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('xref_cliente_cupon', 'xref_cliente_cupon.idCupon = coupon.id and xref_cliente_cupon.idCliente = ' . $idCliente, "left");
		$this->db->where('coupon.stock > 0');
        $this->db->where('coupon.status = 1');
		$this->db->where('endDate >= curdate() and iniDate <= curdate()');
        return  $this->db->get()->result();
    }
    
    public function getPartnertById($id){
        $this->db->select('name, image, banner, info, address, phone, latitude, longitude, facebook, twitter, welcomeIntro, welcomeFooter');
        $this->db->from('partner');
        $this->db->where('id', $id);
        return  $this->db->get()->result();
    }
    
    public function getAdPartner($id){
        $this->db->select('partner.name, partner.image, partner.banner, partner.info, partner.address, partner.phone, partner.latitude, partner.longitude, partner.facebook, partner.twitter');
        $this->db->select('ads.displayInfo, ads.image as displayImage');
        $this->db->from('partner');
        $this->db->join('ads', 'ads.partnerId = partner.id ');
        $this->db->where('ads.id', $id);
        $this->db->where('ads.type = 2');
        $this->db->where('ads.status = 1');
        return  $this->db->get()->result();
    }
	
	public function getDealsByPartner($id,$idCity){
		$this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->where('coupon.partnerId = ', $id);
        $this->db->where('coupon.status = 1');
		$this->db->where('endDate >= curdate() and iniDate <= curdate()');
        return  $this->db->get()->result();
	}

	public function getGallery($id,$type){
		$this->db->select('id, image');
        $this->db->from('gallery');
		if($type == 1){
			$this->db->where('idPartner', $id);
		}
		else {
			$this->db->where('idEvent', $id);
		}
        return  $this->db->get()->result();
	}
	
	public function getCouponById($id){
		 $this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->where('coupon.id = ', $id);
        $this->db->where('coupon.status > 1');
        return  $this->db->get()->result();
	}
	
	// obtenemos los deals de la cartera
	
	public function getMyDeals($idCliente,$idCity){
		$this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('xref_cliente_cupon', 'xref_cliente_cupon.idCupon = coupon.id ');
		$this->db->where('xref_cliente_cupon.idCliente = ', $idCliente);
		$this->db->where('xref_cliente_cupon.status = ', 1);
        $this->db->where('coupon.status = 1');
        return  $this->db->get()->result();
	}
	
	// se obtiene las notificaciones del usuario
	public function getNotifications($idUsuario){
		$this->db->select('notifications.id as idNotification, notifications.tipo, notifications.idRelacional, notifications.leido');
        $this->db->from('notifications');
		$this->db->where('idUsuario = ', $idUsuario);
		$this->db->order_by('notifications.fecha',"DESC");
        return  $this->db->get()->result();
	}
	
	//obtiene evento por id
	public function getEventbyId($id){
		$this->db->select('event.id, event.name, event.partnerId, event.detail, event.iniDate, event.image, event.imageFull');
        $this->db->select("if(event.partnerId is null, place.name, partner.name) as place ", false);
        $this->db->select("if(event.partnerId is null, place.address, partner.address) as address ", false);
        $this->db->select("if(event.partnerId is null, place.latitude, partner.latitude) as latitude ", false);
        $this->db->select("if(event.partnerId is null, place.longitude, partner.longitude) as longitude ", false);
        $this->db->select("if(event.partnerId is null, place.image, partner.image) as placeImage ", false);
        $this->db->select("if(event.partnerId is null, place.banner, partner.banner) as placeBanner ", false);
		$this->db->select("if(event.partnerId is null, event.placeId, event.partnerId) as  typeId", false);
        $this->db->from('event');
        $this->db->join('partner', 'event.partnerId = partner.id ', 'left');
        $this->db->join('place', 'event.placeId = place.id ', 'left');
        $this->db->where('event.status = 1');
        $this->db->where('event.id = ', $id);
        return  $this->db->get()->result();
	}
	
	// muestra si existe notificaciones no leidad
	public function getNotificationsUnRead($idUsuario){
		$this->db->select('notifications.id');
        $this->db->from('notifications');
		$this->db->where('idUsuario = ', $idUsuario);
		$this->db->where('leido = 1');
        return  $this->db->get()->result();
	}
	
	// marca la notificacion como leido
	public function notificationRead($data){
		$this->db->where('id', $data['id']);
        $this->db->update('notifications', $data);
	}
	
	// obtener la consulta de la busqueda
	public function getSearchEvent($texto){
		$this->db->select('event.id, event.name, event.partnerId, event.detail, event.iniDate, event.image, event.imageFull');
        $this->db->select("if(event.partnerId is null, place.name, partner.name) as place ", false);
        $this->db->select("if(event.partnerId is null, place.address, partner.address) as address ", false);
        $this->db->select("if(event.partnerId is null, place.latitude, partner.latitude) as latitude ", false);
        $this->db->select("if(event.partnerId is null, place.longitude, partner.longitude) as longitude ", false);
        $this->db->select("if(event.partnerId is null, place.image, partner.image) as placeImage ", false);
        $this->db->select("if(event.partnerId is null, place.banner, partner.banner) as placeBanner ", false);
		$this->db->select("if(event.partnerId is null, event.placeId, event.partnerId) as  typeId", false);
        $this->db->from('event');
        $this->db->join('partner', 'event.partnerId = partner.id ', 'left');
        $this->db->join('place', 'event.placeId = place.id ', 'left');
        $this->db->where('event.status = 1');
        $this->db->where('event.iniDate >= curdate()');
		$this->db->where('(event.name LIKE \'%'.$texto.'%\' OR event.detail LIKE \'%'.$texto.'%\' OR partner.name LIKE \'%'.$texto.'%\' 
		OR place.name LIKE \'%' . $texto . '%\' OR partner.address LIKE \'%'.$texto.'%\' OR place.address LIKE \'%'.$texto.'%\')', 
		NULL); 
        return  $this->db->get()->result();
	}
	
	public function getSearchCoupon($texto,$idCliente){
		$this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
		$this->db->select('xref_cliente_cupon.idCliente');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('xref_cliente_cupon', 'xref_cliente_cupon.idCupon = coupon.id and xref_cliente_cupon.idCliente = ' . $idCliente, "left");
        $this->db->where('coupon.status = 1');
		$this->db->where('endDate >= curdate() and iniDate <= curdate()');
		$this->db->where('(coupon.name LIKE \'%'.$texto.'%\' OR coupon.detail LIKE \'%'.$texto.'%\' OR coupon.validity LIKE \'%'.$texto.'%\' 
		OR partner.name LIKE \'%' . $texto . '%\' OR partner.address LIKE \'%'.$texto.'%\' OR partner.info LIKE \'%'.$texto.'%\')', 
		NULL); 
        return  $this->db->get()->result();
	}
	
	// obtiene 
	
	public function getCouponDownload($idUser,$idCoupon){
		$this->db->select('xref_cliente_cupon.code, xref_cliente_cupon.status');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('(status = 1 OR status = 2)');
		$this->db->where('xref_cliente_cupon.idCliente = ', $idUser);
		$this->db->where('xref_cliente_cupon.idCupon = ', $idCoupon);
		return  $this->db->get()->result();
	}
	
	// obtiene las ciudades
	public function getCity(){
		$this->db->select('idCity,name');
		$this->db->from('city');
		return  $this->db->get()->result();
	}
	
	// obtiene el nombre de la ciudad
	public function getCityById($idCity){
		$this->db->select('name');
		$this->db->from('city');
		$this->db->where('idCity = ', $idCity);
		return  $this->db->get()->result();
	}
	
	// obtiene los eventos filtados
	public function getFilterEvent($idFilter, $idCity){
		$this->db->select('event.id, event.name, event.partnerId, event.detail, event.iniDate, event.image, event.imageFull');
        $this->db->select("if(event.partnerId is null, place.name, partner.name) as place ", false);
        $this->db->select("if(event.partnerId is null, place.address, partner.address) as address ", false);
        $this->db->select("if(event.partnerId is null, place.latitude, partner.latitude) as latitude ", false);
        $this->db->select("if(event.partnerId is null, place.longitude, partner.longitude) as longitude ", false);
        $this->db->select("if(event.partnerId is null, place.image, partner.image) as placeImage ", false);
        $this->db->select("if(event.partnerId is null, place.banner, partner.banner) as placeBanner ", false);
		$this->db->select("if(event.partnerId is null, event.placeId, event.partnerId) as  typeId", false);
        $this->db->from('event');
        $this->db->join('partner', 'event.partnerId = partner.id ', 'left');
        $this->db->join('place', 'event.placeId = place.id ', 'left');
		$this->db->join('xref_event_filter', 'xref_event_filter.idEvent = event.id ');
		$this->db->where('xref_event_filter.idFilter = ', $idFilter);
        $this->db->where('event.status = 1');
        $this->db->where('event.iniDate >= curdate()');
		$this->db->order_by('event.iniDate',"ASC");
        return  $this->db->get()->result();
	}
	
	// obtiene los cupones filtados
	public function getFilterCoupon($idCliente, $idFilter, $idCity){
		$this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
		$this->db->select('xref_cliente_cupon.idCliente');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('xref_cliente_cupon', 'xref_cliente_cupon.idCupon = coupon.id and xref_cliente_cupon.idCliente = ' . $idCliente, "left");
		$this->db->join('xref_coupon_filter', 'xref_coupon_filter.idCoupon = coupon.id ');
		$this->db->where('xref_coupon_filter.idFilter = ', $idFilter);
        $this->db->where('coupon.status = 1');
		$this->db->where('endDate >= curdate() and iniDate <= curdate()');
        return  $this->db->get()->result();
	}
	
	// obtiene los filtros disponibles de eventos
	public function getFilterActiveEvent(){
		$this->db->select('DISTINCT(idFilter)');
		$this->db->from('xref_event_filter');
		$this->db->join('event', 'xref_event_filter.idEvent = event.id ');
		$this->db->where('event.iniDate >= curdate()');
		$this->db->order_by("idFilter", "asc");
		return  $this->db->get()->result();
	}
	
	// obtiene los filtros disponibles de deals
	public function getFilterActiveDeals(){
		$this->db->select('DISTINCT(idFilter)');
		$this->db->from('xref_coupon_filter');
		$this->db->join('coupon', 'xref_coupon_filter.idCoupon = coupon.id and coupon.status = 1');
		$this->db->where('endDate >= curdate() and iniDate <= curdate()');
		$this->db->order_by("idFilter", "asc"); 
		return  $this->db->get()->result();
	}
	
	// obtiene los filtros disponibles de deals
	public function getBeacons(){
		$this->db->from('ads');
        	$this->db->where('status = 1');
		return  $this->db->get()->result();
	}
	
	// obtiene los deals redimidos por un mes
	public function getDealsRedimir($idCliente){
	
		$mes = date("m");
		$anio = date("Y");
		if($mes == 12){
			$anio = $anio - 1;
		}
		$mes = $mes - 1;
		if($mes < 10){
			$mes = "0" . $mes;
		}
		$fecha =  $anio . "-" . $mes . "-" . date("d");
	
		$this->db->select('coupon.id, coupon.name, coupon.detail, coupon.image');
        $this->db->select('coupon.total, coupon.stock, coupon.clauses, coupon.validity');
        $this->db->select('coupon.partnerId, partner.name as partner, partner.address');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('xref_cliente_cupon', 'xref_cliente_cupon.idCupon = coupon.id ');
		$this->db->where('xref_cliente_cupon.idCliente = ', $idCliente);
		$this->db->where('xref_cliente_cupon.status = ', 2);
        $this->db->where('xref_cliente_cupon.redemptionDate > ', $fecha);
		$this->db->order_by('xref_cliente_cupon.redemptionDate',"DESC");
        return  $this->db->get()->result();
	}
	
	/**
     * Actualiza el registro
     */
    public function redemptionDeal($data){
        $this->db->where('code', $data['code']);
        $this->db->update('xref_cliente_cupon', $data);
    }
	
	/**
	 * Obtiene el idUser del amigo
	 */
	public function getIdByIdFriend($idFriend){
		$this->db->select('user.id');
		$this->db->from('user');
		$this->db->where('user.fbId = ', $idFriend);
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene el idUser por email
	 */
	public function getIdByEmailFriend($email){
		$this->db->select('user.id');
		$this->db->from('user');
		$this->db->where('user.email = ', $email);
		return  $this->db->get()->result();
	}
	
	/**
	 * busca si existe un usuario con ese deals
	 */
	public function getDealsShare($idUser,$idCoupon){
		$this->db->select('xref_cliente_cupon.code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.idCliente = ', $idUser);
		$this->db->where('xref_cliente_cupon.idCupon = ', $idCoupon);
		return  $this->db->get()->result();
	}
	 
	/**
	 * inserta el deal compartido
	 */
	public function insertDealShare($compartido,$wallet,$notificacion){
		$this->db->insert('xref_cliente_cupon', $compartido);
		$this->db->insert('xref_cliente_cupon', $wallet);
		$this->db->insert('notifications', $notificacion);
	}
	
	/**
	 * Obtiene los datos del usuario
	 */
	public function getUserInfo($id){
        $this->db->from('user');
        $this->db->where('user.id = ',$id);
        return $this->db->get()->result();
    }
	
}
//end model



