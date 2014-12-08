<?php

require_once("database.php");

$db = new Database();

$cid = $db->newCustomer("joe", "nowhere", "3452");
$eid = $db->newEmployee("bob", "23215");
$mid = $db->newMake("toyota", "garbage", "1776", "500");
$carid = $db->newCar($mid);
$sid = $db->newSale($carid, $cid, $eid, "999", "19930101");
$aid = $db->newService_Appt($cid, $carid, $eid, "19930102", "19930201");
$servid = $db->newService("999", "fix this shit");
$servadded = $db->newServices_Done($aid, $servid);

var_dump($servadded);
var_dump($servid);
var_dump($aid);
var_dump($sid);
var_dump($carid);
var_dump($mid);
var_dump($eid);
var_dump($cid);

?>
