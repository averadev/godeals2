<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class dashboard_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene el total de deals
     */
	public function getDealsDescargados(){
        $this->db->select('partner.name, count(*) as total');
        $this->db->from('partner');
        $this->db->join('coupon', 'partner.id = coupon.partnerId', 'inner');
        $this->db->join('xref_cliente_cupon', 'coupon.id = xref_cliente_cupon.idCupon', 'inner');
        $this->db->where('partner.status = 1');
        $this->db->group_by('partner.id'); 
		$this->db->order_by("total", "desc");
		return  $this->db->get()->result();
	}
 
    /**
     * Obtiene el total de deals
     */
	public function getDealsRedimidos(){
        $this->db->select('partner.name, count(*) as total');
        $this->db->from('partner');
        $this->db->join('coupon', 'partner.id = coupon.partnerId', 'inner');
        $this->db->join('xref_cliente_cupon', 'coupon.id = xref_cliente_cupon.idCupon', 'inner');
        $this->db->where('partner.status = 1');
        $this->db->where('xref_cliente_cupon.status = 2');
        $this->db->group_by('partner.id'); 
		$this->db->order_by("total", "desc");
		return  $this->db->get()->result();
	}
    
    /**
     * Obtiene el total de deals
     */
	public function getDealsActivos(){
        $this->db->select('count(*)  as total');
        $this->db->from('coupon');
        $this->db->where('status = 1');
        $this->db->where('iniDate <= curdate()');
        $this->db->where('endDate >= curdate()');
		return  $this->db->get()->result();
	}
    
    /**
     * Obtiene el total de deals
     */
	public function getTotalUser(){
        $this->db->select('count(*)  as total');
        $this->db->from('user');
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los usuarios nuevos
	 */
	public function getUserNew(){
        $this->db->select('count(*)  as total');
        $this->db->from('user');
		$this->db->where('date >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)');
		$this->db->where('date <= CURDATE()');
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los usuarios activos
	 */
	public function getUsersActives(){
        $this->db->select('COUNT(DISTINCT idUSer)  as total');
        $this->db->from('init_app');
		$this->db->where('fecha >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)');
		$this->db->where('fecha <= CURDATE()');
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los deals descargados
	 */
	public function getDealsDownloads(){
        $this->db->select('COUNT(*)  as total');
        $this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.status = 1');
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los deals redimidos
	 */
	public function getDealsRedeemed(){
        $this->db->select('COUNT(*)  as total');
        $this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.status = 2');
		return  $this->db->get()->result();
	}
    
    /**
     * Obtiene el total de deals descargados
     */
	public function getDownloadAll(){
        $query = $this->db->query("select count(*) as total, DATE_ADD(CURDATE(), INTERVAL 0 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -6 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL 0 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -7 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -13 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -14 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -20 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -14 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -21 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -27 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -21 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -28 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -34 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -28 DAY) ".
                "order by fecha asc");
        
		return  $query->result();
	}
    
    /**
     * Obtiene el total de deals descargados
     */
	public function getRedimidosAll(){
        $query = $this->db->query("select count(*) as total, DATE_ADD(CURDATE(), INTERVAL 0 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where redemptionDate >= DATE_ADD(CURDATE(), INTERVAL -6 DAY) and redemptionDate <= DATE_ADD(CURDATE(), INTERVAL 0 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -7 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where redemptionDate >= DATE_ADD(CURDATE(), INTERVAL -13 DAY) and redemptionDate <= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -14 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where redemptionDate >= DATE_ADD(CURDATE(), INTERVAL -20 DAY) and redemptionDate <= DATE_ADD(CURDATE(), INTERVAL -14 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -21 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where redemptionDate >= DATE_ADD(CURDATE(), INTERVAL -27 DAY) and redemptionDate <= DATE_ADD(CURDATE(), INTERVAL -21 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -28 DAY)  as fecha ".
                "from xref_cliente_cupon ".
                "where redemptionDate >= DATE_ADD(CURDATE(), INTERVAL -34 DAY) and redemptionDate <= DATE_ADD(CURDATE(), INTERVAL -28 DAY) ".
                "order by fecha asc");
        
		return  $query->result();
	}
    
    /**
     * Obtiene el total de deals descargados
     */
	public function getNewUsuariosAll(){
        $query = $this->db->query("select count(*) as total, DATE_ADD(CURDATE(), INTERVAL 0 DAY)  as fecha ".
                "from user ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -6 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL 0 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -7 DAY)  as fecha ".
                "from user ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -13 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -14 DAY)  as fecha ".
                "from user ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -20 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -14 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -21 DAY)  as fecha ".
                "from user ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -27 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -21 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -28 DAY)  as fecha ".
                "from user ".
                "where date >= DATE_ADD(CURDATE(), INTERVAL -34 DAY) and date <= DATE_ADD(CURDATE(), INTERVAL -28 DAY) ".
                "order by fecha asc");
        
		return  $query->result();
	}
    
    /**
     * Obtiene el total de deals descargados
     */
	 /* $this->db->select('COUNT(DISTINCT idUSer)  as total');
        $this->db->from('init_app');
		$this->db->where('fecha >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)');
		$this->db->where('fecha <= CURDATE()');
		return  $this->db->get()->result();*/
	public function getActivesAll(){
        $query = $this->db->query("select COUNT(DISTINCT idUSer) as total, DATE_ADD(CURDATE(), INTERVAL 0 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -6 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL 0 DAY) ".
                "union ".
                "select COUNT(DISTINCT idUSer) as total, DATE_ADD(CURDATE(), INTERVAL -7 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -13 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ".
                "union ".
                "select COUNT(DISTINCT idUSer) as total, DATE_ADD(CURDATE(), INTERVAL -14 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -20 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL -14 DAY) ".
                "union ".
                "select COUNT(DISTINCT idUSer) as total, DATE_ADD(CURDATE(), INTERVAL -21 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -27 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL -21 DAY) ".
                "union ".
                "select COUNT(DISTINCT idUSer) as total, DATE_ADD(CURDATE(), INTERVAL -28 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -34 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL -28 DAY) ".
                "order by fecha asc");
        
		return  $query->result();
	}
	
	////////
	
	/**
	 * Obtiene los deals descargados por fecha
	 */
	public function getDealsDescargadosDate($iniDate,$endDate,$type){
        $this->db->select('partner.name, count(*) as total, coupon.name as descripcion,coupon.stock');
        $this->db->from('partner');
        $this->db->join('coupon', 'partner.id = coupon.partnerId', 'inner');
        $this->db->join('xref_cliente_cupon', 'coupon.id = xref_cliente_cupon.idCupon', 'inner');
        $this->db->where('partner.status = 1');
		if($type == 1){
			$this->db->where('xref_cliente_cupon.date >= ',$iniDate);
			$this->db->where('xref_cliente_cupon.date <= ',$endDate);
		}else if($type == 0){	
			$this->db->where('xref_cliente_cupon.date >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)');
			$this->db->where('xref_cliente_cupon.date <= CURDATE()');
		}
        $this->db->group_by('coupon.id'); 
		$this->db->order_by("partner.name", "ASC");
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los deals descargados por fecha
	 */
	public function getDealsRedimidosDate($iniDate,$endDate,$type){
        $this->db->select('partner.name, count(*) as total, coupon.name as descripcion,coupon.stock');
        $this->db->from('partner');
        $this->db->join('coupon', 'partner.id = coupon.partnerId', 'inner');
        $this->db->join('xref_cliente_cupon', 'coupon.id = xref_cliente_cupon.idCupon', 'inner');
        $this->db->where('partner.status = 1');
		if($type == 1){
			$this->db->where('xref_cliente_cupon.redemptionDate >= ',$iniDate);
			$this->db->where('xref_cliente_cupon.redemptionDate <= ',$endDate);
		}else if($type == 0){	
			$this->db->where('xref_cliente_cupon.redemptionDate >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)');
			$this->db->where('xref_cliente_cupon.redemptionDate <= CURDATE()');
		}
        $this->db->group_by('coupon.id'); 
		$this->db->order_by("partner.name", "ASC");
		return  $this->db->get()->result();
	}
	
	 /**
     * Obtiene los datos de deals activos
     */
	public function getInfoDealsActivos(){
        $this->db->select('coupon.name, coupon.total, coupon.stock');
		$this->db->select('partner.name as partnerName');
        $this->db->from('coupon');
		$this->db->join('partner', 'partner.id = coupon.partnerId', 'inner');
        $this->db->where('coupon.status = 1');
        $this->db->where('coupon.iniDate <= curdate()');
        $this->db->where('coupon.endDate >= curdate()');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene la informacion de los usuarios de godeals
     */
	public function getInfoTotalUser(){
        $this->db->select('email, name');
		$this->db->select('(select init_app.fecha from init_app where init_app.idUSer = `user`.id ORDER BY fecha desc limit 1) as lastDate');
		//(select init_app.fecha from init_app where init_app.idUSer = `user`.id ORDER BY fecha desc limit 1) as fecha
        $this->db->from('user');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene la informacion de los nuevos usuarios de godeals
     */
	public function getInfoNewUser(){
        $this->db->select('email, name');
		$this->db->select('(select init_app.fecha from init_app where init_app.idUSer = `user`.id ORDER BY fecha desc limit 1) as lastDate');
		//(select init_app.fecha from init_app where init_app.idUSer = `user`.id ORDER BY fecha desc limit 1) as fecha
        $this->db->from('user');
		$this->db->where('user.date >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)');
		$this->db->where('user.date <= CURDATE()');
		$this->db->order_by('user.date' , 'desc');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene la informacion de los nuevos usuarios de godeals
     */
	public function getInfoActiveUser(){
       
		$query = $this->db->query("SELECT DISTINCT `user`.id, `user`.email, `user`.`name`, 
			(select init_app.fecha from init_app where init_app.idUSer = `user`.id
			and init_app.fecha >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) and init_app.fecha <= CURDATE()
 			ORDER BY fecha desc limit 1) as lastDate 
			FROM `user` INNER JOIN init_app ON init_app.idUser = `user`.id 
			where init_app.fecha >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) and init_app.fecha <= CURDATE() 
			ORDER BY lastDate DESC");
		
		return  $query->result();
		
	}
	
	/**
	 * Obtiene la informacion de los usuarios de godeals por busqueda
	 */
	public function getInfoTotalUserBySearch($dato,$column,$order){
		$this->db->select('email, name');
		$this->db->select('(select init_app.fecha from init_app where init_app.idUSer = `user`.id ORDER BY fecha desc limit 1) as lastDate');
        $this->db->from('user');
		$this->db->where('(email LIKE \'%'.$dato.'%\' OR name LIKE \'%'.$dato.'%\')', NULL); 
		$this->db->order_by($column , $order);
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene la informacion de los nuevos usuarios de godeals por busqueda
	 */
	public function getInfoNewUserBySearch($dato,$column,$order){
		$this->db->select('email, name');
		$this->db->select('(select init_app.fecha from init_app where init_app.idUSer = `user`.id ORDER BY fecha desc limit 1) as lastDate');
        $this->db->from('user');
		$this->db->where('user.date >= DATE_ADD(CURDATE(), INTERVAL -7 DAY)');
		$this->db->where('user.date <= CURDATE()');
		$this->db->where('(email LIKE \'%'.$dato.'%\' OR name LIKE \'%'.$dato.'%\')', NULL); 
		//$this->db->order_by($column , $order);
		$this->db->order_by('user.date' , 'desc');
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene la informacion de los usuarios activos de godeals por busqueda
	 */
	public function getInfoActiveUserBySearch($dato,$column,$order){
		$query = $this->db->query("SELECT DISTINCT `user`.id, `user`.email, `user`.`name`, 
			(select init_app.fecha from init_app where init_app.idUSer = `user`.id
			and init_app.fecha >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) and init_app.fecha <= CURDATE()
 			ORDER BY fecha desc limit 1) as lastDate 
			FROM `user` INNER JOIN init_app ON init_app.idUser = `user`.id 
			where init_app.fecha >= DATE_ADD(CURDATE(), INTERVAL -7 DAY) and init_app.fecha <= CURDATE() 
			and (email LIKE \"%".$dato."%\" OR name LIKE \"%".$dato."%\")
			ORDER BY lastDate DESC");
			
		return  $query->result();
	}
	
	

}
//end model