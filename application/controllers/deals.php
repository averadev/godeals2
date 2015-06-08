<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Deals extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('coupon_db');
        if ($this->session->userdata('type') == 1 || !$this->session->userdata('type')) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de eventos
     */
    
	public function index($offset = 0){  
		$data['nameUser'] = $this->session->userdata('username');      
        $data['page'] = 'deals';
        $data['coupon'] = $this->sortSliceArray($this->coupon_db->getAllActive(),10);//se obtiene los primero 10
		$data['total'] = $this->totalArray($this->coupon_db->getAllActive());//numeor todal de cupones
		$data['filter'] = $this->coupon_db->gerFilterCoupon();
		
        $this->load->view('admin/vwCupones',$data);
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
            $data = $this->coupon_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
			$array = array_slice($data, $_POST['cantidad'], 10);
            echo json_encode($array);
        }
	}
	
	public function getallSearch(){
		if($this->input->is_ajax_request()){
            $data = $this->coupon_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
            echo json_encode($data);
        }
	}
	
	public function getId(){
		if($this->input->is_ajax_request()){
            $items = $this->coupon_db->getId($_POST['id']);
			
			$filter = $this->coupon_db->getFilterOfDeals($_POST['id']);
			
			$message = array('items' => $items, 'filters' => $filter);
            echo json_encode($message);
        }
	}
	
	/**
	 * Obtiene los deals por comercio
	 */
	public function getDealsOfRewardByParner(){
		if($this->input->is_ajax_request()){
			$data = $this->coupon_db->getDealsOfRewardByParner($_POST['partnerId']);
			echo json_encode($data);
		}
	}
	
	/**
	 * paginador de los deals de la recompensa
	 */
	public function paginadorDealsByPartner(){
		if($this->input->is_ajax_request()){
			$data = $this->coupon_db->paginadorDealsByPartner($_POST['dato'],$_POST['column'],$_POST['order'],$_POST['idPartner']);
            echo json_encode($data);
		}
	}
	
	public function saveCoupon(){
		if($this->input->is_ajax_request()){
			
			$idDeals = 0;
			
			if($_POST['id'] == 0){
				
				$insert = array(
				'name' 			=> $_POST['name'],
				'partnerId' 	=> $_POST['partnerId'],
				'cityId' 		=> $_POST['cityId'],
				'image' 		=> $_POST['image'],
				'detail' 		=> $_POST['detail'],
				'clauses' 		=> $_POST['clauses'],
				'validity' 		=> $_POST['validity'],
				'total' 		=> $_POST['total'],
				'stock' 		=> $_POST['total'],
				'iniDate' 		=> $_POST['iniDate'],
				'endDate' 		=> $_POST['endDate'],
				'status' 		=> $_POST['status']);
				
				$idDeals = $this->coupon_db->insertCoupon($insert,json_decode(stripslashes($_POST['idFilter'])));
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
				'endDate' 		=> $_POST['endDate'],
				'total' 		=> $_POST['total'],
				'status' 		=> $_POST['status']);
				
				
				if($_POST['stock'] != ""){
					$update['stock'] = $_POST['stock'];
				}
				
				$delete = array('idCoupon' => $_POST['id']);
				
				$filter = array();
				$idFilter = json_decode(stripslashes($_POST['idFilter']));
				foreach($idFilter as $idF){
					array_push($filter, array(
						'idCoupon' => $_POST['id'],
						'idFilter'=> $idF));
				}
				
				$data = $this->coupon_db->updateCoupon($update,$delete,$filter);
				
				$idDeals = $_POST['id'];
				
				$data = "Se ha editado los datos del deals";
			}
            echo json_encode(array('mensage' => $data, 'idDeals' => $idDeals));
        }
	}
	
	public function deleteCoupon(){
		if($this->input->is_ajax_request()){
			
			$data = $this->coupon_db->checkDownloads($_POST['id']);
			
			if(count($data) > 0){
				
				$delete = array(
					'id' => $_POST['id'],
					'total' => count($data),
					'stock' => 0
				);
				$data = $this->coupon_db->deleteCoupon($delete);
				$data = "El cupon ha sido descargado. no se ha podido borrar";
				
			}else{
				
				$delete = array(
					'id' => $_POST['id'],
					'status' => 0
				);
				$data = $this->coupon_db->deleteCoupon($delete);
				$data = "Se han eliminado el deals";
			}
			
			
			
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
	
	//////////////////////* deals recompensa
	
	public function subirImagenDeals(){
		
		$ruta = $_POST['ruta'];
			
		$con = 0;		
  		foreach ($_FILES as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$nombre = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
      			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				$fecha = new DateTime();
				
				$nombreTimeStamp = "d_" . $fecha->getTimestamp() . $con;
				
				$extension=explode(".",$nombre); 
				$extension=$extension[count($extension)-1]; 
        		$nombreTimeStamp = $nombreTimeStamp . "." . $extension;
				
				move_uploaded_file($temporal, $ruta . $nombreTimeStamp);
				
				$con++;
				
				echo $nombreTimeStamp . "*_*";
				
    		}else{
				
    		}
		}
		
		
	}
	
}