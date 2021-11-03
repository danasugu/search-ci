<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_export extends CI_Controller {
 
 function index()
 {
  $this->load->model("excel_export_model");
  $data["employee_data"] = $this->excel_export_model->fetch_data();
  $this->load->view("excel_export_view", $data);
 }

 function action()
 {
  $this->load->model("excel_export_model");
  $this->load->library("excel");
  $object = new PHPExcel();

  $object->setActiveSheetIndex(0);

  $table_columns = array("ContactName", "Email", "ProjectName", "Address", "City", "PostalCode", "Country");

  $column = 0;

  foreach($table_columns as $field)
  {
   $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
   $column++;
  }

  $employee_data = $this->excel_export_model->fetch_data();

  $excel_row = 2;


  foreach($employee_data as $row)
  {
   $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->ContactName.);
   $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->Address);
   $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->Email);
   $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->ProjectName);
   $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->City);
   $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->PostalCode);
   $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->Country);
   $excel_row++;
  }

  $object_writer = PHPExcel_IOFactory::createWriter($object, 'Excel5');
  header('Content-Type: application/vnd.ms-excel');
  header('Content-Disposition: attachment;filename="Employee Data.xls"');
  $object_writer->save('php://output');
 }

 
 
}