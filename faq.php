<?php 
  include("dbconnect.php"); 

  if (isset($connect)) {
    echo file_get_contents("html/header.html");
    echo file_get_contents("html/faq.html");
    echo file_get_contents("html/footer.html");
    mysqli_close($connect);
  }
?>