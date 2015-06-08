<?php
/**
 * GeekBucket 2014
 * Author: Polanco Alan
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class City extends CI_Controller {

     public function __construct(){
        parent::__construct();
        $this->load->database('default');
        $this->load->helper('url');
        $this->load->model('city_db');
    }
    
    public function getCities(){
        if($this->input->is_ajax_request()){
            $data = $this->city_db->getNameSearch($_POST['dato']);
            echo json_encode($data);
        }
    }
    
}