<?php

function malformed_request() {
  echo json_encode(array("err" => "malformed request"));
  exit(0);
}

if(empty($_REQUEST["stat"]))
  malformed_request();

require_once("database.php");
$db = new Database();

switch($_REQUEST["stat"]) {
  case "latestPurchase":
    echo json_encode($db->latestPurchase());
    break;
  case "cPurchase":
    echo json_encode($db->cPurchase());
    break;
  case "cSpent":
    echo json_encode($db->cSpent());
    break;
  case "cProfit":
    echo json_encode($db->cProfit());
    break;
  case "cLastAppt":
    echo json_encode($db->cLastAppt());
    break;
  case "serviceTime":
    echo json_encode($db->serviceTime());
    break;
  case "allCustomers":
    echo json_encode($db->allCustomers());
    break;
  default:
    malformed_request();
}

?>
