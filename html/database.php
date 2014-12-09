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

	public function clearData() {
		$sql = "";
		$sql .= "delete from Service; ";
		$sql .= "delete from Services_Done; ";
		$sql .= "delete from Service_Appt; ";
		$sql .= "delete from Sale; ";
		$sql .= "delete from Car; ";
		$sql .= "delete from Make; ";
		$sql .= "delete from Employee; ";
		$sql .= "delete from Customer;";
		$result = $this->conn->multi_query($sql);
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

	public function newMake($make, $model, $year, $price) {

		$year = $this->conn->escape_string($year);
		$model = $this->conn->escape_string($model);
		$make = $this->conn->escape_string($make);
		$price = $this->conn->escape_string($price);

		$make = trim($make);
		$model = trim($model);
		$year = trim($year);
		$price = trim($price);

		if(empty($make) || empty($model) || empty($year) || empty($price))
			return -1;

		$sql = "insert into Make(M_Make, M_Model, M_Year, M_Cost) values ('" . $make . "', '" . $model . "', '" . $year . "', '" . $price . "');";

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

	function resultToData($result) {
		if(!$result)
			return array("err" => mysqli_error($this->conn));

		$data = array();

		if($result->num_rows > 0) {

			while($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}
		return $data;
	}

	function getData($table, $data) {

		foreach($data as $key => $value) {
			$data[$key] = trim($this->conn->escape_string($value));
		}

		$sql = "select * from " . $table . " where" . $this->toWhere($data);

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function latestPurchase() {
		$sql = "select C_Name as Name, (select max(Date) from Sale where Customer.C_ID = Sale.C_ID) as Date from Customer;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function cPurchase() {
		$sql = "select C_Name as Name, (select count(Sale.C_ID) from Sale where Sale.C_ID = Customer.C_ID) as Bought from Customer;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function cSpent() {
		$sql = "select C_Name as Name, (select sum(Sale.Price) from Sale where Sale.C_ID = Customer.C_ID) as Spent from Customer;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function cProfit() {
		$sql = "select C_Name as Name, (select sum((Sale.Price-Make.M_Cost)) from Sale, Make, Car where Sale.C_ID = Customer.C_ID and Sale.Car_ID = Car.Car_ID and Car.M_ID = Make.M_ID) as Profit from Customer;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function cLastAppt() {
		$sql = "select Customer.C_Name as Name, (select max(Date_In) from Service_Appt where Service_Appt.C_ID = Customer.C_ID) as Date from Customer;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function serviceTime() {
		$sql = "select A_ID as ID, (Date_Out-Date_In) as Days from Service_Appt;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function allCustomers() {
		$sql = "select * from Customer;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function allCars() {
		$sql = "select Car.Car_ID, Make.M_Make, Make.M_Model, Make.M_Year from Car, Make where Car.M_ID = Make.M_ID and Car_ID not in (select Car_ID from Sale);";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function getCarsOwned($cid){
		$cid = $this->conn->escape_string($cid);

		$cid = trim($cid);

		$sql = "select Car.Car_ID, Make.M_Make, Make.M_Model, Make.M_Year from Car, Make, Sale where Sale.C_ID = '" . $cid . "' and Sale.Car_ID = Car.Car_ID and Make.M_ID = Car.M_ID;";
		$result = $this->conn->query($sql);
		return $this->resultToData($result);
	}

	public function allServices() {
		$sql = "select * from Service;";

		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}

	public function __destruct() {
		if(!$this->conn->connect_error)
			$this->conn->close();
	}

	#Selsky writing PHP for the first time.
	public function statistics($beginDate, $endDate){
		$beginDate = $this->conn->escape_string($beginDate);
		$endDate = $this->conn->escape_string($endDate);

		$beginDate = trim($beginDate);
		$endDate = trim($endDate);

		$sql = "select distinct Make.M_Make, Make.M_Model, Make.M_Year, (select sum(s.Price-m.M_Cost) from Sale as s, Make as m, Car as c where c.M_ID = m.M_ID and c.Car_ID = s.Car_ID and Make.M_ID = m.M_ID) as Profit from Make, Car, Sale where Car.M_ID = Make.M_ID and Car.Car_ID = Sale.Car_ID and Sale.Date >= '" . $beginDate . "' and Sale.Date <= '" . $endDate . "';";
		$result = $this->conn->query($sql);

		return $this->resultToData($result);
	}
}
?>
