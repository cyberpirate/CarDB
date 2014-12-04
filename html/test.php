<?php

require_once("database.php");


$db = new Database();
var_dump($db->getData("Customer", array("C_ID" => "15")));

#echo($_REQUEST["name"]);

?>
