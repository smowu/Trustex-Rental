<?php 
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != "L") {
    header("Location: dashboard.php");
  }
  $prop_id = $_GET['id'];
  include("dbconnect.php");
  $sql = "SELECT * 
          FROM property
          WHERE propertyID = '$prop_id'";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);
  $property = mysqli_fetch_assoc($result);

  if ($property['landlordRegNo'] != $_SESSION['landlordRegNo']) {
    header("Location: dashboard-landlord.php");
  }
  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="property">
    <div class="default-container container-margin">
      <h1><?php echo $property['propertyName'] ?></h1>
      <p><?php echo sprintf("%08d",$property['propertyID']) ?></p>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>