<?php
  session_start();
  if (isset($_POST["id"]) && $_SESSION["userType"] == 'A') {
    $new_status = "Pending";
    $approver = $_SESSION["userID"];
    if (isset($_POST["approve"])) {
      $new_status = "Approved";
    } else if (isset($_POST["reject"])) {
      $new_status = "Rejected";
    }
    include("dbconnect.php");
    $sql = "UPDATE applications SET 
            applicationStatus = '$new_status', 
            administratorID = '$approver'
            WHERE applicationID = ".$_POST["id"]."";
    $update_result = mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));
    mysqli_close($connect);

    if (!$update_result || $new_status == "Pending") {
      echo "<script>alert('Something went wrong!');</script>";
    } else if ($new_status == "Approved") {
      echo "<script>alert('Application Approved!')</script>";
    } else if ($new_status == "Rejected") {
      echo "<script>alert('Application successfully Rejected!')</script>";
    }
  }
  echo "<script>window.location.replace('dashboard-admin.php');</script>";
?>