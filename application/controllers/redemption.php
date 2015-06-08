<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Redemption extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->database('default');
		$this->load->model('cliente_cupon_db');
    }

    /**
     * Obtiene la busqueda del codigo de redencion
     */
    public function setCode(){
        if($this->input->is_ajax_request()){
            $isCupon = $this->cliente_cupon_db->get($_POST['code']);
            if (count($isCupon) == 0){
                echo json_encode(array("success" => 0, "message" => "El codigo es incorrecto."));
            }else{
                if ($isCupon[0]->status == 2){
                    echo json_encode(array("success" => 0, "message" => "El Deal fue canjeado con anterioridad."));
                }else{
                    $this->cliente_cupon_db->update($_POST);
                    echo json_encode(array("success" => 1, "message" => "Deal aceptado."));
                }
            }
        }
    }
    
}