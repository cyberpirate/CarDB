<?php

require_once("database.php");

$db = new Database();
var_dump($db->newCustomer("joe", "13 nowhere ave", "000000"));

#echo($_REQUEST["name"]);

?>
