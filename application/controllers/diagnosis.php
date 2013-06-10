<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Diagnosis extends CI_Controller
{
	function __construct() {
	    parent::__construct();
	    $this->load->model('Diagnosis_model');
	    $this->load->helper('url');
	    $this->load->database();
	}

	function index($patientID){
	$this->load->view('showDiagnosis');
	}

	function DiagnosisToPatient($patientID){
	$data = array(
               'patientID' => $patientID,
          );
	$this->load->view('DiagnosisToPatient',$data);
	}

	function addDiagnosisToPatient($patientID,$diagnosisID){
	$data = array(
               'patientID' => $patientID,
               'diagnosisID' => $diagnosisID,
          );
	$this->load->view('DiagnosisToPatient',$data);
	}

	function loadData(){
	    $page = isset($_POST['page'])?$_POST['page']:1; 
	    $limit = isset($_POST['rows'])?$_POST['rows']:10; 
	    $sidx = isset($_POST['sidx'])?$_POST['sidx']:'id'; 
	    $sord = isset($_POST['sord'])?$_POST['sord']:'';         
	    $start = $limit*$page - $limit; 
	    $start = ($start<0)?0:$start; 

	    $where = ""; 
	    $searchField = isset($_POST['searchField']) ? $_POST['searchField'] : false;
	    $searchOper = isset($_POST['searchOper']) ? $_POST['searchOper']: false;
	    $searchString = isset($_POST['searchString']) ? $_POST['searchString'] : false;

	    if ($_POST['_search'] == 'true') {
	        $ops = array(
	        'eq'=>'=', 
	        'ne'=>'<>',
	        'lt'=>'<', 
	        'le'=>'<=',
	        'gt'=>'>', 
	        'ge'=>'>=',
	        'bw'=>'LIKE',
	        'bn'=>'NOT LIKE',
	        'in'=>'LIKE', 
	        'ni'=>'NOT LIKE', 
	        'ew'=>'LIKE', 
	        'en'=>'NOT LIKE', 
	        'cn'=>'LIKE', 
	        'nc'=>'NOT LIKE' 
	        );
	        foreach ($ops as $key=>$value){
	            if ($searchOper==$key) {
	                $ops = $value;
	            }
	        }
	        if($searchOper == 'eq' ) $searchString = $searchString;
	        if($searchOper == 'bw' || $searchOper == 'bn') $searchString .= '%';
	        if($searchOper == 'ew' || $searchOper == 'en' ) $searchString = '%'.$searchString;
	        if($searchOper == 'cn' || $searchOper == 'nc' || $searchOper == 'in' || $searchOper == 'ni') $searchString = '%'.$searchString.'%';

	        $where = "$searchField $ops '$searchString' "; 

	    }

	    if(!$sidx) 
	        $sidx =1;
	    $count = $this->db->count_all_results('diagnosis'); 
	    if( $count > 0 ) {
	        $total_pages = ceil($count/$limit);    
	    } else {
	        $total_pages = 0;
	    }

	    if ($page > $total_pages) 
	        $page=$total_pages;
	    $query = $this->Diagnosis_model->getAllData($start,$limit,$sidx,$sord,$where); 
	    $responce = new stdClass();
	    $responce->page = $page;
	    $responce->total = $total_pages;
	    $responce->records = $count;
	    $i=0;
	    foreach($query as $row) {
	        $responce->rows[$i]['id']=$row->id;
	        $responce->rows[$i]['cell']=array($row->hebrew_name,$row->english_name);
	        $i++;
	    }

	    echo json_encode($responce);
	}
}
