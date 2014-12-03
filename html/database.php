<?php

class Database
{
	private $conn;

	public function __construct() {
		$this->conn = new mysqli("localhost", "dbProj", "p455w0rd");

		echo($username);

		if(!$this->conn->connect_error) {
			$this->conn->query("use carDB");
		}
	}

	public function latestPurchase() {
		$sql = "select c2.C_Name, s2.Date from Customer c1, Customer c2, Sale s1, Sale s2 where c1.C_ID == s1.C_ID and c2.C_ID == s2.C_ID and not s1.Date < s2.Date";

		$result = $this->conn->query($sql);
	}

	public function __destruct() {
		if(!$this->conn->connect_error)
			$this->conn->close();
	}
}
?>
