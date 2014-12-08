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
  case "allServices":
    echo json_encode($db->allServices());
    break;
  case "statPage":
    if(empty($_REQUEST["start"]) || empty($_REQUEST["end"]))
	   malformed_request();

    $startDate = $_REQUEST["start"];
    $endDate = $_REQUEST["end"];
    echo json_encode($db->statistics($startDate, $endDate));
    break;

  case "carsOwned":
    if(empty($_REQUEST["cid"]))
      malformed_request();

    echo json_encode($db->getCarsOwned($_REQUEST["cid"]));
    break;

  default:
    malformed_request();
}

?>
