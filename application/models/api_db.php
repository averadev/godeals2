<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class api_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getEventFav($idApp){
        $this->db->select("event.id, event.name as title, event.info, event.eventTypeId, event.place as subtitle1, city.name as subtitle2, event.image, event.date, event.fav");
        $this->db->select ("date_format(event.date, '%l:%i%p') as time", false);
        $this->db->select(" (select count(*) from xref_user_coupon_fav where userId = ".$idApp." and  typeId = 2 and couponId = event.id) as isFav, event.latitude, event.longitude ");
        $this->db->from('event');
        $this->db->join('city', 'event.idCity = city.id ');
        $this->db->where('event.status = 1');
        $this->db->where('event.fav = 1');
        $this->db->where('event.date >= curdate()');
        $this->db->order_by("event.date", "asc");
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getEvent($idApp, $isToFav){
        $this->db->select("event.id, event.name as title, event.info, event.eventTypeId, event.place as subtitle1, city.name as subtitle2, event.image, event.date, event.fav");
        $this->db->select ("date_format(event.date, '%l:%i%p') as time", false);
        $this->db->select(" (select count(*) from xref_user_coupon_fav where userId = ".$idApp." and  typeId = 2 and couponId = event.id) as isFav, event.latitude, event.longitude ");
        $this->db->from('event');
        $this->db->join('city', 'event.idCity = city.id ');
        if ($isToFav){ 
            $this->db->join('xref_user_coupon_fav', 'event.id = xref_user_coupon_fav.couponId and typeId = 2');
            $this->db->where('userId', $idApp);
        }
        $this->db->where('event.status = 1');
        $this->db->where('event.date >= curdate()');
        $this->db->order_by("event.date", "asc");
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getEventNoFav($idApp){
        $this->db->select("event.id, event.name as title, event.info, event.eventTypeId, event.place as subtitle1, city.name as subtitle2, event.image, event.date, event.fav");
        $this->db->select ("date_format(event.date, '%l:%i%p') as time", false);
        $this->db->select(" (select count(*) from xref_user_coupon_fav where userId = ".$idApp." and  typeId = 2 and couponId = event.id) as isFav, event.latitude, event.longitude ");
        $this->db->from('event');
        $this->db->join('city', 'event.idCity = city.id ');
        $this->db->where('event.status = 1');
        $this->db->where('event.fav = 0');
        $this->db->where('event.date >= curdate()');
        $this->db->order_by("event.date", "asc");
        return  $this->db->get()->result();
    }
 
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getPlace($idApp, $isToFav){
        $this->db->select('place.id, place.name as title, city.name as subtitle1, place.image, place.txtMax, place.latitude, place.longitude');
        $this->db->select(" (select count(*) from xref_user_coupon_fav where userId = ".$idApp." and  typeId = 5 and couponId = place.id) as isFav ");
        $this->db->from('place');
        $this->db->join('city', 'place.cityId = city.id ');
        if ($isToFav){ 
            $this->db->join('xref_user_coupon_fav', 'place.id = xref_user_coupon_fav.couponId and typeId = 5');
            $this->db->where('userId', $idApp);
        }
        $this->db->where('place.status = 1');
        $this->db->order_by("place.id", "desc");
        return  $this->db->get()->result();
    }
 
    /**
     * Obtiene el registro del catalogo
     */
    public function getSporttv($idApp, $isToFav){
        $this->db->select ('sporttv.id, sporttv.name as title, sporttv.torneo as subtitle1, sporttv.image, date(sporttv.date) as date');
        $this->db->select ("date_format(sporttv.date, '%l:%i%p') as time", false);
        $this->db->select(" (select count(*) from xref_user_coupon_fav where userId = ".$idApp." and  typeId = 6 and couponId = sporttv.id) as isFav ");
        $this->db->from('sporttv');
        $this->db->join('sporttv_type', 'sporttv.sporttvTypeId = sporttv_type.id');
        if ($isToFav){ 
            $this->db->join('xref_user_coupon_fav', 'sporttv.id = xref_user_coupon_fav.couponId and typeId = 6');
            $this->db->where('xref_user_coupon_fav.userId', $idApp);
        }
        $this->db->where('sporttv.status = 1');
        $this->db->where('sporttv_type.status = 1');
        $this->db->order_by("sporttv.date");
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getCoupon($idApp, $isToFav, $type){
        $this->db->select ('coupon.id, coupon.image, coupon.detail, coupon.description as title');
        $this->db->select ('city.name as cityName, coupon.clauses, coupon.validity');
        $this->db->select ('partner.name as partnerName, partner.latitude, partner.longitude');
        $this->db->select(" (select count(*) from xref_user_coupon_fav where userId = ".$idApp." and  ( typeId = 3 or typeId = 4 ) and couponId = coupon.id) as isFav ");
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        if ($isToFav){ 
            $this->db->join('xref_user_coupon_fav', 'coupon.id = xref_user_coupon_fav.couponId and ( typeId = 3 or typeId = 4 )');
            $this->db->where('userId', $idApp);
        }
        $this->db->where('coupon.status = 1');
        $this->db->where('catalog.status = 1');
        if ($type > 0){
            $this->db->where('catalog.type', $type);
        }
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('coupon.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getCouponSubType($idApp, $subtype){
        $this->db->select ('coupon.id, coupon.image, coupon.detail, coupon.description as title');
        $this->db->select ('city.name as cityName, coupon.clauses, coupon.validity');
        $this->db->select ('partner.name as partnerName, partner.latitude, partner.longitude');
        $this->db->select(" (select count(*) from xref_user_coupon_fav where userId = ".$idApp." and  ( typeId = 3 or typeId = 4 ) and couponId = coupon.id) as isFav ");
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->join('partner', 'coupon.partnerId = partner.id ');
        $this->db->join('city', 'coupon.cityId = city.id ');
        $this->db->where('coupon.status = 1');
        $this->db->where('catalog.status = 1');
        $this->db->where('catalog.id', $subtype);
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('coupon.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getSubmenu($type){
        $this->db->select ('catalog.id, catalog.name');
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->where('coupon.status = 1');
        $this->db->where('catalog.status = 1');
        $this->db->where('catalog.type', $type);
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('catalog.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getServices(){
        $this->db->select ('map_service.name, map_category.id as categoryId, map_category.name as category, map_service.phone, map_service.latitude, map_service.longitude');
        $this->db->from('map_service');
        $this->db->join('map_category', 'map_service.idCatMap = map_category.id');
        $this->db->where('map_category.status = 1');
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getDirectoryType(){
        $this->db->select ('id, name');
        $this->db->from('directory_type');
        $this->db->where('status = 1');
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getCouponType($type){
        $this->db->select ('catalog.id, catalog.name');
        $this->db->from('coupon');
        $this->db->join('xref_coupon_catalog', 'xref_coupon_catalog.couponId = coupon.id');
        $this->db->join('catalog', 'catalog.id = xref_coupon_catalog.catalogId ');
        $this->db->where('coupon.status = 1');
        $this->db->where('catalog.status = 1');
        $this->db->where('catalog.type', $type);
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
        $this->db->group_by('catalog.id'); 
        return  $this->db->get()->result();
    }
    
    /**
     * Obtiene todos los registros activos del catalogo
     */
    public function getDirectory(){
        $this->db->from('directory');
        $this->db->where('status = 1');
        $this->db->order_by("name");
        return  $this->db->get()->result();
    }
    
    
	 /**
	* insert un registro
	*/
	public function insertFav($data){
		$this->db->insert('xref_user_coupon_fav', $data);
	}
        
	/*
	*	Elimina el registro
	*/
    public function removeFav($data){
        $this->db->where($data);
        $this->db->delete('xref_user_coupon_fav');
    }
	
	/*
	*	alfredo chi
	*/
    
    public function getEventApp(){
      $this->db->select('event.id,event.name,event.image,event.date,event.endDate,event.word,event.place,event.info');
      $this->db->select('city.name as cityName');
      $this->db->from('event');
      $this->db->join('city','city.id = event.idCity');
      $this->db->where('event.date > "2014-12-23"');
      $this->db->order_by('date asc'); 
      $this->db->limit(3, 0);
      return  $this->db->get()->result();
     }

     public function getAllEvent(){
      $this->db->select('event.id,event.name,event.image,event.date,event.endDate,event.word,event.place,event.info');
      $this->db->select('city.name as cityName');
      $this->db->from('event');
      $this->db->join('city','city.id = event.idCity');
      $this->db->where('event.date > "2014-12-23"');
      $this->db->order_by('date asc');
      return  $this->db->get()->result();
     }

     /*
     ** obtener los cupones 
     */

     public function getCouponApp(){
      $this->db->select('coupon.id,coupon.description,coupon.image,coupon.iniDate,coupon.endDate');
      $this->db->select('coupon.id as idCoupon,coupon.clauses, coupon.detail, coupon.validity');
      $this->db->select('city.name as nameCity');
      $this->db->select('partner.name as namePartner, partner.address, partner.id as idPartner');
      $this->db->from('coupon');
      $this->db->join('city','city.id = coupon.cityId');
      $this->db->join('partner','partner.id = coupon.partnerId');
      $this->db->where('coupon.iniDate > "2014-12-23"');
      $this->db->order_by('iniDate asc'); 
      $this->db->limit(3, 0);
      return  $this->db->get()->result();
     }

     public function getAllCoupon(){
      $this->db->select('coupon.id,coupon.description,coupon.image,coupon.iniDate,coupon.endDate');
      $this->db->select('coupon.id as idCoupon,coupon.clauses, coupon.detail, coupon.validity');
      $this->db->select('city.name as nameCity');
      $this->db->select('partner.name as namePartner, partner.address, partner.id as idPartner');
      $this->db->from('coupon');
      $this->db->join('city','city.id = coupon.cityId');
      $this->db->join('partner','partner.id = coupon.partnerId');
      $this->db->where('coupon.iniDate > "2014-12-23"');
      $this->db->order_by('iniDate asc');
      return  $this->db->get()->result();
     }
	

}
//end model