<?php
/**
 * GeekBucket 2014
 * Author: Polanco Alan
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Eventos extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
	   $this->load->database('default');
        $this->load->model('event_db');
		$this->load->model('place_db');
        if ($this->session->userdata('type') == 1 || !$this->session->userdata('type')) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de eventos
     */
    
	public function index($offset = 0){   
		$data['nameUser'] = $this->session->userdata('username');
        $data['page'] = 'eventos';     
        $data['event'] = $this->sortSliceArray($this->event_db->getAllEvents(),10);//se obtiene los primero 10
		$data['total'] = $this->totalArray($this->event_db->getAllEvents());
        $data['filter'] = $this->event_db->gerFilterEvent();
		
		$data['place'] = $this->sortSliceArray($this->place_db->getAllActivePlace(),10);//se obtiene los primero 10
		$data['totalP'] = $this->totalArray($this->place_db->getAllActivePlace());
        $this->load->view('admin/vwEventos',$data);   
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
    
	//obtiene un evento por la id
    public function getID(){
        if($this->input->is_ajax_request()){
            $items = $this->event_db->get($_POST['id']);
			
			$filter = $this->event_db->getFilterOfEvents($_POST['id']);
			
			$message = array('items' => $items, 'filters' => $filter);
			
            echo json_encode($message);
        }
    }
	
	//obtiene los datos del paginador
	public function paginadorArray(){
		if($this->input->is_ajax_request()){
            $data = $this->event_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
			$array = array_slice($data, $_POST['cantidad'], 10);
            echo json_encode($array);
        }
	}
	
	//obtiene los registros por la busqueda
	public function getallSearch(){
		if($this->input->is_ajax_request()){
            $data = $this->event_db->getallSearch($_POST['dato'],$_POST['column'],$_POST['order']);
            echo json_encode($data);
        }
	}
	
	//obtiene el lugar del evento
	public function getNamePlace(){
        if($this->input->is_ajax_request()){
            $data = $this->event_db->getNamePlace($_POST['dato'],$_POST['tabla']);
            echo json_encode($data);
        }
    }
	
	//obtiene la galeria del evento
	public function getAllGalleryById(){
		if($this->input->is_ajax_request()){
            $data = $this->event_db->getAllGalleryById($_POST['eventId']);
            echo json_encode($data);
        }
	}
	
	//inserta o actualiza los datos de eventos
	public function saveEvent(){
		if($this->input->is_ajax_request()){
			if($_POST['id'] == 0){
				$insert = array(
   					'name'	 		=> $_POST['name'],
					'cityId' 		=> $_POST['cityId'],
					'detail' 		=> $_POST['detail'],
   					'iniDate' 		=> $_POST['date'],
					'endDate' 		=> $_POST['endDate'],
					'image' 		=> $_POST['image'],
					'imageFull' 	=> $_POST['imageFull'],
					'status' 		=> 1
				);
				
				if($_POST['typePlace'] == "partner"){
					$insert['partnerId'] = $_POST['idPlace'];
				}elseif($_POST['typePlace'] == "place"){
					$insert['placeId'] = $_POST['idPlace'];
				}
				
				$data = $this->event_db->insertEvent($insert,json_decode(stripslashes($_POST['idFilter'])));
				
				$data = "Se han agregado un nuevo evento";
			} else {
				$update = array(
					'id' 			=> $_POST['id'],
					'name'	 		=> $_POST['name'],
					'cityId' 		=> $_POST['cityId'],
					'detail' 		=> $_POST['detail'],
   					'iniDate' 		=> $_POST['date'],
					'endDate' 		=> $_POST['endDate'],
					'image' 		=> $_POST['image'],
					'imageFull' 	=> $_POST['imageFull']
				);
				
				if($_POST['typePlace'] == "partner"){
					$update['partnerId'] = $_POST['idPlace'];
					$update['placeID'] = NULL;
				}elseif($_POST['typePlace'] == "place"){
					$update['placeId'] = $_POST['idPlace'];
					$update['partnerId'] = NULL;
				}
				
				$delete = array('idEvent' => $_POST['id']);
				
				$filter = array();
				$idFilter = json_decode(stripslashes($_POST['idFilter']));
				foreach($idFilter as $idF){
					array_push($filter, array(
						'idEvent' => $_POST['id'],
						'idFilter'=> $idF));
				}
				
				$data = $this->event_db->updateEvent($update,$delete,$filter);
				$data = "Se han editado los datos del evento";
			}
            
            echo json_encode($data);
        }
	}
	
	//elimina un evento
	public function deleteEvent(){
		if($this->input->is_ajax_request()){
				$delete = array(
					'id' => $_POST['id'],
   					'status' => 0
				);
				$data = $this->event_db->deleteEvent($delete);
            	echo json_encode($data);
        }
	}
	
	//sube al servidor la imagen selecionada
	public function subirImagen(){
		$ruta = explode(",",$_POST['ruta']);
		
		if($_POST['nameImage'] != 0){
			$nombreTimeStamp = $_POST['nameImage'];
		} else {
			$fecha = new DateTime();
        	$nombreTimeStamp = $fecha->getTimestamp();
		}
		
		$con = 0;		
  		foreach ($_FILES as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$nombre = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos el nombre del archivo temporal
      			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				if($con == 0){
					$nombreI = "e_" . $nombreTimeStamp . ".jpg";
				}else {
					$nombreI = "ef_" . $nombreTimeStamp . ".jpg";
				}
				
				move_uploaded_file($temporal, $ruta[$con] . $nombreI);
				
				$con++;
				
    		}else{
    		}
		}
		echo $nombreTimeStamp;
	}
	
	public function deleteImage(){
	}
	
	public function uploadImageGallery(){
		
		$con = 0;
  		foreach ($_FILES as $key) {
    		if($key['error'] == UPLOAD_ERR_OK ){//Verificamos si se subio correctamente
      			$nombre = $key['name'];//Obtenemos el nombre del archivo
      			$temporal = $key['tmp_name']; //Obtenemos la dirrecion del archivo
      			$tamano= ($key['size'] / 1000)."Kb"; //Obtenemos el tamaño en KB
				$tipo = $key['type']; //obtenemos el tipo de imagen
				
				$fecha = new DateTime();
				$nombreTimeStamp = $fecha->getTimestamp();
				
				$ruta="assets/img/app/partner/gallery/";
				
				$nameGallery = "gallery_" . $nombreTimeStamp . $con . ".jpg";
				
				//subimos la imagen de galleria	
				move_uploaded_file($temporal, $ruta . $nameGallery);
					
					echo $nameGallery . "*_*";
					
					$con++;
				
    		}else{
				
    		}
		}
		
	}
    
}	
