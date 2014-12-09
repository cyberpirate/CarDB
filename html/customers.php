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
<?php
echo "<br>All Customers:";
resultToTable($db->allCustomers());
?>
</td>
</tr>
</table>

  </body>
</html>
