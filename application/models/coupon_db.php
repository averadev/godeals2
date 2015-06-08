<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class coupon_db extends CI_MODEL
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
	
	public function deleteCoupon($data){
		$this->db->where('id', $data['id']);
		$this->db->update('coupon', $data);
    }
	
	/////////////actual////////////////
	
	//obtiene todos los deals activos
	public function getAllActive(){
        $this->db->select('coupon.id, coupon.name, coupon.partnerId, coupon.total,coupon.status');
        $this->db->select('partner.name as partnerName');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
       // $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('(coupon.status = 1 || coupon.status = -1)');
		$this->db->order_by("id", "asc");
        return  $this->db->get()->result();
    }
	
	/**
	* obtiene la descripcion, clientes y ubicacion de la busqueda relacionada
	**/
	public function getallSearch($dato,$column,$order){
		$this->db->select ('coupon.id, coupon.name, coupon.partnerId, coupon.total,coupon.status');
		$this->db->select ('partner.name as partnerName');
        $this->db->from('coupon');
		$this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->where('(coupon.status = 1 || coupon.status = -1)');
		$this->db->where('(coupon.name LIKE \'%'.$dato.'%\' OR partner.name LIKE \'%'.$dato.'%\' 
		OR coupon.total LIKE \'%' . $dato . '%\')', NULL); 
		$this->db->order_by($column , $order);
        return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los datos del deals del comercio por busqueda o paginador
	 */
	public function paginadorDealsByPartner($dato,$column,$order,$partnerId){
		$this->db->select('coupon.id, coupon.name');
        $this->db->from('coupon');
        $this->db->where('coupon.partnerId = ', $partnerId);
        $this->db->where('(coupon.status = 1 || coupon.status = -1 || coupon.status = -2)');
		$this->db->where('(coupon.name LIKE \'%'.$dato.'%\')', NULL);
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
        $this->db->select('coupon.id, coupon.name, coupon.partnerId, coupon.cityId, coupon.image, coupon.detail,');
		$this->db->select('coupon.clauses, coupon.validity, coupon.total, coupon.stock, coupon.iniDate, coupon.endDate');
		$this->db->select('coupon.status');
        $this->db->select('partner.name as partnerName');
		$this->db->select('city.name as cityName');
        $this->db->from('coupon');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
		$this->db->join('city', 'coupon.cityId = city.idCity ');
        $this->db->where('coupon.id = ', $id);
        $this->db->where('(coupon.status = 1 || coupon.status = -1 || coupon.status = -2)');
        return  $this->db->get()->result();
    }
	
	//obtiene los filtros del deal
	public function getFilterOfDeals($id){
		$this->db->select('xref_coupon_filter.idFilter');	
		$this->db->from('xref_coupon_filter');
		$this->db->where('xref_coupon_filter.idCoupon = ', $id);
		return $this->db->get()->result();
	}
	
	//obtiene las descargas de un cupon
	public function checkDownloads($idCoupon){
		$this->db->select('xref_cliente_cupon.code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.idCupon = ', $idCoupon);
		return $this->db->get()->result();
	}
	
	/**
	 * Obtiene los deals del comercio
	 */
	public function getDealsOfRewardByParner($partnerId){
		$this->db->select('coupon.id, coupon.name');
        $this->db->from('coupon');
        $this->db->where('coupon.partnerId = ', $partnerId);
        $this->db->where('(coupon.status = 1 || coupon.status = -1 || coupon.status = -2)');
        return  $this->db->get()->result();
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
	
	//actualiza los datos del deals
	public function updateCoupon($data,$delete,$filter){
		$this->db->where('id', $data['id']);
		$this->db->update('coupon', $data);
		$this->db->delete('xref_coupon_filter',$delete);
		if(count($filter)>0){
			$this->db->insert_batch('xref_coupon_filter', $filter);
		}
    }

}
//end model