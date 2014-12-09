<!DOCTYPE html>
<html>
  <head>
    <title>Service</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>

  <body>
<table>
  <tr>
    <?php include("sidebar.html"); ?>
    <td>

    Customer:<br>
    <?php include("find_customer.html"); ?>
    <br>

    Employee:<br>
    <?php include("find_employee.html"); ?>
    <br>

    Car to be serviced:<br>
    <div id="carData">
      <button type="button" onclick="searchCars()">Search</buton>
    </div>
    <br>

    Services:<br>
    <div id="serviceData">
      <?php
        require_once("database.php");

        $db = new Database();
        $data = $db->allServices();

        if(count($data) == 0) {
          echo "services found";
        } else {
          $results = "<form><table>";
          $results .= "<tr><td></td><td>Description</td><td>Cost</td></tr>";

          for($i = 0; $i < count($data); $i++) {
            $results .= "<tr>";
            $results .= "<td><input type=\"checkbox\" name=\"serviceResult\" value=\"" . $i . "\"></td>";
            $results .= '<td>' . $data[$i]["Description"] . '</td>';
            $results .= '<td>$' . $data[$i]["Cost"] . '</td>';
            $results .= "</tr>";
          }

          $results .= '</table><input type="button" value="Select" onclick="setServiceFromRadio()"/></form>';

          echo $results;
        }
      ?>
    </div>
    <br>

    Date of appointment:<br>
    <div id="dateData">
      <form action="#" name="service">
          From <input type="date" name="Date_In"> to <input type="date" name="Date_Out"><br><br>
          <input type="button" value="Submit" onclick="addAppt()">
      </form>
    </div>
</td>
</tr>
</table>
  </body>

<script>

document.getElementById("cSubmit").style.display = "none";

var carResults;
var carid = -1;

var serviceResults = <?php echo json_encode($data);?>;
var services = [];

searchCars = function() {
  if(cid == -1) {
    window.alert("Select a customer");
    return;
  }

  d = {
    stat: "carsOwned",
    cid: cid
  };

  $.ajax({
    url: "stats.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {

      if(data.length == 0) {
        window.alert("no results");
        return;
      }

      if(data.length == 1) {
        setCar(data[0].Car_ID, data[0].M_Make, data[0].M_Model, data[0].M_Year);
        return;
      }

      carResults = data;

      var results = "<form><table>";

      for(i = 0; i < data.length; i++) {
        results += '<tr><td><input type="radio" name="carResult" value="' + i + '"></td><td>' + data[i].Car_ID + '</td><td>' + data[i].M_Make + '</td><td>' + data[i].M_Model + '</td><td>' + data[i].M_Year + '</td></tr>';
      }

      results += '</table><input type="button" value="Select" onclick="setCarFromRadio()"/></form>';

      document.getElementById("carData").innerHTML = results;
    }
  });
}

setCar = function(id, make, model, year) {
  carid = id;
  document.getElementById("carData").innerHTML = "<table><tr><td>" + carid + "</td><td>" + make + "</td><td>" + model + "</td><td>" + year + "</td></tr></table>";
}

setCarFromRadio = function() {
  var index = $('input[name=carResult]:checked').val();

  setCar(carResults[index].Car_ID, carResults[index].M_Make, carResults[index].M_Model, carResults[index].M_Year);
}

setServiceFromRadio = function() {
  var boxes = $('input[name=serviceResult]:checked');

  for(i = 0; i < boxes.length; i++) {
    services.push(boxes[i].getAttribute("value"));
  }

  var html = "<table>";
  var total = 0;

  for(x in services) {
    var service = serviceResults[services[x]];
    html += "<tr><td>" + service.Description + "</td><td>$" + service.Cost + "</td></tr>";
    total += parseInt(service.Cost);
  }

  html += "<tr><td>Total:</td><td>$" + total + "</td></tr>";
  html += "</table>";

  document.getElementById("serviceData").innerHTML = html;
}

addAppt = function() {
  var service = document.forms["service"];

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

  if(services.length == 0) {
    window.alert("Select at least one Service");
    return;
  }

  var d = {
    table: "Service_Appt",
    C_ID: cid,
    E_ID: eid,
    Car_ID: carid,
    Date_In: service.elements["Date_In"].value.replace(/-/g, ""),
    Date_Out: service.elements["Date_Out"].value.replace(/-/g, "")
  };

  if(!d.Date_In || !d.Date_Out) {
    window.alert("Select dates");
    return;
  }

  $.ajax({
    url: "add.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {
      if(typeof data.id != 'undefined' && data.id != -1) {
        var aid = data.id;

        for(x in services) {
          var service = serviceResults[services[x]];
          $.ajax({
            url: "add.php",
            dataType: "json",
            type: "POST",
            data: {
              table: "Services_Done",
              A_ID: aid,
              Serv_ID: service.Serv_ID
            }
          });
        }
        window.alert("success");
        onSuccess();

      } else {
        window.alert("failed");
      }
    }
  });
}

onSuccess = function() {
  var dateData = document.getElementById("dateData");
  dateData.innerHTML = "From " + service.elements["Date_In"].value + " to " + service.elements["Date_Out"].value;
  window.print();
}

</script>

</html>
