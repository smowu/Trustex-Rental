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
    <div class="default-container">
      <div class="property-images-container">
      <?php
        $dir = "assets/images/properties/property-" . sprintf('%06d', $prop_id) . "";
        $file = "";
        $thumb = [];
        if ($f = opendir($dir)) {
          $i = 0;
          while (($file = readdir($f)) != false) {
            if ($file != '.' && $file != '..') {
              $thumb[$i] = "assets/images/properties/property-" . sprintf('%06d', $prop_id) . "/" . $file . "";
              $i++;
            }        
          }
          closedir($f);
        }
        
        for ($i = 0; $i < count($thumb); $i++) {
      ?>
          <div class="property-banner-image">
            <image class="" src="<?php echo $thumb[$i] ?>">
          </div>
      <?php
        }
      ?>
      </div>
      <div class="container-margin">
        <h1><?php echo $property['propertyName'] ?></h1><br>
        <p>Property ID: <?php echo sprintf("%08d",$property['propertyID']) ?></p><br>

        <div class="property-details">
          <label for="propertyAddress">Address: </label><br>
          <p><?php echo $property['propertyAddress']?></p><br>

          <label for="propertyCity">City: </label><br>
          <p><?php echo $property['propertyCity']?></p><br>

          <label for="propertyPoscode">Poscode: </label><br>
          <p><?php echo $property['propertyPoscode']?></p><br>

          <label for="propertyState">State: </label><br>
          <p><?php echo $property['propertyState']?></p><br>

          <label for="propertyType">Type: </label><br>
          <p><?php echo $property['propertyType']?></p><br>

          <label for="propertyFloorLevel">Floor Level: </label><br>
          <p><?php echo $property['propertyFloorLevel']?></p><br>

          <label for="propertyFloorSize">Floor Size: </label><br>
          <p><?php echo $property['propertyFloorSize']?></p><br>

          <label for="propertyNumRooms">No. of Rooms: </label><br>
          <p><?php echo $property['propertyNumRooms']?></p><br>

          <label for="propertyBathrooms">No. of Bathrooms: </label><br>
          <p><?php echo $property['propertyBathrooms']?></p><br>

          <label for="propertyFurnishing">Furnishing: </label><br>
          <p><?php echo $property['propertyFurnishing']?></p><br>

          <label for="propertyFacilities">Facilities: </label><br>
          <p><?php echo $property['propertyFacilities']?></p><br>

          <label for="propertyDesc">Description: </label><br>
          <p><?php echo $property['propertyDesc']?></p><br>

          <label for="propertyNumRooms">Rent Price: </label><br>
          <p><?php echo $property['rentPrice']?></p><br>
        </div>
        


      </div>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>