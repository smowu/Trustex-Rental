<?php 
  // session_start(); 
  include("dbconnect.php"); 

  if (isset($connect)) {
    include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="privacy-policy">

  </body>
</html>
<?php
    include("html/footer.html");
    mysqli_close($connect);
  }
?>