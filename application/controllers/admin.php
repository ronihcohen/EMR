<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller
{
	function __construct() {
	    parent::__construct();
	    $this->load->model('Admin_model');
	    
	    $this->load->helper('url');
	    $this->load->database();

	    $this->load->model('Permissions');

	    $this->load->library('tank_auth_groups','','tank_auth');
	    $this->userData = $this->tank_auth->setUserData();

	    if (!$this->tank_auth->is_logged_in()) 
			redirect('/auth/login/');
	}

	function index(){ //ManageUsers
		$this->load->view('header',$this->userData);
		if ($this->tank_auth->is_admin()) 
			$this->load->view('adminMenu');
		if ($this->Permissions->
			authorized($this->session->userdata('group_id'),"ManageUsers")) 
			$this->load->view('showUsers');	
		else $this->load->view('notAuthorized');
		$this->load->view('footer');
	}

	function groups($oper='',$addToGroup_id=''){ //Manage Groups
		if ($oper=='addpermission' and $addToGroup_id!='')
			$data = array ('addToGroup_id'=>$addToGroup_id);
		else $data=array();
		$this->load->view('header',$this->userData);
		if ($this->tank_auth->is_admin()) 
			$this->load->view('adminMenu');
		if ($this->Permissions->
			authorized($this->session->userdata('group_id'),"ManageGroups")) 
			$this->load->view('showGroups',$data);	
		else $this->load->view('notAuthorized');
		$this->load->view('footer');
	}

	function userOper(){
	if($_POST['oper'] == 'del')
		{
 			$this->Admin_model->delUser($_POST['id']);
		}
	if($_POST['oper'] == 'edit')
		{
 			$this->Admin_model->edit($_POST['username'],$_POST['group_id'],$_POST['id']);
		}
	}


	function usersData(){
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
	    $count = $this->db->count_all_results('users'); 
	    if( $count > 0 ) {
	        $total_pages = ceil($count/$limit);    
	    } else {
	        $total_pages = 0;
	    }

	    if ($page > $total_pages) 
	        $page=$total_pages;
	    $query = $this->Admin_model->get_users($start,$limit,$sidx,$sord,$where); 
	    $responce = new stdClass();
	    $responce->page = $page;
	    $responce->total = $total_pages;
	    $responce->records = $count;
	    $i=0;
	    foreach($query as $row) {
	        $responce->rows[$i]['id']=$row->id;
	        $responce->rows[$i]['cell']=array($row->group_name,$row->username,$row->group_id);
	        $i++;
	    }

	    echo json_encode($responce);
	}

	function groupsData(){
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
	    $count = $this->db->count_all_results('groups'); 
	    if( $count > 0 ) {
	        $total_pages = ceil($count/$limit);    
	    } else {
	        $total_pages = 0;
	    }

	    if ($page > $total_pages) 
	        $page=$total_pages;
	    $query = $this->Admin_model->get_groups($start,$limit,$sidx,$sord,$where); 
	    $responce = new stdClass();
	    $responce->page = $page;
	    $responce->total = $total_pages;
	    $responce->records = $count;
	    $i=0;
	    foreach($query as $row) {
	        $responce->rows[$i]['id']=$row->id;
	        $responce->rows[$i]['cell']=array($row->id,$row->group_name);
	        $i++;
	    }

	    echo json_encode($responce);
	}

	function permissionsData($type,$id=0){ // permissions per users{
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
	    $count = $this->db->count_all_results('permissions'); 
	    if( $count > 0 ) {
	        $total_pages = ceil($count/$limit);    
	    } else {
	        $total_pages = 0;
	    }

	    if ($page > $total_pages) 
	        $page=$total_pages;

	    if ($type=='group')
	    $query = $this->Admin_model->permissionsPerGroups($id); 
		elseif ($type=='user')
		$query = $this->Admin_model->permissionsPerUsers($id);
	    elseif ($type=='all')
	    $query = $this->Admin_model->permissions();

	    $responce = new stdClass();
	    $responce->page = $page;
	    $responce->total = $total_pages;
	    $responce->records = $count;
	    $i=0;
	    foreach($query as $row) {
	    //    $responce->rows[$i]['id']=$row->id;
	        $responce->rows[$i]['cell']=array($row->name);
	        $i++;
	    }

	    echo json_encode($responce);
	}

	function DiagnosisPerPatient($patientID){
	$data = array(
               'patientID' => $patientID,
          );

	$this->load->view('header',$this->userData);
		$this->load->view('DiagnosisPerPatient',$data);
	$this->load->view('footer');
	}
}
