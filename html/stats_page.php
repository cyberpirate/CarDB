<?php

require_once("database.php");
$db = new Database();

function resultToTable($result) {
  if(count($result) == 0)
    return;

  echo "<table>";

  echo "<tr>";
  $keys = array();
  foreach($result[0] as $key => $value) {
    $keys[] = $key;
    echo "<td>" . $key . "</td>";
  }
  echo "</tr>";


  foreach($result as $x) {
    echo "<tr>";

    for($i = 0; $i < count($keys); $i++) {
      echo "<td>" . $x[$keys[$i]] . "</td>";
    }

    echo "</tr>";
  }


  echo "</table>";
}

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Stats</title>
  </head>

  <body>
    <table>
      <tr>
    <?php include("sidebar.html"); ?>


    <td>
<table>
<?php
echo "<tr>";
echo "<td>";
echo "Latest Purchase:";
resultToTable($db->latestPurchase());
echo "</td>";
echo "<td>";
echo "<br>Total vehicles per customer:";
resultToTable($db->cPurchase());
echo "</td>";
echo "<td>";
echo "<br>Total spent per customer:";
resultToTable($db->cSpent());
echo "</td>";
echo "</tr>";

echo "<tr>";
echo "<td>";
echo "<br>Total profit per customer:";
resultToTable($db->cProfit());
echo "</td>";
echo "<td>";
echo "<br>Last Appointment per customer:";
resultToTable($db->cLastAppt());
echo "</td>";
echo "<td>";
echo "<br>Service time per Appointment:";
resultToTable($db->serviceTime());
echo "</td>";
echo "</tr>";
#echo "<br>All Customers:";
#resultToTable($db->allCustomers());
?>
</table>
</td>
</tr>
</table>

  </body>
</html>
