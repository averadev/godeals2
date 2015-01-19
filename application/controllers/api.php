<?php
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Api extends REST_Controller {
/**
 * The Saving coupon
 * Author: Alberto Vera Espitia
 * GeekBucket 2014
 *
 */

	public function __construct() {
        parent::__construct();
        $this->load->database('default');
        $this->load->model('api_db');
    }

	public function index_get()
    {
        $this->load->view('web/vwApi');
    }

    
	/***
	*	obtener los cupones
	*	alfredo chi
	*/
	
	public function getEvent_get(){
        $items = $this->api_db->getEventApp();
  
        foreach ($items as $item):
            // Add new vars
            $item->partner = "El Fish Fritanga 10o. ANIVERSARIO";
            $item->address = "Blvd Kukulcan Km 10. 3 | Marina Punta Del Este, Zona Hotelera, Cancun 77500, Mexico";
            $item->logoPartner = "partner_1413320843.jpg";
        endforeach;

        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }

    public function getAllEvent_get(){
        $items = $this->api_db->getAllEvent();  

        foreach ($items as $item):
            // Add new vars
            $item->partner = "El Fish Fritanga 10o. ANIVERSARIO";
            $item->address = "Blvd Kukulcan Km 10. 3 | Marina Punta Del Este, Zona Hotelera, Cancun 77500, Mexico";
            $item->logoPartner = "partner_1413320843.jpg";
        endforeach;

            $message = array('success' => true, 'items' => $items);
            $this->response($message, 200);
    }

    public function getCoupon_get(){
        $items = $this->api_db->getCouponApp();
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }

    public function getAllCoupon_get(){
        $items = $this->api_db->getAllCoupon();
        $message = array('success' => true, 'items' => $items);
        $this->response($message, 200);
    }

}