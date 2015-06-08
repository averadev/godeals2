<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Promociones extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('promo_db');
        if ($this->session->userdata('type') == 1 || !$this->session->userdata('type')) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de eventos
     */
    
	public function index($offset = 0){
		$data['nameUser'] = $this->session->userdata('username');
        $data['page'] = 'promociones';
        $data['coupon'] = $this->sortSliceArray($this->promo_db->getAllActive(),10);//se obtiene los primero 10
		$data['total'] = $this->totalArray($this->promo_db->getAllActive());//numeor todal de cupones
		$data['filter'] = $this->promo_db->gerFilterCoupon();
		
        $this->load->view('admin/vwPromociones',$data);
	}
	
	/**
     * Obtiene un array sorting and sliced
     */
    public function sortSliceArray($array, $count){
		//slice
        if (count($array) > $count){
            $array = array_slice($array, 0, $count);
        }
        return $array;
    }
	
	 public function totalArray($array){
        $array = count($array);
        return $array;
    }
	
	public function paginadorArray(){
		if($this->input->is_ajax_request()){
            $data = $this->promo_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
			$array = array_slice($data, $_POST['cantidad'], 10);
            echo json_encode($array);
        }
	}
	
	public function getallSearch(){
		if($this->input->is_ajax_request()){
            $data = $this->promo_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
            echo json_encode($data);
        }
	}
	
	public function getId(){
		if($this->input->is_ajax_request()){
            $items = $this->promo_db->getId($_POST['id']);
			
			$user = $this->promo_db->getUserById($_POST['id']);
			
			$filter = $this->promo_db->getFilterOfDeals($_POST['id']);
			
			$message = array('items' => $items, 'filters' => $filter, 'user' => $user);
            echo json_encode($message);
        }
	}
	
	public function getUser(){
		if($this->input->is_ajax_request()){
			$data = $this->promo_db->getUser($_POST['dato']);
			echo json_encode($data);	
		}	
	}
	
	public function saveCoupon(){
		if($this->input->is_ajax_request()){
			
			if($_POST['id'] == 0){
				
				$insert = array(
				'name' 			=> $_POST['name'],
				'partnerId' 	=> $_POST['partnerId'],
				'cityId' 		=> $_POST['cityId'],
				'image' 		=> $_POST['image'],
				'detail' 		=> $_POST['detail'],
				'clauses' 		=> $_POST['clauses'],
				'validity' 		=> $_POST['validity'],
				'total' 		=> 1,
				'stock' 		=> 0,
				'iniDate' 		=> $_POST['iniDate'],
				'endDate' 		=> $_POST['endDate'],
				'status' 		=> 2);
				
				$idDeals = $this->promo_db->insertCoupon($insert,json_decode(stripslashes($_POST['idFilter'])));
				
				if($_POST['userId'] != ""){
					$insertN = array(
						'tipo'	=>	2,
						'idRelacional'	=>	$idDeals,
						'idUsuario'		=>	$_POST['userId'],
						'leido'			=>	1,
						'fecha'			=> $_POST['fecha']
					);
					
					$code = $_POST['userId'] . $this->getRandomCode() . $idDeals;
				
					$insertD = array(
						'idCliente'	=>$_POST['userId'],
						'idCupon'	=>$idDeals,
						'idEvent'	=>0,
						'code'		=>$code,
						'status'	=>1
					);
					
					$data = $this->promo_db->insertPromocion($insertN,$insertD);
				}
				
				$data = "Se ha agregado un nuevo Deal";
			} else {
				
				$update = array(
				'id' 			=> $_POST['id'],
				'name' 			=> $_POST['name'],
				'partnerId' 	=> $_POST['partnerId'],
				'cityId' 		=> $_POST['cityId'],
				'image' 		=> $_POST['image'],
				'detail' 		=> $_POST['detail'],
				'clauses' 		=> $_POST['clauses'],
				'validity' 		=> $_POST['validity'],
				'iniDate' 		=> $_POST['iniDate'],
				'endDate' 		=> $_POST['endDate']
				);
				
				$delete = array('idCoupon' => $_POST['id']);
				
				$filter = array();
				$idFilter = json_decode(stripslashes($_POST['idFilter']));
				foreach($idFilter as $idF){
					array_push($filter, array(
						'idCoupon' => $_POST['id'],
						'idFilter'=> $idF));
				}
				
				if($_POST['userId'] != ""){
					
					$comprobarN = $this->promo_db->comprobarNotificacion($_POST['id'],$_POST['userId']);
					
					if(count($comprobarN) == 0){
					
						$insertN = array(
							'tipo'			=>	2,
							'idRelacional'	=>	$_POST['id'],
							'idUsuario'		=>	$_POST['userId'],
							'leido'			=>	1,
							'fecha'			=> $_POST['fecha']
						);
					
						$code = $_POST['userId'] . $this->getRandomCode() . $_POST['id'];
				
						$insertD = array(
							'idCliente'	=>$_POST['userId'],
							'idCupon'	=>$_POST['id'],
							'idEvent'	=>0,
							'code'		=>$code,
							'status'	=>1
						);
						
						$data = $this->promo_db->insertPromocion($insertN,$insertD);
					}else{
						
					}
					
				}
				
				
				$data = $this->promo_db->updateCoupon($update,$delete,$filter);
				$data = "Se ha editado los datos del deals";
			}
            echo json_encode($data);
        }
	}
	
	public function deleteCoupon(){
		if($this->input->is_ajax_request()){
			
			$delete = array(
				'id' => $_POST['id'],
				'status' => 0
			);
			
            $data = $this->promo_db->deleteCoupon($delete,$_POST['id']);
            echo json_encode($data);
        }
	}
	
	public function subirImagen(){
		
		//$ruta = explode(",",$_POST['ruta']);
		$ruta = $_POST['ruta'];
		
		/*if($_POST['nameImage'] != "0"){
			$nombreTimeStamp = $_POST['nameImage'];
		} else {
			$fecha = new DateTime();
        	$nombreTimeStamp = "d_" . $fecha->getTimestamp() . ".jpg";
		}*/
		
		$con = 0;		
  		foreach ($_FILES as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$nombre = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
      			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				$fecha = new DateTime();
				
				$nombreTimeStamp = "d_" . $fecha->getTimestamp();
				
				$extension=explode(".",$nombre); 
				$extension=$extension[count($extension)-1]; 
        		$nombreTimeStamp = $nombreTimeStamp . "." . $extension;
				
				move_uploaded_file($temporal, $ruta . $nombreTimeStamp);
				
				$con++;
				
    		}else{
    		}
		}
		echo $nombreTimeStamp;
	}
	
	public function deleteImage(){
	}
	
	/**
	 * Generamos codigo aleatorios
	 */
	public function getRandomCode(){
        $an = "ABCDEFGHJKLMNPQRSTUVWXYZ";
        $su = strlen($an) - 1;
        return substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1) .
                substr($an, rand(0, $su), 1);
    }
	
}