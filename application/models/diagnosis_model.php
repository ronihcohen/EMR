<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Diagnosis_model extends CI_Model
{
	function getAllData($start,$limit,$sidx,$sord,$where){
	    $this->db->select('id,hebrew_name,english_name');
	    $this->db->limit($limit);
	    if($where != NULL)
	        $this->db->where($where,NULL,FALSE);
	    $this->db->order_by($sidx,$sord);
	    $query = $this->db->get('diagnosis',$limit,$start);

	    return $query->result();
	}
};