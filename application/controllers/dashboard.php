<?php
/**
 * GeekBucket 2014
 * Author: Alfredo Chi
 *
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

setlocale(LC_ALL,"es_ES@euro","es_ES","esp");



class Dashboard extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');
		$this->load->database('default');
        $this->load->model('dashboard_db');
		$this->load->library('excel_pdf_manager');
        if ($this->session->userdata('type') == 1 || !$this->session->userdata('type')) {
            redirect('login');
        }
    }

    /**
     * Despliega la pantalla de eventos
     */
    
	public function index($offset = 0){        
        $data['page'] = 'dashboard';
		$data['nameUser'] = $this->session->userdata('username'); 
		$data['DealsT'] = $this->dashboard_db->getDeals();
		$data['DealsTW'] = $this->dashboard_db->getDealsWeek();
		$data['DealsR'] = $this->dashboard_db->getDealsRedeemed();
		$data['DealsRW'] = $this->dashboard_db->getDealsRedeemedWeek();
        $this->load->view('admin/vwDashboard',$data);
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
	
	public function getDownloadByDate(){
		if($this->input->is_ajax_request()){
			$downloads = $this->dashboard_db->getDownloadByDate($_POST['iniDate'],$_POST['endDate']);
			$redimir = $this->dashboard_db->getRedimirByDate($_POST['iniDate'],$_POST['endDate']);	
			echo json_encode(array('downloads' => $downloads, 'redimir' => $redimir));
		}
	}
	
	public function getDealsByPartner(){
		if($this->input->is_ajax_request()){
			$downloads = $this->dashboard_db->getAllDealsPartner($_POST['idPartner']);
			$redimir = $this->dashboard_db->getAllRedimirPartner($_POST['idPartner']);
			echo json_encode(array('downloads' => $downloads, 'redimir' => $redimir));
		}
	}
	
	public function getDealsByPartnerAndDate(){
		if($this->input->is_ajax_request()){
			$downloads = $this->dashboard_db->getDealsByPartnerAndDate($_POST['idPartner'],$_POST['iniDate'],$_POST['endDate']);
			$redimir = $this->dashboard_db->getRedimirByPartnerAndDate($_POST['idPartner'],$_POST['iniDate'],$_POST['endDate']);
			echo json_encode(array('downloads' => $downloads, 'redimir' => $redimir));
		}
	}
	
	/*******************************/
	
	public function createReportDeals(){
		
		if($_POST['reportAllDeas'] != ""){
			$AllDeals = $_POST['reportAllDeas'];
			$AllDEalsPart = explode(",", $AllDeals);
		}else{
			$AllDEalsPart = 0;
		}
		
		if($_POST['reportAllDeasDate'] != ""){
			$reportAllDeasDate = $_POST['reportAllDeasDate'];
			$AllDEalsDatePart = explode(",", $reportAllDeasDate);
		}else{
			$AllDEalsDatePart = 0;
		}
		
		if($_POST['reportPartnerDeas'] != ""){
			
			$reportPartnerDeas = $_POST['reportPartnerDeas'];
			$PartnerDeas = explode(",", $reportPartnerDeas);
			
		}else{
			$PartnerDeas = 0;	
		}
		
		$this->excel_pdf_manager->export($AllDEalsPart,$AllDEalsDatePart,$PartnerDeas);
	}
	
}