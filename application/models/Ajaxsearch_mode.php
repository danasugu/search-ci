<?php
class Ajaxsearch_model extends CI_Model
{
 function fetch_data($query)
 {
  $this->db->select("*");
  $this->db->from("tbl_contacts");
  if($query != '')
  {
   $this->db->like('ContactName', $query);
   $this->db->or_like('Address', $query);
   $this->db->or_like('Email', $query);
   $this->db->or_like('City', $query);
   $this->db->or_like('PostalCode', $query);
   $this->db->or_like('Country', $query);
  }
  $this->db->order_by('ContactID', 'DESC');
  return $this->db->get();
 }
}
?>
