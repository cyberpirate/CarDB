<?php

require_once("database.php");

$db = new Database();

$cid = $db->newCustomer("joe", "nowhere", "3452");
$eid = $db->newEmployee("bob", "23215");
$mid = $db->newMake("toyota", "garbage", "1776");
$carid = $db->newCar($mid);
$sid = $db->newSale($carid, $cid, $eid, "$999", "1-1-1993");
$aid = $db->newService_Appt($cid, $carid, $eid, "1-2-1993", "2-1-1993");
$servid = $db->newService("$999", "fix this shit");
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
