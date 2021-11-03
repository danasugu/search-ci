<?php
class Crud_model extends CI_Model
{
	function getUserDetails(){
 		$response = array();
		$this->db->select('username,name,gender,email');
		$q = $this->db->get('users');
		$response = $q->result_array();
	 	return $response;
	}

}