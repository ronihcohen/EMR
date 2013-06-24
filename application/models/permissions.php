<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permissions extends CI_Model
{
	function authorized($group_id,$permission_name){

		$this->db->select('*');
		$this->db->from('permissions_groups');
		$this->db->where('group_id', $group_id);
		$this->db->join('permissions', 'permissions.id=permissions_groups.permission_id');
		$this->db->where('permissions.name', $permission_name);
		$query = $this->db->get();

	     if ($query->num_rows() > 0) {
	            //Value exists in database
	            return TRUE;
	        } else {
	            //Value doesn't exist in database
	            return FALSE;
	        }

		}
};