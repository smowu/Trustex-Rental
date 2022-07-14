<?php 
  session_start();

  $list_id = $_GET['id'];
  include("dbconnect.php");
  $sql1 = "SELECT *
          FROM listing, property
          WHERE listing.propertyID = property.propertyID AND listing.listingID = '$list_id'";
  $result = mysqli_query($connect, $sql1);

  $sql2 = "SELECT *
           FROM listing, property, landlord, user
           WHERE listingID = '$list_id' 
           AND listing.propertyID = property.propertyID 
           AND landlord.landlordRegNo = property.landlordRegNo 
           AND landlord.userID = user.userID";
  $landlord_result = mysqli_query($connect, $sql2);
  mysqli_close($connect);

  if (mysqli_num_rows($landlord_result) == 0) {
    header("Location: index.php");
  }
  $listing = mysqli_fetch_assoc($result);
  $landlord = mysqli_fetch_assoc($landlord_result);
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

  $price_per_sqft = sprintf("%.2f",$rentPrice / $propertyFloorSize);

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="listing">

    <div class="prompt-overlay confirm-remove-listing-container">
      <div class="prompt-container confirm-remove-listing">
        <div>
          <h3>
            Are you sure you want to remove this listing?
            <image class="icon close-icon" src="assets/icons/close.png" onclick="toggleDeleteForm()">
          </h3>
        </div>
        <div class="prompt-buttons-container">
          <input class="cancel-button" type="button" value="Cancel" name="cancel-delete" onclick="toggleDeleteForm()">
          <input class="confirm-delete-button" type="button" value="Confirm" name="confirm-remove" onclick="document.getElementById('confirm-remove-listing').click()">
        </div>
      </div>
    </div>

    <div class="default-container">
      <div class="property-images-container">
      <?php
        $dir = "assets/images/properties/property-" . sprintf('%06d', $prop_id) . "";
        $file = "";
        $images = [];
        if ($f = opendir($dir)) {
          $i = 0;
          while (($file = readdir($f)) != false) {
            if ($file != '.' && $file != '..') {
              $images[$i] = "assets/images/properties/property-" . sprintf('%06d', $prop_id) . "/" . $file . "";
              $i++;
            }        
          }
          closedir($f);
        }
        for ($i = 0; $i < count($images); $i++) {
      ?>
          <div class="property-banner-image">
            <image class="" src="<?php echo $images[$i] ?>">
          </div>
      <?php
        }
      ?>
      </div>
      <div class="container-margin listing-section-container">
        <div class="listing-section-left">
          <div class="listing-details">
            <h1><?php if ($propertyName != "") { echo $propertyName; } else { echo "N/A"; } ?></h1><br>
            <h2>RM <?php if ($rentPrice != "") { echo number_format(round($rentPrice,0)); } else { echo "N/A"; } ?>/month</h2><br>

            <div class="listing-details-room">
              <image class="icon listing-details-room-icon" src="assets/icons/bed.png" alt="Bedroom icon">
                <h2><?php if ($propertyNumRooms != "") { echo $propertyNumRooms; } else { echo "N/A"; } ?></h2>
              </image>
              <image class="icon listing-details-room-icon" src="assets/icons/bath.png" alt="Bedroom icon">
                <h2><?php if ($propertyBathrooms != "") { echo $propertyBathrooms; } else { echo "N/A"; } ?></h2>
              </image>
              <div>
                <h2><?php if ($propertyFloorSize != "") { echo $propertyFloorSize; } else { echo "N/A"; } ?> sqft</h2>
                <h2>RM <?php if ($price_per_sqft != "") { echo $price_per_sqft; } else { echo "N/A"; } ?> per sqft</h2>
              </div>
            </div><br>
            
            <p><?php if ($propertyAddress != "") { echo $propertyAddress; } else { echo "N/A"; } ?></p><br>

            <label for="propertyCity">City: </label><br>
            <p><?php if ($propertyCity != "") { echo $propertyCity; } else { echo "N/A"; } ?></p><br>

            <label for="propertyPoscode">Poscode: </label><br>
            <p><?php if ($propertyPoscode != "") { echo $propertyPoscode; } else { echo "N/A"; } ?></p><br>

            <label for="propertyState">State: </label><br>
            <p><?php if ($propertyState != "") { echo $propertyState; } else { echo "N/A"; } ?></p>
          </div>
          <hr>
          <div class="listing-details">
            <h2>Details</h2><br>

            <p>Listing ID: <?php echo sprintf("%012d",$listing['listingID']) ?></p>
            <p>Property ID: <?php echo sprintf("%08d",$listing['propertyID']) ?></p><br>

            <label for="propertyType">Type: </label><br>
            <p><?php if ($propertyType != "") { echo $propertyType; } else { echo "N/A"; } ?></p><br>

            <label for="propertyFloorLevel">Floor Level: </label><br>
            <p><?php if ($propertyFloorLevel != "") { echo $propertyFloorLevel; } else { echo "N/A"; } ?></p><br>

            <label for="propertyFloorSize">Floor Size: </label><br>
            <p><?php if ($propertyFloorSize != "") { echo $propertyFloorSize; } else { echo "N/A"; } ?> sqft</p><br>

            <label for="propertyFurnishing">Furnishing: </label><br>
            <p><?php if ($propertyFurnishing != "") { echo $propertyFurnishing; } else { echo "N/A"; } ?></p><br>

            <label for="propertyFacilities">Facilities: </label><br>
            <p><?php if ($propertyFacilities != "") { echo $propertyFacilities; } else { echo "N/A"; } ?></p>
          </div>
          <hr>
          <div class="listing-details">
            <h2>Description</h2><br>
            <p><?php if ($propertyDesc != "") { echo $propertyDesc; } else { echo "N/A"; } ?></p><br>
          </div>
          <br>
          <?php
            if (isset($_SESSION['userType']) && $_SESSION['userType'] == 'L' && $_SESSION['landlordRegNo'] == $landlord['landlordRegNo']) {
          ?>
              <a class="return-dashboard" href="dashboard.php">
                <img src="assets/icons/back-button.png"></img>
                <h4>Return to Dashboard</h4>
              </a>
          <?php
            } else if ($_SESSION['userType'] == 'A' && isset($_GET['source']) && $_GET['source'] == 'details') {
          ?>
              <a class="return-dashboard" href="landlord-details.php?id=<?php echo $landlord['landlordRegNo']?>">
                <img src="assets/icons/back-button.png"></img>
                <h4>Back</h4>
              </a>
          <?php
            } else {
          ?>
              <a class="return-dashboard" href="index.php">
                <img src="assets/icons/back-button.png"></img>
                <h4>Back</h4>
              </a>
          <?php
            }
          ?>
        </div>
        <div class="listing-section-right">
          <?php 
            if ((isset($_SESSION['landlordRegNo']) && $_SESSION['landlordRegNo'] == $landlord['landlordRegNo']) || $_SESSION['userType'] == 'A') {
          ?>
            <form class="listing-landlord-form" method="POST">
              <input class="property-edit-button" type="button" value="Manage Property" name="edit-property" onclick="location.href='property.php?id=<?php echo $listing['propertyID'] ?>&action=edit'">
              <input class="remove-listing-button" type="button" value="Remove Listing" name="remove-listing" onclick="toggleDeleteForm()">
              <input id="confirm-remove-listing" type="submit" value="" name="remove-listing" style="display: none;">
            </form>
            
          <?php
            } else {
          ?>
          <div class="landlord-info-container">
            <div class="landlord-propic-container">
              <div class="propic-container">
                <?php $landlord_propic = "assets/images/users/user-".sprintf('%010d', $landlord["userID"])."/profile-picture/profile-picture.png" ?>
                <image class="profile-pic" src="<?php echo $landlord_propic ?>" onerror="this.onerror=null; this.src='assets/images/profile-default.png'">
              </div>
            </div>
            <div class="landlord-details">
              <p><b><?php echo $landlord["userFName"] . " " . $landlord["userLName"] ?></b></p>
              <p>Reg. No.: <?php echo sprintf('%06d',$landlord["landlordRegNo"]) ?></p>
              <p>Tel: <?php echo $landlord["userPhoneNo"] ?></p>
            </div>
          <?php
              $button_link = "login.php";
              $button_text = "Log In to Request Inquiry";
              if (isset($_SESSION["userID"])) {
                $button_link = "createRequest.php?id=" . $list_id . "";
                $button_text = "Request Inquiry";
              }
              if (!(isset($_SESSION["userID"])) || !(isset($_SESSION['landlordRegNo'])) || $_SESSION['landlordRegNo'] != $landlord['landlordRegNo']) {
          ?>
            <a href="<?php echo $button_link ?>">
              <button class="request-button"><?php echo $button_text ?></button>
            </a>
          <?php
              }
            }
          ?>
            
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");

  if (isset($_POST["remove-listing"])) {
    
    include("dbconnect.php");
    $sql = "SELECT listingID, requestStatus
            FROM request
            WHERE listingID = '$list_id' AND (requestStatus = 'Upcoming' OR requestStatus = 'Active' OR requestStatus = 'Pending')";
    $result = mysqli_query($connect, $sql);
    mysqli_close($connect);

    if (mysqli_num_rows($result) != 0) {
      echo "<script>alert('There are either Pending, Upcoming, or Active request on this listing!')</script>";
    } else {
      include("dbconnect.php");
      $sql = "DELETE FROM listing 
              WHERE listingID = '$list_id'";
      $result = mysqli_query($connect, $sql);
      mysqli_close($connect);
    
      if ($result) {
        echo "<script>alert('Successfully removed property from listing!');</script>";
        echo "<script>window.location.replace('dashboard-landlord.php');</script>";
      } else {
        echo "<script>alert('Something went wrong! Failed to delete the listing.');</script>";
      }
    }
  }
?>
<script>
  function toggleDeleteForm() {
    $(".confirm-remove-listing-container").fadeToggle(100,"swing");
  }

  $(document).mouseup(function(e) {
    var confirmform = $(".confirm-remove-listing");
    var container = $(".confirm-remove-listing-container");
    if (!confirmform.is(e.target) && confirmform.has(e.target).length == 0) {
      container.fadeOut(100,"swing");
    }
  });
</script>