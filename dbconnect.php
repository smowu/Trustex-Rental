<?php
  $user = "root";
  $pass = "";
  $host = "localhost";
  $dbname = "trustex";
  $port = "3307";

  $connect = mysqli_connect($host,$user,$pass,$dbname,$port);

  if (!isset($connect)) {
    echo("Error: Failed to connect to the database!");
  }
?>