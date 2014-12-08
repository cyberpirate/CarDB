<!DOCTYPE html>
<html>
  <head>
    <title>Car Sale</title>
  </head>

  <body>

    Customer:<br>
    <div id="customerData">
      <form action="#" name="customer">
        <table>
          <tr><td>Name:</td><td><input type="text" name="C_Name"></td></tr>
          <tr><td>Address:</td><td><input type="text" name="C_Address"></td></tr>
          <tr><td>Phone:</td><td><input type="text" name="C_Phone"></td></tr>
        </table>
        <input type="button" value="Submit" onclick="addCustomer()">
        <input type="button" value="Search" onclick="searchCustomer()">
      </form>
    </div>

    <br>
    Employee:<br>
    <div id="employeeData">
      <form action="#" name="employee">
        <table>
          <tr><td>Name:</td><td><input type="text" name="E_Name"></td></tr>
          <tr><td>Phone:</td><td><input type="text" name="E_Phone"></td></tr>
        </table>
        <input type="button" value="Submit" onclick="addEmployee()">
        <input type="button" value="Search" onclick="searchEmployee()">
      </form>
    </div>

    <br>
    Car:<br>
    <div id="carData">
      <?php
        require_once("database.php");

        $db = new Database();
        $data = $db->allCars();

        if(count($data) == 0) {
          echo "no cars to sell";
        } else {
          $results = "<form><table>";
          $results .= "<tr><td></td><td>Car ID</td><td>Make</td><td>Model</td><td>Year</td></tr>";

          for($i = 0; $i < count($data); $i++) {
            $results .= "<tr>";
            $results .= "<td><input type=\"radio\" name=\"carResult\" value=\"" . $i . "\"></td>";
            $results .= '<td>' . $data[$i]["Car_ID"] . '</td>';
            $results .= '<td>' . $data[$i]["M_Make"] . '</td>';
            $results .= '<td>' . $data[$i]["M_Model"] . '</td>';
            $results .= '<td>' . $data[$i]["M_Year"] . '</td>';
            $results .= "</tr>";
          }

          $results .= '</table><input type="button" value="Select" onclick="setCarFromRadio()"/></form>';

          echo $results;
        }
      ?>
    </div>

    <br>
    Sale:
    <div id="saleData">
      <form action="#" name="sale">
        <table>
          <tr><td>Price:</td><td><input type="number" name="Price"></td></tr>
          <tr><td>Date:</td><td><input type="date" name="Date"></td></tr>
        </table>
        <input type="button" value="Submit" onclick="addSale()">
      </form>
    </div>
  </body>

<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>

var cid = -1;
var cResults;

var eid = -1;
var eResults;

var carid = -1;
var carResults = <?php echo json_encode($data);?>;

addCustomer = function() {
  var customer = document.forms["customer"];

  var d = {
    table: "Customer",
    C_Name: customer.elements["C_Name"].value,
    C_Address: customer.elements["C_Address"].value,
    C_Phone: customer.elements["C_Phone"].value
  };

  $.ajax({
    url: "add.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {
      if(typeof data.id != 'undefined') {
        setCustomer(data.id, d.C_Name, d.C_Address, d.C_Phone);
      }
    }
  });
};

setCustomer = function(id, name, address, phone) {
  cid = id;
  document.getElementById("customerData").innerHTML = "<table><tr><td>" + name + "</td><td>" + address + "</td><td>" + phone + "</td></tr></table>";
}

