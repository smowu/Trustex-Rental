<?php
  if (isset($_POST["ticketNo"])) {
    $ticket_no = $_POST["ticketNo"];
    if (isset($_POST["accept"])) {
      $new_status = "Accepted";
    } else if (isset($_POST["reject"])) {
      $new_status = "Rejected";
    }
    include("dbconnect.php");
    $sql = "UPDATE request SET
            requestStatus = '$new_status'
            WHERE ticketNo = '$ticket_no'";
    $result = mysqli_query($connect, $sql);
    mysqli_close($connect);

    if (!$result || $new_status == "Pending") {
      echo "<script>alert('Something went wrong!');</script>";
    } else if ($new_status == "Accepted") {
      echo "<script>alert('The renting request has been accepted!')</script>";
    } else if ($new_status == "Rejected") {
      echo "<script>alert('The renting request has been rejected!')</script>";
    }
  }
  echo "<script>window.location.replace('dashboard-landlord.php');</script>";
?>