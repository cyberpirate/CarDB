<?php

function is_table($table) {
  $tables = array("Customer", "Employee", "Make", "Car", "Sale", "Service_Appt", "Services_Done", "Service");
  return in_array($table, $tables);
}

function is_col($col) {
  $cols = array("C_ID", "C_Name", "C_Address", "C_Phone", "E_ID", "E_Name", "E_Phone", "M_ID", "M_Make", "M_Model", "M_Year", "Car_ID", "M_ID", "S_ID", "Car_ID", "C_ID", "E_ID", "Price", "Date", "A_ID", "C_ID", "Car_ID", "E_ID", "Date_In", "Date_Out", "A_ID", "Serv_ID", "Serv_ID", "Cost", "Description");
  return in_array($col, $cols);
}

$table = $_REQUEST["table"];

if(!is_table($table)) {
  echo json_encode(array("err" => "table not found"));
  exit(0);
}

$cols = array();

foreach($_REQUEST as $key => $value) {
  if(is_col($key))
    $cols[$key] = $value;
}

if(empty($cols)) {
  echo json_encode(array("err" => "no columns"));
  exit(0);
}

require_once("database.php");

$db = new Database();
$results = $db->getData($table, $cols);

echo json_encode($results);

?>
