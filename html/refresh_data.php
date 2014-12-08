<?php

if(empty($_REQUEST["reset"])) {
  echo '<!DOCTYPE html><html><body><script>var x;if (confirm("Reset Data?") == true) {window.location.href = "/refresh_data.php/?reset=reset";}</script></body></html>';
  return;
}

require_once("database.php");

function insertChunk($db, $C_Name, $C_Address, $C_Phone, $E_Name, $E_Phone, $M_Make, $M_Model, $M_Year, $M_Cost, $Price, $Date, $Date_In, $Date_Out, $S_Cost, $Desc) {
  $cid = $db->newCustomer($C_Name, $C_Address, $C_Phone);
  $eid = $db->newEmployee($E_Name, $E_Phone);
  $mid = $db->newMake($M_Make, $M_Model, $M_Year, $M_Cost);
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

if($_REQUEST["reset"] == "reset") {
  $db->clearData();
  echo '<!DOCTYPE html><html><body><script>var x;if (confirm("Refill Data?") == true) {window.location.href = "/refresh_data.php/?reset=refill";}</script></body></html>';
}

if($_REQUEST["reset"] == "refill") {
  $ids = insertChunk($db, "jon", "pandaria", "435", "tyler durden", "00000", "sony", "notQuitePC", "2203", "100", "499", "22040101", "20030304", "20030305", "1", "but shit, it was 99 cents");

  $db->newSale($db->newCar($ids["mid"]), $ids["cid"], $ids["eid"], "999", "20000101");

  $ids = insertChunk($db, "greg", "stormwind", "342", "lulu", "9999", "microsoft", "flatboard", "2014", "100", "2000", "20140101", "20030304", "20030305", "300", "inflation");
  $ids = insertChunk($db, "enid", "hogwarts", "65875", "margret", "213", "apple", "hippimobile", "1990", "100", "2000", "20000101", "20030304", "20030305", "999", "in-car purchase");
  $ids = insertChunk($db, "jj binks", "mud", "3215", "lucian", "666", "ubisoft", "lovebuggy", "1999", "100", "352", "20010101", "20030304", "20030305", "40", "Bugs-Away DLC");

  echo "done";
}

?>
