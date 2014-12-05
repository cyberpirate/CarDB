<?php

if(!$_REQUEST["reset"]) {
  echo "<!DOCTYPE html><html><body><script>var x;if (confirm(\"Reset Data?\") == true) {window.location.href = \"/?reset=yes\";}</script></body></html>";
  return;
}

require_once("database.php");

function insertChunk($db, $C_Name, $C_Address, $C_Phone, $E_Name, $E_Phone, $M_Make, $M_Model, $M_Year, $Price, $Date, $Date_In, $Date_Out, $S_Cost, $Desc) {
  $cid = $db->newCustomer($C_Name, $C_Address, $C_Phone);
  $eid = $db->newEmployee($E_Name, $E_Phone);
  $mid = $db->newMake($M_Make, $M_Model, $M_Year);
  $carid = $db->newCar($mid);
  $sid = $db->newSale($carid, $cid, $eid, $Price, $Date);
  $aid = $db->newService_Appt($cid, $carid, $eid, $Date_In, $Date_Out);
  $servid = $db->newService($S_Cost, $Desc);
  $servadded = $db->newServices_Done($aid, $servid);

  return array(
    "cid" => $cid,
    "eid" => $eid,
    "mid" => $mid,
    "carid" => $carid,
    "sid" => $sid,
    "aid" => $aid,
    "servid" => $servid,
    "servadded" => $servadded
  );
}


$db = new Database();
$db->clearData();

$ids = insertChunk($db, "jon", "pandaria", "435", "tyler durden", "00000", "sony", "notQuitePC", "2203", "$499", "2204", "20030304", "20030305", "$0.99", "but shit, it was 99 cents");

$db->newSale($db->newCar($mid), $ids["cid"], $ids["eid"], "$999", "2000");

$ids = insertChunk($db, "greg", "stormwind", "342", "lulu", "9999", "microsoft", "flatboard", "2014", "$999999999998", "2014", "20030304", "20030305", "$300", "inflation");
$ids = insertChunk($db, "enid", "hogwarts", "65875", "margret", "213", "apple", "hippimobile", "1990", "$999999999999", "2000", "20030304", "20030305", "$999", "in-car purchase");
$ids = insertChunk($db, "jj binks", "mud", "3215", "lucian", "666", "ubisoft", "lovebuggy", "1999", "$352", "2001", "20030304", "20030305", "$40", "Bugs-Away DLC");

?>
