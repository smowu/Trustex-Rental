<?php 
  session_start();
  $list_id = $_GET['id'];
  if (!isset($_SESSION['userID'])) {
    header("Location: listing.php?id=".$list_id."");
  }
  include("dbconnect.php");
  $sql = "SELECT *
          FROM listing, property
          WHERE listing.propertyID = property.propertyID AND listing.listingID = '$list_id'";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);
  $request = mysqli_fetch_assoc($result);

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="createRequest">
    <div class="default-container container-margin">
      <h1>Request Inquiry</h1><br>
      <form class="request-details" action="" method="POST" enctype="multipart/form-data">
        <h1><?php echo $request['propertyName'] ?></h1><br>
        <p>Listing ID: <?php echo sprintf("%012d",$request['listingID']) ?></p><br>

        <div class="calendar-container">
          <h2>Select Date</h2><br>
          <label for="start-date">Start Date</label>
          <input type="date" name="start-date">
          <label for="start-date">End Date</label>
          <input type="date" name="start-date">
        </div><br>

        <input type="reset" name="clear-form" value="Clear Form">
        <input type="submit" name="confirm-request" value="Confirm Request">
      </form>
      
    </div>
  </body>
</html>
<?php
  include("html/footer.html");

  if (isset($_POST["confirm-request"])) {

    include("dbconnect.php");



    // $sql = "INSERT INTO request";
    // $result = mysqli_query($connect,$sql);
    $result = true;
    mysqli_close($connect);

    if ($result) {
      echo "<script>alert('Your renting request has been sent!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong! Failed to send your inquiry.')</script>";
    }
  }
?>