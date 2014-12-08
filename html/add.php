<?php

function malformed_request() {
  echo json_encode(array("err" => "malformed request"));
  exit(0);
}

if(empty($_REQUEST["table"]))
  malformed_request();

require_once("database.php");
$db = new Database();

switch($_REQUEST["table"]) {
  case "Customer":
    echo json_encode(array("id" => $db->newCustomer($_REQUEST["C_Name"], $_REQUEST["C_Address"], $_REQUEST["C_Phone"])));
    break;
  case "Employee":
    echo json_encode(array("id" => $db->newEmployee($_REQUEST["E_Name"], $_REQUEST["E_Phone"])));
    break;
  case "Make":
    echo json_encode(array("id" => $db->newMake($_REQUEST["M_Make"], $_REQUEST["M_Model"], $_REQUEST["M_Year"], $_REQUEST["M_Cost"])));
    break;
  case "Car":
    echo json_encode(array("id" => $db->newCar($_REQUEST["M_ID"])));
    break;
  case "Sale":
    echo json_encode(array("id" => $db->newSale($_REQUEST["Car_ID"], $_REQUEST["C_ID"], $_REQUEST["E_ID"], $_REQUEST["Price"], $_REQUEST["Date"])));
    break;
  case "Service_Appt":
    echo json_encode(array("id" => $db->newService_Appt($_REQUEST["C_ID"], $_REQUEST["Car_ID"], $_REQUEST["E_ID"], $_REQUEST["Date_In"], $_REQUEST["Date_Out"])));
    break;
  case "Services_Done":
    echo json_encode(array("id" => $db->newServices_Done($_REQUEST["A_ID"], $_REQUEST["Serv_ID"])));
    break;
  case "Service":
    echo json_encode(array("id" => $db->newService($_REQUEST["Cost"], $_REQUEST["Description"])));
    break;
  default:
    malformed_request();
    break;
}

?>
