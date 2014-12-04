<?php

class Database
{
	private $conn;

	public function __construct() {
		$this->conn = new mysqli("localhost", "dbProj", "p455w0rd");

		if(!$this->conn->connect_error) {
			$this->conn->query("use carDB");
		}
	}

	public function latestPurchase() {
		$sql = "select c2.C_Name, s2.Date from Customer c1, Customer c2, Sale s1, Sale s2 where c1.C_ID == s1.C_ID and c2.C_ID == s2.C_ID and not s1.Date < s2.Date";

		$result = $this->conn->query($sql);
	}

	public function newCustomer($name, $address, $phone) {

		$name = $this->conn->escape_string($name);
		$address = $this->conn->escape_string($address);
		$phone = $this->conn->escape_string($phone);

		$name = trim($name);
		$address = trim($address);
		$phone = trim($phone);

		if(empty($phone) || empty($address) || empty($name))
			return -1;

		$sql = "insert into Customer (C_Name, C_Address, C_Phone) values ('" . $name . "', '" . $address . "', '" . $phone . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return mysqli_insert_id($this->conn);
		} else {
			return -1;
		}

	}

	public function __destruct() {
		if(!$this->conn->connect_error)
			$this->conn->close();
	}
}
?>
