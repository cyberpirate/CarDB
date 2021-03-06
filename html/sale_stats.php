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


    Range of stats:<br>
    <div id="dateRange">
      <form action="#" name="range">
          From <input type="date" name="start"> to <input type="date" name="end"><br><br>
          <input type="button" value="Submit" onclick="getStats()">
      </form>
    </div>

    <div id="statResults">
    </div>
</td>
</tr>
</table>
  </body>

  <script>

getStats = function() {
  var range = document.forms["range"];

  var d = {
    stat: "statPage",
    start: range.elements["start"].value.replace(/-/g, ""),
    end: range.elements["end"].value.replace(/-/g, "")
  };

  $.ajax({
    url: "stats.php",
    dataType: "json",
    type: "POST",
    data: d,
    success: function(data) {
      if(data instanceof Array && data.length != 0) {

        var html = "<table>";
        html += "<tr><td>Make</td><td>Model</td><td>Year</td><td>Profit</td></tr>";
        for(x in data) {
          html += "<tr><td>" + data[x].M_Make + "</td><td>" + data[x].M_Model + "</td><td>" + data[x].M_Year + "</td><td>$" + data[x].Profit + "</td></tr>";
        }

        html += "</table>";

        document.getElementById("statResults").innerHTML = html;

      } else {
        window.alert("failed");
      }
    }
  });
}

  </script>
</html>
