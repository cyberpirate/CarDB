<!DOCTYPE html>
<html>
  <head>
    <title>Insert Data</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>

  <body>

    Customer:<br>
    <?php include("find_customer.html"); ?>
    <br>

    Employee:<br>
    <?php include("find_employee.html"); ?>
    <br>

    Make:<br>
    <?php include("find_make.html"); ?>
    <br>

    Service:<br>
    <?php include("add_service.html"); ?>
    <br>

    <button type="button" onclick="location.reload()">Add another</button>
</body>
</html>
