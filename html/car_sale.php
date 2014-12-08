<!DOCTYPE html>
<html>
  <head>
    <title>Car Sale</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>

  <body>

    Customer:<br>
    <?php include("find_customer.html"); ?>

    <br>
    Employee:<br>
    <?php include("find_employee.html"); ?>

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

<script>

var carid = -1;
var carResults = <?php echo json_encode($data);?>;

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

  d.Price = d.Price.replace(/\D/g,'');

  if(!d.Price) {
    window.alert("Enter price");
    return;
  }

  if(!d.Date) {
    window.alert("Select date");
    return;
  }

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
