<?php 
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != "L") {
    header("Location: dashboard.php");
  }
  $ticket = $_GET['t'];
  include("dbconnect.php");
  $sql = "SELECT ticketNo, requestTimestamp, request.listingID, list.propertyName, requestType, user.userName
          FROM request
          LEFT JOIN user ON request.userID = user.userID
          LEFT JOIN (
            SELECT propertyName, listingID, landlordRegNo
            FROM property, listing
            WHERE listing.propertyID = property.propertyID
          ) AS list ON request.listingID = list.listingID";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);
  $request = mysqli_fetch_assoc($result);

  // if ($request['landlordRegNo'] != $_SESSION['landlordRegNo']) {
  //   header("Location: dashboard-landlord.php");
  // }
  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="property">
    <div class="default-container container-margin">
      <h1><?php echo $request['propertyName'] ?></h1><br>
      <p>Ticket No.: <?php echo sprintf("%08d",$request['ticketNo']) ?></p>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>