<?php 
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != "A") {
    header("Location: dashboard.php");
  }
  $reg_no = $_GET['id'];
  include("dbconnect.php");
  $sql = "SELECT * 
          FROM landlord, user
          WHERE landlord.userID = user.userID AND landlordRegNo = '$reg_no'";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);
  $landlord = mysqli_fetch_assoc($result);

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="property">
    <div class="default-container container-margin">
      <h1><?php echo $landlord['userFName'] . " " . $landlord['userLName'] ?></h1>
      <p>Landlord Registration No.: <?php echo sprintf('%06d', $landlord['landlordRegNo']) ?></p>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>