<?php 
  // session_start(); 
  include("dbconnect.php"); 

  if (isset($connect)) {
    echo file_get_contents("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="dashboard">

  </body>
</html>
<?php
    echo file_get_contents("html/footer.html");
    mysqli_close($connect);
  }
?>