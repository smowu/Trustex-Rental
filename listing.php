<?php 
  session_start();

  $list_id = $_GET['id'];
  include("dbconnect.php");
  $sql = "SELECT *
          FROM listing, property
          WHERE listing.propertyID = property.propertyID AND listing.listingID = '$list_id'";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);

  $listing = mysqli_fetch_assoc($result);
  $prop_id = $listing["propertyID"];

  $propertyName = $listing["propertyName"];
  $propertyAddress = $listing["propertyAddress"];
  $propertyCity = $listing["propertyCity"];
  $propertyPoscode = $listing["propertyPoscode"];
  $propertyState = $listing["propertyState"];
  $propertyType = $listing["propertyType"];
  $propertyFloorLevel = $listing["propertyFloorLevel"];
  $propertyFloorSize = $listing["propertyFloorSize"];
  $propertyNumRooms = $listing["propertyNumRooms"];
  $propertyBathrooms = $listing["propertyBathrooms"];
  $propertyFurnishing = $listing["propertyFurnishing"];
  $propertyFacilities = $listing["propertyFacilities"];
  $propertyDesc = $listing["propertyDesc"];
  $rentPrice = $listing["rentPrice"];

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="listing">
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
      <div class="container-margin listing-section-container">
        <div class="listing-section-left">
          <form class="property-details" action="" method="POST" enctype="multipart/form-data">
            <h1><?php echo $propertyName ?></h1>
            <input class="property-h1" type="text" name="propertyName" value="<?php echo $propertyName ?>" placeholder="N/A" readonly><br><br>

            RM <input class="property-h1" type="text" name="rentPrice" value="<?php echo $rentPrice ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyFloorSize">Floor Size: </label><br>
            <input class="" type="text" name="propertyFloorSize" value="<?php echo $propertyFloorSize ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyNumRooms">No. of Rooms: </label><br>
            <input class="" type="text" name="propertyNumRooms" value="<?php echo $propertyNumRooms ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyBathrooms">No. of Bathrooms: </label><br>
            <input class="" type="text" name="propertyBathrooms" value="<?php echo $propertyBathrooms ?>" placeholder="N/A" readonly><br><br>


            <label for="propertyAddress">Address: </label><br>
            <input class="property-text-input" type="text" name="propertyAddress" value="<?php echo $propertyAddress ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyCity">City: </label><br>
            <input class="property-text-input" type="text" name="propertyCity" value="<?php echo $propertyCity ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyPoscode">Poscode: </label><br>
            <input class="property-text-input" type="text" name="propertyPoscode" value="<?php echo $propertyPoscode ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyState">State: </label><br>
            <input class="property-text-input" type="text" name="propertyState" value="<?php echo $propertyState ?>" placeholder="N/A" readonly><br><br>

            <h2>Details</h2><br>

            <p>Listing ID: <?php echo sprintf("%012d",$listing['listingID']) ?></p>
            <p>Property ID: <?php echo sprintf("%08d",$listing['propertyID']) ?></p><br>

            <label for="propertyType">Type: </label><br>
            <input class="property-text-input" type="text" name="propertyType" value="<?php echo $propertyType ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyFloorLevel">Floor Level: </label><br>
            <input class="property-text-input" type="text" name="propertyFloorLevel" value="<?php echo $propertyFloorLevel ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyFloorSize">Floor Size: </label><br>
            <input class="property-text-input" type="text" name="propertyFloorSize" value="<?php echo $propertyFloorSize ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyNumRooms">No. of Rooms: </label><br>
            <input class="property-text-input" type="text" name="propertyNumRooms" value="<?php echo $propertyNumRooms ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyBathrooms">No. of Bathrooms: </label><br>
            <input class="property-text-input" type="text" name="propertyBathrooms" value="<?php echo $propertyBathrooms ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyFurnishing">Furnishing: </label><br>
            <input class="property-text-input" type="text" name="propertyFurnishing" value="<?php echo $propertyFurnishing ?>" placeholder="N/A" readonly><br><br>

            <label for="propertyFacilities">Facilities: </label><br>
            <input class="property-text-input" type="text" name="propertyFacilities" value="<?php echo $propertyFacilities ?>" placeholder="N/A" readonly><br><br>

            <h2>Description</h2><br>
            <input class="property-text-input" type="text" name="propertyDesc" value="<?php echo $propertyDesc ?>" placeholder="N/A" readonly><br><br>

          <!--           
            <input id="cancel-update-property" type="submit" name="cancel-update-property" style="display: none;">
            <input class="edit-property-button" type="button" name="edit-property-button" onclick="toggleEditProperty()" value="Edit">
            <input id="update-property" class="update-property-button" type="submit" name="update-property" value="Save" style="display: none;">
            <input class="delete-property-button" type="button" name="delete-property-button" onclick="toggleDeleteForm()" value="Delete Property">
            <input id="delete-property" type="submit" name="delete-property" style="display: none;"> 
          -->

          </form><br>
        </div>
        <div class="listing-section-right">
          <div class="landlord-info-container">
            <div class="landlord-propic-container">
              <image src="" alt="">
            </div>
            <div class="landlord-details">

            </div>
            <button class="request-button">Request Inquiry</button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>