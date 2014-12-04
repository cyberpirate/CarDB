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

	public function newEmployee($name, $phone) {

		$name = $this->conn->escape_string($name);
		$phone = $this->conn->escape_string($phone);

		$name = trim($name);
		$phone = trim($phone);

		if(empty($phone) || empty($name))
			return -1;

		$sql = "insert into Employee (E_Name, E_Phone) values ('" . $name . "', '" . $phone . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return mysqli_insert_id($this->conn);
		} else {
			return -1;
		}
	}

	public function newMake($make, $model, $year) {

		$year = $this->conn->escape_string($year);
		$model = $this->conn->escape_string($model);
		$make = $this->conn->escape_string($make);

		$make = trim($make);
		$model = trim($model);
		$year = trim($year);

		if(empty($make) || empty($model) || empty($year))
			return -1;

		$sql = "insert into Make(M_Make, M_Model, M_Year) values ('" . $make . "', '" . $model . "', '" . $year . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return mysqli_insert_id($this->conn);
		} else {
			return -1;
		}
	}

	public function newCar($mid) {

		$mid = $this->conn->escape_string($mid);

		$mid = trim($mid);

		if(empty($mid))
			return -1;

		$sql = "insert into Car (M_ID) values ('" . $mid . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return mysqli_insert_id($this->conn);
		} else {
			return -1;
		}
	}

	public function newSale($carid, $cid, $eid, $price, $date) {

		$carid = $this->conn->escape_string($carid);
		$cid = $this->conn->escape_string($cid);
		$eid = $this->conn->escape_string($eid);
		$price = $this->conn->escape_string($price);
		$date = $this->conn->escape_string($date);

		$carid = trim($carid);
		$cid = trim($cid);
		$eid = trim($eid);
		$price = trim($price);
		$date = trim($date);

		if(empty($carid) || empty($cid) || empty($eid) || empty($price) || empty($date))
			return -1;

		$sql = "insert into Sale (Car_ID, C_ID, E_ID, Price, Date) values ('" . $carid . "', '" . $cid . "', '" . $eid . "', '" . $price . "', '" . $date . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return mysqli_insert_id($this->conn);
		} else {
			return -1;
		}
	}

	public function newService_Appt($cid, $carid, $eid, $datein, $dateout) {

		$cid = $this->conn->escape_string($cid);
		$carid = $this->conn->escape_string($carid);
		$eid = $this->conn->escape_string($eid);
		$datein = $this->conn->escape_string($datein);
		$dateout = $this->conn->escape_string($dateout);

		$cid = trim($cid);
		$carid = trim($carid);
		$eid = trim($eid);
		$datein = trim($datein);
		$dateout = trim($dateout);

		if(empty($cid) || empty($carid) || empty($eid) || empty($datein) || empty($dateout))
			return -1;

		$sql = "insert into Service_Appt(C_ID, Car_ID, E_ID, Date_In, Date_Out) values ('" . $cid . "', '" . $carid . "', '" . $eid . "', '" . $datein . "', '" . $dateout . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return mysqli_insert_id($this->conn);
		} else {
			return -1;
		}
	}

	public function newServices_Done($aid, $servid) {

		$aid = $this->conn->escape_string($aid);
		$servid = $this->conn->escape_string($servid);

		$aid = trim($aid);
		$servid = trim($servid);

		if(empty($aid) || empty($servid))
			return -1;

		$sql = "insert into Services_Done(A_ID, Serv_ID) values ('" . $aid . "', '" . $servid . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return 1;
		} else {
			return -1;
		}
	}


	public function newService($cost, $desc) {

		$cost = $this->conn->escape_string($cost);
		$desc = $this->conn->escape_string($desc);

		$cost = trim($cost);
		$desc = trim($desc);

		if(empty($cost) || empty($desc))
			return -1;

		$sql = "insert into Service (Cost, Description) values ('" . $cost . "', '" . $desc . "');";

		$result = $this->conn->query($sql);

		if($result) {
			return mysqli_insert_id($this->conn);
		} else {
			return -1;
		}
	}

	function toWhere($data) {
		$where = "";

		foreach($data as $key => $value) {
			if(empty($value)) continue;
			if(!empty($where)) $where .= " and";

			$where .= " " . $key . "='" . $value . "'";
		}

		return $where;
	}

	function getData($table, $data) {

		foreach($data as $key => $value) {
			$data[$key] = trim($this->conn->escape_string($value));
		}

		$sql = "select * from " . $table . " where" . $this->toWhere($data);

		$result = $this->conn->query($sql);

		$data = array();

		if($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
 				$data[] = $row;
 			}
		}
		return $data;
	}

	public function __destruct() {
		if(!$this->conn->connect_error)
			$this->conn->close();
	}
}
?>
