<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Groups extends CI_Model
{
	function getGroupName($id){
	    $query = $this->db->get_where
	    ('groups', array('id' => $id));
	    return $query->row()->name;
	}
};