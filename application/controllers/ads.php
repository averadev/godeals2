<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Ads extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('coupon_db');
		$this->load->model('ads_db');
        if ($this->session->userdata('type') == 1 || !$this->session->userdata('type')) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de eventos
     */
    
	public function index($offset = 0){     
		$data['nameUser'] = $this->session->userdata('username');
        $data['page'] = 'ads';
        $data['ads'] = $this->sortSliceArray($this->ads_db->getAllActive(),10);//se obtiene los primero 10
		$data['total'] = $this->totalArray($this->ads_db->getAllActive());//numeor total
		
        $this->load->view('admin/vwAds',$data);
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
	
	//
	public function paginadorArray(){
		if($this->input->is_ajax_request()){
            $data = $this->ads_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
			$array = array_slice($data, $_POST['cantidad'], 10);
            echo json_encode($array);
        }
	}
	
	public function getallSearch(){
		if($this->input->is_ajax_request()){
            $data = $this->ads_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
            echo json_encode($data);
        }
	}
	
	public function getId(){
		if($this->input->is_ajax_request()){
            $items = $this->ads_db->getId($_POST['id']);
            echo json_encode($items);
        }
	}
	
	public function saveAds(){
		if($this->input->is_ajax_request()){
			
			if($_POST['id'] == 0){
				
				$insert = array(
				'major' => $_POST['major'],
				'type' => $_POST['typeA'],
				'partnerId' => $_POST['partnerId'],
				'message' => $_POST['message'],
				'distanceMin' => $_POST['distanceMin'],
				'distanceMax' => $_POST['distanceMax'],
				'latitude' => $_POST['latitude'],
				'longitude' => $_POST['longitude'],
				'status' => 1);
				
				if($_POST['image'] != ""){
					$insert['image'] = $_POST['image'];	
					$insert['displayInfo'] = $_POST['displayInfo'];	
				}
				
				$data = $this->ads_db->insertAds($insert);
				$data = "Se ha agregado un nuevo mensaje";
			} else {
				
				$update = array(
				'id' => $_POST['id'],
				'major' => $_POST['major'],
				'type' => $_POST['typeA'],
				'partnerId' => $_POST['partnerId'],
				'message' => $_POST['message'],
				'distanceMin' => $_POST['distanceMin'],
				'distanceMax' => $_POST['distanceMax'],
				'latitude' => $_POST['latitude'],
				'longitude' => $_POST['longitude'],
				'displayInfo' => $_POST['displayInfo']);
				
				if($_POST['image'] != ""){
					$update['image'] = $_POST['image'];
				}
				
				$data = $this->ads_db->updateAds($update);
				$data = "Se ha editado los datos del mensaje";
			}
            echo json_encode($data);
        }
	}
	
	public function deleteAds(){
		if($this->input->is_ajax_request()){
			
			$delete = array(
				'id' => $_POST['id'],
				'status' => 0
			);
			
            $data = $this->ads_db->deleteAds($delete);
            echo json_encode($data);
        }
	}
	
	public function uploadImage(){
		
		//$ruta = explode(",",$_POST['ruta']);
		$ruta = $_POST['ruta'];
		
		if($_POST['nameImage'] != ""){
			$nombreTimeStamp = $_POST['nameImage'];
		} else {
			$fecha = new DateTime();
        	$nombreTimeStamp = "msg_" . $fecha->getTimestamp();
		}
		
		$con = 0;		
  		foreach ($_FILES as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$nombre = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
      			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				if($_POST['nameImage'] == ""){
					$extension=explode(".",$nombre); 
					$extension=$extension[count($extension)-1]; 
        			$nombreTimeStamp = $nombreTimeStamp . "." . $extension;
				}
				
				move_uploaded_file($temporal, $ruta . $nombreTimeStamp);
				
				$con++;
				
    		}else{
    		}
		}
		echo $nombreTimeStamp;
	}
	
	public function deleteImage(){
	}
	
}