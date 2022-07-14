<?php
  include("dbconnect.php");
  $sql_update = "UPDATE request SET requestStatus = CASE 
                 WHEN rentEndDate < NOW() THEN 'Expired'
                 WHEN rentStartDate < NOW() THEN 'Active'
                 ELSE requestStatus
                 END
                 WHERE userID = '$id' AND (requestStatus = 'Accepted' OR requestStatus = 'Upcoming' OR requestStatus = 'Active')";
  $update_result = mysqli_query($connect, $sql_update);
  mysqli_close($connect);

  if (!$update_result) {
    echo "<script>alert('Failed to update request status!');</script>";
  }
?>