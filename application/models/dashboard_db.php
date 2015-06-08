<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class dashboard_db extends CI_MODEL
{
 
    public function __construct(){
        parent::__construct();
    }
 
    /**
     * Obtiene el total de deals
     */
	public function getDeals(){
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el total de deals de la semana
     */
	public function getDealsWeek(){
		$f=date("Y-m-d");
		$fCurrrent = date("Y-m-d", strtotime("$f   -7 day"));
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('date >= ', $fCurrrent);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el registro del catalogo
     */
	public function getDealsRedeemed(){
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.status = ', 2);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene los deals redimidos de la semana
     */
	public function getDealsRedeemedWeek(){
		$f=date("Y-m-d");
		$fCurrrent = date("Y-m-d", strtotime("$f   -7 day"));
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.status = ', 2);
		$this->db->where('redemptionDate >= ', $fCurrrent);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene los deals por fecha
     */
	public function getDownloadByDate($iniDate,$endDate){
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('date >=  ', $iniDate);
		$this->db->where('date <=  ', $endDate);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el total de deals redimidos por fecha
     */
	public function getRedimirByDate($iniDate,$endDate){
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->where('xref_cliente_cupon.status = ', 2);
		$this->db->where('redemptionDate >=  ', $iniDate);
		$this->db->where('redemptionDate <=  ', $endDate);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	//SELECT * FROM `xref_cliente_cupon` INNER JOIN coupon on xref_cliente_cupon.idCupon = coupon.id and coupon.partnerId = 5; 
	
	/**
     * Obtiene el total de deals por partner
     */
	public function getAllDealsPartner($idPartner){
		$this->db->select('xref_cliente_cupon.code');
		$this->db->from('xref_cliente_cupon');
		$this->db->join('coupon', 'xref_cliente_cupon.idCupon = coupon.id and coupon.partnerId = ' . $idPartner);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el total de deals redimidos por comercio
     */
	public function getAllRedimirPartner($idPartner){
		$this->db->select('xref_cliente_cupon.code');
		$this->db->from('xref_cliente_cupon');
		$this->db->join('coupon', 'xref_cliente_cupon.idCupon = coupon.id and coupon.partnerId = ' . $idPartner);
		$this->db->where('xref_cliente_cupon.status = ', 2);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el total de deals redimidos por comercio y fecha
     */
	public function getDealsByPartnerAndDate($idPartner,$iniDate,$endDate){
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->join('coupon', 'xref_cliente_cupon.idCupon = coupon.id and coupon.partnerId = ' . $idPartner);
		$this->db->where('date >=  ', $iniDate);
		$this->db->where('date <=  ', $endDate);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}
	
	/**
     * Obtiene el total de deals redimidos por comercio y fecha
     */
	public function getRedimirByPartnerAndDate($idPartner,$iniDate,$endDate){
		$this->db->select('code');
		$this->db->from('xref_cliente_cupon');
		$this->db->join('coupon', 'xref_cliente_cupon.idCupon = coupon.id and coupon.partnerId = ' . $idPartner);
		$this->db->where('xref_cliente_cupon.status = ', 2);
		$this->db->where('redemptionDate >=  ', $iniDate);
		$this->db->where('redemptionDate <=  ', $endDate);
		$this->db->where('date >=  ', $iniDate);
		$this->db->where('date <=  ', $endDate);
		$this->db->where('xref_cliente_cupon.idCliente != 5 and xref_cliente_cupon.idCliente != 6 and xref_cliente_cupon.idCliente != 7');
		$this->db->where('xref_cliente_cupon.idCliente != 8 and xref_cliente_cupon.idCliente != 10 and xref_cliente_cupon.idCliente != 17');
		return  $this->db->get()->result();
	}

}
//end model