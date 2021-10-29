
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajaxsearch extends CI_Controller {

 function index()
 {
  $this->load->view('ajaxsearch');
 }

 function fetch()
 {
  $output = '';
  $query = '';
  $this->load->model('ajaxsearch_model');
  if($this->input->post('query'))
  {
   $query = $this->input->post('query');
  }
  $data = $this->ajaxsearch_model->fetch_data($query);
  $output .= '
  <div class="table-responsive">
     <table class="table table-bordered table-striped">
      <tr>
       <th>Contact Name</th>
       <th>Address</th>
       <th>Email</th>
       <th>ProjectName</th>
       <th>City</th>
       <th>Postal Code</th>
       <th>Country</th>
      </tr>
  ';
  if($data->num_rows() > 0)
  {
   foreach($data->result() as $row)
   {
    $output .= '
      <tr>
       <td>'.$row->ContactName.'</td>
       <td>'.$row->Address.'</td>
       <td>'.$row->Email.'</td>
       <td>'.$row->ProjectName.'</td>
       <td>'.$row->City.'</td>
       <td>'.$row->PostalCode.'</td>
       <td>'.$row->Country.'</td>
      </tr>
    ';
   }
  }
  else
  {
   $output .= '<tr>
       <td colspan="5">No Data Found</td>
      </tr>';
  }
  $output .= '</table>';
  echo $output;
 }



 public function download_items_invoices($start_date='2021-10-19', $end_date='2021-10-20'){

  $this->db->select('');
  $this->db->join('tbl_projects', 'tbl_projects.projectname = tbl_contacts.projectname');



  



  //$this->db->limit(100);
  $data = $this->db->get('tbl_contacts')->result_array();

  // echo '<pre>';
  // print_r($data);

  $header = array('prefix','numar factura','linie','pret','cantitate','client','cui/cnp','nr contract','distribuitor','POD');

  array_unshift($data, $header);

  // Excel file name for download 
$fileName = "codexworld_export_data-" . date('Ymd') ; 

// Headers for download 
header("Content-Type: application/xls");    
header("Content-Disposition: attachment; filename=$fileName.xls");  
header("Pragma: no-cache"); 
header("Expires: 0");

$flag = false; 
foreach($data as $row) { 
  // if(!$flag) { 
  //     // display column names as first row 
  //     echo implode("\t", array_keys($row)) . "\n"; 
  //     $flag = true; 
  // } 
  // filter data 
  array_walk($row,  array($this, 'filterData')); 
  echo implode("\t", array_values($row)) . "\n"; 
} 


exit;

}

private function filterData(&$str){ 
 // escape tab characters
  $str = preg_replace("/\t/", "\\t", $str);

  // escape new lines
  $str = preg_replace("/\r?\n/", "\\n", $str);

  // convert 't' and 'f' to boolean values
  if($str == 't') $str = 'TRUE';
  if($str == 'f') $str = 'FALSE';

  // force certain number/date formats to be imported as strings
  if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) {
  $str = "'$str";
  }

  // escape fields that include double quotes
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}
 
}