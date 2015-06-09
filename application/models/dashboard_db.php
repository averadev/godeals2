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
	public function getActivesAll(){
        $query = $this->db->query("select count(*) as total, DATE_ADD(CURDATE(), INTERVAL 0 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -6 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL 0 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -7 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -13 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL -7 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -14 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -20 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL -14 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -21 DAY)  as fecha ".
                "from init_app ".
                "where fecha >= DATE_ADD(CURDATE(), INTERVAL -27 DAY) and fecha <= DATE_ADD(CURDATE(), INTERVAL -21 DAY) ".
                "union ".
                "select count(*) as total, DATE_ADD(CURDATE(), INTERVAL -28 DAY)  as fecha ".
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
        $this->db->select('partner.name, count(*) as total');
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
        $this->db->group_by('partner.id'); 
		$this->db->order_by("total", "desc");
		return  $this->db->get()->result();
	}
	
	/**
	 * Obtiene los deals descargados por fecha
	 */
	public function getDealsRedimidosDate($iniDate,$endDate,$type){
        $this->db->select('partner.name, count(*) as total');
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
        $this->db->group_by('partner.id'); 
		$this->db->order_by("total", "desc");
		return  $this->db->get()->result();
	}

}
//end model