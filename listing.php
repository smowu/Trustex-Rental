<?php 
  session_start();

  $list_id = $_GET['id'];
  include("dbconnect.php");
  $sql = "SELECT *
          FROM listing, property
          WHERE listing.propertyID = property.propertyID AND listing.listingID = '$list_id'";
  $result = mysqli_query($connect,$sql);
  mysqli_close($connect);

  $listing = mysqli_fetch_assoc($result);

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="listing">
    <div class="default-container container-margin">
      <h1><?php echo $listing['propertyName'] ?></h1>
      <p>Listing ID: <?php echo sprintf("%012d",$listing['listingID']) ?></p>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>