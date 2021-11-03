<?php
class Excel_export_model extends CI_Model
{
 function fetch_data()
 {
  $this->db->order_by("ContactId", "DESC");
  $query = $this->db->get("ContactName");
  return $query->result();
 }
}
?>