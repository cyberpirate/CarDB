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
  $ids = insertChunk($db, "Jon", "433 Pandaria Drive", "4355559898", "Tyler", "7329969503", "Mazda", "3", "2007", "3000", "5000", "20140101", "20140304", "20140305", "100", "Oil Change");

  $db->newSale($db->newCar($ids["mid"]), $ids["cid"], $ids["eid"], "999", "20000101");

  $ids = insertChunk($db, "Greg", "17 Party Ave.", "3423426860", "Lucy", "9999999999", "Ford", "Fiesta", "2014", "27000", "32000", "20140606", "20141004", "20141005", "300", "Tire Change");
  $ids = insertChunk($db, "Enid", "9 Hogwarts Express", "7328675309", "Margret", "2133120987", "Apple", "iCar", "2012", "100000", "2000000", "20141212", "20141225", "20141230", "999", "In-Car Purchase");
  $ids = insertChunk($db, "JJ Binks", "9 Mud Street", "1266126609", "Paul", "6666666661", "BMW", "Car", "1999", "1000", "3520", "20010101", "20030304", "20030305", "400", "Catalytic Converter");

  echo "done";
}

?>
