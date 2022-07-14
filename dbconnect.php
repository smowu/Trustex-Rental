<?php
  $user = "root";
  $pass = "";
  $host = "localhost";
  $dbname = "trustex";
  $port = "3307";

  $connect = mysqli_connect($host,$user,$pass,$dbname,$port) or die ("Error: ".mysqli_error());

  if (!isset($connect)) {
    die("<script>alert('Error: Failed to connect to the database!');</script>");
  }
?>