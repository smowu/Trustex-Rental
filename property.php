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
  $result = mysqli_query($connect,$sql);
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
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>