searchCustomer = function() {
  var customer = document.forms["customer"];

  var d = {
    table: "Customer"
  };

  if(customer.elements["C_Name"].value) {
    d.C_Name = customer.elements["C_Name"].value;
  }

  if(customer.elements["C_Address"].value) {
    d.C_Address = customer.elements["C_Address"].value;
  }

  if(customer.elements["C_Phone"].value) {
    d.C_Phone = customer.elements["C_Phone"].value;
  }

  if(Object.keys(d).length == 1) {
    window.alert("enter search terms");
    return;
  }

  $.ajax({
    url: "get.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {
      if(data.length == 0) {
        window.alert("no results");
        return;
      }

      if(data.length == 1) {
        setCustomer(data[0].C_ID, data[0].C_Name, data[0].C_Address, data[0].C_Phone);
        return;
      }

      cResults = data;

      var results = "<form><table>";

      for(i = 0; i < data.length; i++) {
        results += '<tr><td><input type="radio" name="cResult" value="' + i + '"></td><td>' + data[i].C_Name + '</td><td>' + data[i].C_Address + '</td><td>' + data[i].C_Phone + '</td></tr>';
      }

      results += '</table><input type="button" value="Select" onclick="setCustomerFromRadio()"/></form>';

      document.getElementById("customerData").innerHTML = results;
    }
  });
};

setCustomerFromRadio = function() {
  var index = $('input[name=cResult]:checked').val();

  setCustomer(cResults[index].C_ID, cResults[index].C_Name, cResults[index].C_Address, cResults[index].C_Phone);
};

addEmployee = function() {
  var employee = document.forms["employee"];

  var d = {
    table: "Employee",
    E_Name: employee.elements["E_Name"].value,
    E_Phone: employee.elements["E_Phone"].value
  };

  $.ajax({
    url: "add.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {
      if(typeof data.id != 'undefined') {
        setEmployee(data.id, d.E_Name, d.E_Phone);
      }
    }
  });
};

setEmployee = function(id, name, phone) {
  eid = id;
  document.getElementById("employeeData").innerHTML = "<table><tr><td>" + name + "</td><td>" + phone + "</td></tr></table>";
}

searchEmployee = function() {
  var employee = document.forms["employee"];

  var d = {
    table: "Employee"
  };

  if(employee.elements["E_Name"].value) {
    d.E_Name = employee.elements["E_Name"].value;
  }

  if(employee.elements["E_Phone"].value) {
    d.E_Phone = employee.elements["E_Phone"].value;
  }

  if(Object.keys(d).length == 1) {
    window.alert("enter search terms");
    return;
  }

  $.ajax({
    url: "get.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {
      if(data.length == 0) {
        window.alert("no results");
        return;
      }

      if(data.length == 1) {
        setEmplyee(data[0].E_ID, data[0].E_Name, data[0].E_Phone);
        return;
      }

      eResults = data;

      var results = "<form><table>";

      for(i = 0; i < data.length; i++) {
        results += '<tr><td><input type="radio" name="eResult" value="' + i + '"></td><td>' + data[i].E_Name + '</td><td>' + data[i].E_Phone + '</td></tr>';
      }

      results += '</table><input type="button" value="Select" onclick="setEmployeeFromRadio()"/></form>';

      document.getElementById("employeeData").innerHTML = results;
    }
  });
};

setEmployeeFromRadio = function() {
  var index = $('input[name=eResult]:checked').val();

  setEmployee(eResults[index].E_ID, eResults[index].E_Name, eResults[index].E_Phone);
};

addSale = function() {
  var sale = document.forms["sale"];

  if(cid == -1) {
    window.alert("Select a customer");
    return;
  }

  if(eid == -1) {
    window.alert("Select an employee");
    return;
  }

  if(carid == -1) {
    window.alert("Select a car");
    return;
  }

  var d = {
    table: "Sale",
    C_ID: cid,
    E_ID: eid,
    Car_ID: carid,
    Price: sale.elements["Price"].value,
    Date: sale.elements["Date"].value.replace(/-/g, "")
  };

  $.ajax({
    url: "add.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {
      if(typeof data.id != 'undefined' && data.id != -1) {
        window.alert("Sale added");
      } else {
        window.alert("failed");
      }
    }
  });
}

setCarFromRadio = function() {
  var index = $('input[name=carResult]:checked').val();

  carid = index;
  document.getElementById("carData").innerHTML = "<table><tr><td>" + carResults[index].Car_ID + "</td><td>" + carResults[index].M_Make + "</td><td>" + carResults[index].M_Model + "</td><td>" + carResults[index].M_Year + "</td></tr></table>";
};

</script>

</body>
</html>
