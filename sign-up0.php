<?php
  include("dbconnect.php");

  if (isset($_POST['signup-submit'])) {

    /* capture values from user sign-up form */
    $username = $_POST['username'];
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    $sql = "INSERT INTO user (userName,userEmail,userPassword) VALUES('".$username."','".$email."','".$password."')";

    mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));

    echo "<p>Data has been saved!</p>";

    mysqli_close($connect);
  }
?>
