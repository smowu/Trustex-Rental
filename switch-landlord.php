<?php
  session_start();
  if (isset($_POST["application-id"]) && $_SESSION["userType"] == 'T') {
    include("dbconnect.php");
    $app_id = $_POST["application-id"];
    $sql = "SELECT applicationID, applicationStatus, administratorID
            FROM applications
            WHERE applicationID = '$app_id' AND applicationStatus = 'Approved' AND administratorID IS NOT NULL";
    $result = mysqli_query($connect,$sql);
    mysqli_close($connect);

    $appdata = mysqli_fetch_assoc($result);
    $admin = $appdata["administratorID"];

    if (mysqli_num_rows($result) != 0) {
      include("dbconnect.php");
      $sql1 = "UPDATE user SET userType = 'L' WHERE userID = ".$_SESSION["userID"]."";
      $result1 = mysqli_query($connect,$sql1);

      $sql2 = "INSERT INTO landlord (userID, administratorID) 
               VALUES('".$_SESSION["userID"]."','".$admin."')";
      $result2 = mysqli_query($connect,$sql2);
      mysqli_close($connect);

      if ($result1 && $result2) {
        echo "<script>alert('Successfully switched to Landlord Account!')</script>";
        $_SESSION['userType'] = 'L';
      } else {
        echo "<script>alert('Something went wrong!')</script>";
      }
    }
  }
  echo "<script>window.location.replace('dashboard.php');</script>";
?>