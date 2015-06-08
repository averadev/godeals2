<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");

class Lealtad extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('lealtad_db');
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
        $data['page'] = 'lealtad';
        $data['campana'] = $this->sortSliceArray($this->lealtad_db->getAllCampana(),10);//se obtiene los primero 10
		$data['totalC'] = $this->totalArray($this->lealtad_db->getAllCampana());//numeor todal de cupones
		/*$data['filter'] = $this->lealtad_db->gerFilterCoupon();*/
		$data['filter'] = $this->coupon_db->gerFilterCoupon();
        $this->load->view('admin/vwLealtad',$data);
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
	
	public function paginadorCampana(){
		if($this->input->is_ajax_request()){
            $data = $this->lealtad_db->getallSearchCampana($_POST['dato'],$_POST['column'],$_POST['order']);
			$array = array_slice($data, $_POST['cantidad'], 10);
            echo json_encode($array);
        }
	}
	
	public function getallSearchCampana(){
		if($this->input->is_ajax_request()){
            $data = $this->lealtad_db->getallSearchCampana($_POST['dato'],$_POST['column'],$_POST['order']);
            echo json_encode($data);
        }
	}
	
	public function getId(){
		if($this->input->is_ajax_request()){
            $items = $this->lealtad_db->getId($_POST['id']);
			
			$recompensa = $this->lealtad_db->getRecompensaCampana($_POST['id']);
			
			$message = array('items' => $items, 'recompensa' => $recompensa);
            echo json_encode($message);
        }
	}
	
	public function getDealsOfReward(){
		if($this->input->is_ajax_request()){
			$data = $this->lealtad_db->userDealslReward($_POST['id']);
			echo json_encode($data);
		}	
	}
	
	public function saveCampana(){
		if($this->input->is_ajax_request()){
			
			if($_POST['id'] == 0){
				
				$insert = array(
					'nombre' 		=> $_POST['nombre'],
					'descripcion' 	=> $_POST['descripcion'],
					'status' 		=> $_POST['status'],
					'partnerId' 	=> $_POST['partnerId']
				);
				
				$data = $this->lealtad_db->insertCampana($insert);
				$data = "Se ha agregado un nuevo Campaña";
			} else {
				
				$update = array(
					'id' 			=> $_POST['id'],
					'nombre' 		=> $_POST['nombre'],
					'descripcion' 	=> $_POST['descripcion'],
					'status' 		=> $_POST['status'],
					'partnerId' 	=> $_POST['partnerId']
				);
				
				$data = $this->lealtad_db->updateCampana($update);
				$data = "Se ha editado los datos de la campaña";
			}
            echo json_encode($data);
        }
	}
	
	public function deleteCampana(){
		if($this->input->is_ajax_request()){
			$delete = array(
				'id' => $_POST['id'],
				'status' => 0
			);
			$data = $this->lealtad_db->deleteCampana($delete);
			$data = "Se han eliminado la campaña";
            echo json_encode($data);
        }
	}
	
	/**************************************
	/********Recompensa de Campaña********/
	/*************************************/
	
	//obtiene los datos de la recompensa po id
	public function getRewardCampanaById(){
		if($this->input->is_ajax_request()){
			$data = $this->lealtad_db->getRewardCampanaById($_POST['id']);
			$rule = $this->lealtad_db->requirementsAuthorizations($_POST['id']);
			$user = $this->lealtad_db->userLevelReward($_POST['id']);
			$deals = $this->lealtad_db->userDealslReward($_POST['id']);
			echo json_encode(array('items' => $data,'rule' => $rule, 'user' => $user, 'deals' => $deals));
		}	
	}
	
	//guarda los datos de la recompensa de la campaña
	public function saveRewardCampana(){
		if($this->input->is_ajax_request()){
			if($_POST['id'] == 0){
				
				$rules = json_decode(($_POST['rules']));
				$userLevel = json_decode(stripslashes($_POST['userLevel']));
				$dealsReward = json_decode(stripslashes($_POST['dealsReward']));
				
				$insert = array(
					'nombre' 						=> $_POST['nombre'],
					'lealtadCampanaId' 				=> $_POST['lealtadCampanaId'],
					'cantidadVigencia' 				=> $_POST['cantidadVigencia'],
					'lealtadTiposVigenciaId' 		=> $_POST['lealtadTiposVigenciaId'],
					'fechaInicio' 					=> $_POST['fechaInicio'],
					'fechaTermino' 					=> $_POST['fechaTermino'],
					'lealtadStatusRecompensasId' 	=> $_POST['lealtadStatusRecompensasId'],
					'rechazado'						=> 0
				);
				
				$idReward = $this->lealtad_db->insertRewardCampana($insert);
				
				$ruleA = array();
				$userLevelA = array();
				$dealsRewardA = array();
				
				foreach($rules as $items){
					array_push($ruleA, array(
						'lealtadRecompensaId' => $idReward,
						'nombre' => $items->nombre,
						'cantidadRequerida' => $items->cantidadRequerida,
						'lealtadReglasId' => $items->lealtadReglasID
					));
				}
				
				if($userLevel != 0){
					foreach($userLevel as $items){
						array_push($userLevelA, array(
							'lealtadRecompensaId' => $idReward,
							'catNivelUsuariosId' => $items->catNivelUsuarioId,
						));
					}
				}
				
				$data = $this->lealtad_db->insertXrefRecompensaCampana($ruleA,$userLevelA);
				
				$RecompensaProceso = array();
				
				//if($dealsReward != 0){
				foreach($dealsReward as $items){
					array_push($dealsRewardA, array(
						'recompensaId' => $idReward,
						'dealsId' => $items
					));
				}
				//}
				
				$data = $this->lealtad_db->insertXrefRecompensaDeals($dealsRewardA,$idReward);
				
				$hoy = getdate();
				$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"]." ".$hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
				
				$procesoAutho = array(
					'lealtadRecompensaId' 			=> $idReward,
					'lealtadStatusRecompensasId' 	=> $_POST['lealtadStatusRecompensasId'],
					'fechaModificacion' 			=> $strHoy
				);
				
				$data = $this->lealtad_db->insertXrefProcesoAutorizacion($procesoAutho);
				
				$recompensa = $this->lealtad_db->getRecompensaCampana($_POST['lealtadCampanaId']);
				
				$data = array('mensagge' => "Se ha agregado un nueva recopensa a la campaña", 'recompensa' => $recompensa);
			} else {
				
				$rules = json_decode(($_POST['rules']));
				$userLevel = json_decode(stripslashes($_POST['userLevel']));
				$dealsReward = json_decode(stripslashes($_POST['dealsReward']));
				
				$rechazado = 0;
				
				if($_POST['lealtadStatusRecompensasId'] < $_POST['status']){
					$rechazado = 1;
				}
				
				$update = array(
					'id'							=> $_POST['id'],
					'nombre' 						=> $_POST['nombre'],
					'lealtadCampanaId' 				=> $_POST['lealtadCampanaId'],
					'cantidadVigencia' 				=> $_POST['cantidadVigencia'],
					'lealtadTiposVigenciaId' 		=> $_POST['lealtadTiposVigenciaId'],
					'fechaInicio' 					=> $_POST['fechaInicio'],
					'fechaTermino' 					=> $_POST['fechaTermino']
					//'lealtadStatusRecompensasId' 	=> $_POST['lealtadStatusRecompensasId'],
					//'rechazado'						=> $rechazado
				);
				
				$this->lealtad_db->updateRewardCampana($update);
				
				$delete = array('lealtadRecompensaId' => $_POST['id']);
				
				$data = $this->lealtad_db->deleteXrefRecompensaCampana($delete);
				
				$ruleA = array();
				$userLevelA = array();
				$dealsRewardA = array();
				
				foreach($rules as $items){
					array_push($ruleA, array(
						'lealtadRecompensaId' => $_POST['id'],
						'nombre' => $items->nombre,
						'cantidadRequerida' => $items->cantidadRequerida,
						'lealtadReglasId' => $items->lealtadReglasID
					));
				}
				
				if($userLevel != 0){
					foreach($userLevel as $items){
						array_push($userLevelA, array(
							'lealtadRecompensaId' => $_POST['id'],
							'catNivelUsuariosId' => $items->catNivelUsuarioId,
						));
					}
				}
				
				$data = $this->lealtad_db->insertXrefRecompensaCampana($ruleA,$userLevelA);
				
				//if($dealsReward != 0){
				foreach($dealsReward as $items){
					array_push($dealsRewardA, array(
						'recompensaId' 	=> $_POST['id'],
						'dealsId' 		=> $items
					));
				}
				//}
				
				$data = $this->lealtad_db->insertXrefRecompensaDeals($dealsRewardA,$_POST['id']);
				
				/*if($_POST['status'] != $_POST['lealtadStatusRecompensasId']){
					
					$hoy = getdate();
					$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"]." ".$hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
				
					$procesoAutho = array(
						'lealtadRecompensaId' 			=> $_POST['id'],
						'lealtadStatusRecompensasId' 	=> $_POST['lealtadStatusRecompensasId'],
						'fechaModificacion' 			=> $strHoy
					);
				
					$data = $this->lealtad_db->insertXrefProcesoAutorizacion($procesoAutho);
				}*/
				
				$recompensa = $this->lealtad_db->getRecompensaCampana($_POST['lealtadCampanaId']);
				
				$data = array('mensagge' => "Se ha editado los datos de la recompensa", 'recompensa' => $recompensa);
			}
			echo json_encode($data);
		}	
	}
	
	//elimina la recompensa
	public function deleteRewardCampana(){
		
		$delete = array(
			'id' => $_POST['id'],
			'lealtadStatusRecompensasId' => 0
		);
		
		$data = $this->lealtad_db->updateRewardCampana($delete);
		
		$recompensa = $this->lealtad_db->getRecompensaCampana($_POST['idCampana']);
		
		$data = array('mensagge' => "Se ha eliminado la recompensa", 'recompensa' => $recompensa);
		echo json_encode($data);
	}
	
	/////////////////////////////////////////////////
	/////////////////autorizacion////////////////////
	/////////////////////////////////////////////////
	
	//obtiene las campañas pendientes a publicar
	public function pendingAuthorizations(){
		if($this->input->is_ajax_request()){
			$data = $this->lealtad_db->pendingAuthorizations($_POST['status']);
			$requesitos = array();
			foreach($data as $items){
				$data2 = $this->lealtad_db->requirementsAuthorizations($items->id);
				array_push($requesitos, array($data2));
			}
			echo json_encode(array('items' => $data, 'requirements' => $requesitos));	
		}	
	}
	
	//aprueba la recompensa de la campaña
	public function approvedReward(){
		if($this->input->is_ajax_request()){
			$data = $this->lealtad_db->approvedReward(array('id' => $_POST['id'],'lealtadStatusRecompensasId' => $_POST['status']));
			echo json_encode($data);
		}	
	}
	
	//paginador de autorizacion
	public function paginadorAuthoL(){
		if($this->input->is_ajax_request()){
			$data = $this->lealtad_db->getPendingAutoPa($_POST['dato'],$_POST['column'],$_POST['order']);
            $requesitos = array();
			foreach($data as $items){
				$data2 = $this->lealtad_db->requirementsAuthorizations($items->id);
				array_push($requesitos, array($data2));
			}
			$data = array_slice($data, $_POST['cantidad'], 10);
			$requesitos = array_slice($requesitos, $_POST['cantidad'], 10);
			echo json_encode(array('items' => $data, 'requirements' => $requesitos));
		}
	}
	
	public function saveDealsNew(){
		if($this->input->is_ajax_request()){
			$dealsArray = json_decode(stripslashes($_POST['jsonDeals']));
			$dealsFilterArray = json_decode(stripslashes($_POST['jsonDealsFilter']));
			for($i = 0;$i<count($dealsArray);$i++){
				$data = $this->coupon_db->insertCoupon($dealsArray[$i],$dealsFilterArray[$i]);
			}
		}
	}
	
	////cambia el estatus de la recompensa
	public function shiftStatusReward(){
		if($this->input->is_ajax_request()){
			$rechazado = 0;
			if($_POST['idStatus'] < $_POST['status']){
				$rechazado = 1;
			}
			
			$updateReward = array(
               'lealtadStatusRecompensasId' => $_POST['idStatus'],
               'rechazado' => $rechazado
            );
			
			$hoy = getdate();
			$strHoy = $hoy["year"]."-".$hoy["mon"]."-".$hoy["mday"]." ".$hoy["hours"].":".$hoy["minutes"].":".$hoy["seconds"];
				
			$procesoAutho = array(
				'lealtadRecompensaId' 			=> $_POST['id'],
				'lealtadStatusRecompensasId' 	=> $_POST['idStatus'],
				'fechaModificacion' 			=> $strHoy
			);
			
			$data = $this->lealtad_db->shiftStatusReward($_POST['id'],$updateReward);
			
			$data = $this->lealtad_db->insertXrefProcesoAutorizacion($procesoAutho);
			
			echo json_encode($data);
		}
	}
	
	/////////////////////////////////////////////////
	///////////////////recompensa////////////////////
	/////////////////////////////////////////////////
	
	public function getRewardCatalog(){
		if($this->input->is_ajax_request()){
			$data = $this->	lealtad_db->getRewardCatalog();
			$requesitos = array();
			foreach($data as $items){
				$data2 = $this->lealtad_db->requirementsAuthorizations($items->id);
				array_push($requesitos, array($data2));
			}
			echo json_encode(array('items' => $data, 'requirements' => $requesitos));
		}
	}
	
	/**
	 * Obtiene los datos de la busqueda de catalogo recompensa
	 */
	public function getAllSearchReward(){
		if($this->input->is_ajax_request()){
			$data = $this->	lealtad_db->getAllSearchReward($_POST['dato2'],$_POST['dato3'],$_POST['dato4'],$_POST['column'],$_POST['order']);
			$requesitos = array();
			foreach($data as $items){
				$data2 = $this->lealtad_db->requirementsAuthorizations($items->id);
				array_push($requesitos, array($data2));
			}
			echo json_encode(array('items' => $data, 'requirements' => $requesitos));
		}
	}
	
	public function paginadorReward(){
		if($this->input->is_ajax_request()){
			$data = $this->	lealtad_db->getAllSearchReward($_POST['dato2'],$_POST['dato3'],$_POST['dato4'],$_POST['column'],$_POST['order']);
			$requesitos = array();
			foreach($data as $items){
				$data2 = $this->lealtad_db->requirementsAuthorizations($items->id);
				array_push($requesitos, array($data2));
			}
			$data2 = array_slice($data, $_POST['cantidad'], 10);
			$requesitos2 = array_slice($requesitos, $_POST['cantidad'], 10);
			echo json_encode(array('items' => $data2, 'requirements' => $requesitos2));
		}
	}
	
}