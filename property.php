<?php 
  session_start();
  if (!isset($_SESSION['userID']) || ($_SESSION['userType'] != "L" && $_SESSION['userType'] != "A")) {
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

  if ($property['landlordRegNo'] != $_SESSION['landlordRegNo'] && $_SESSION['userType'] != "A") {
    header("Location: dashboard-landlord.php");
  }
  
  $propertyName = $property["propertyName"];
  $propertyAddress = $property["propertyAddress"];
  $propertyCity = $property["propertyCity"];
  $propertyPoscode = $property["propertyPoscode"];
  $propertyState = $property["propertyState"];
  $propertyType = $property["propertyType"];
  $propertyFloorLevel = $property["propertyFloorLevel"];
  $propertyFloorSize = $property["propertyFloorSize"];
  $propertyNumRooms = $property["propertyNumRooms"];
  $propertyBathrooms = $property["propertyBathrooms"];
  $propertyFurnishing = $property["propertyFurnishing"];
  $propertyFacilities = $property["propertyFacilities"];
  $propertyDesc = $property["propertyDesc"];
  $rentPrice = $property["rentPrice"];

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="property">

    <div class="prompt-overlay confirm-delete-property-container">
      <div class="prompt-container confirm-delete-property">
        <div>
          <h3>
            Are you sure you want to delete this property?
            <image class="icon close-icon" src="assets/icons/close.png" onclick="toggleDeleteForm()">
          </h3>
        </div>
        <div class="prompt-buttons-container">
          <input class="cancel-button" type="button" value="Cancel" name="cancel-delete" onclick="toggleDeleteForm()">
          <input class="confirm-delete-button" type="button" value="Confirm" name="confirm-delete" onclick="document.getElementById('delete-property').click()">
        </div>
      </div>
    </div>

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
            <h1 class="property-details-text"><?php echo $propertyName ?></h1>
            <input class="property-text-h1 property-text-input" type="text" name="propertyName" value="<?php echo $propertyName ?>" placeholder="N/A" readonly><br>

            <p>Property ID: <?php echo sprintf("%08d",$property['propertyID']) ?></p><br>
            <input type="text" name="propertyID" value="<?php echo $property['propertyID'] ?>" style="display: none;">

            <div class="property-detail">
              <label for="propertyAddress">Address</label><br>
              <p class="property-details-text"><?php echo $propertyAddress ?></p>
              <input class="property-text-input" type="text" name="propertyAddress" value="<?php echo $propertyAddress ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyCity">City</label><br>
              <p class="property-details-text"><?php echo $propertyCity ?></p>
              <input class="property-text-input" type="text" name="propertyCity" value="<?php echo $propertyCity ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyPoscode">Poscode</label><br>
              <p class="property-details-text"><?php echo $propertyPoscode ?></p>
              <input class="property-text-input" type="text" name="propertyPoscode" value="<?php echo $propertyPoscode ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyState">State</label><br>
              <p class="property-details-text"><?php echo $propertyState ?></p>
              <input class="property-text-input" type="text" name="propertyState" value="<?php echo $propertyState ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyType">Type</label><br>
              <p class="property-details-text"><?php echo $propertyType ?></p>
              <input class="property-text-input" type="text" name="propertyType" value="<?php echo $propertyType ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyFloorLevel">Floor Level</label><br>
              <p class="property-details-text"><?php echo $propertyFloorLevel ?></p>
              <input class="property-text-input" type="text" name="propertyFloorLevel" value="<?php echo $propertyFloorLevel ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyFloorSize">Floor Size</label><br>
              <p class="property-details-text"><?php echo $propertyFloorSize ?></p>
              <input class="property-text-input" type="text" name="propertyFloorSize" value="<?php echo $propertyFloorSize ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyNumRooms">No. of Rooms</label><br>
              <p class="property-details-text"><?php echo $propertyNumRooms ?></p>
              <input class="property-text-input" type="text" name="propertyNumRooms" value="<?php echo $propertyNumRooms ?>" placeholder="N/A" readonly>
              <br>
              <label for="propertyBathrooms">No. of Bathrooms</label><br>
              <p class="property-details-text"><?php echo $propertyBathrooms ?></p>
              <input class="property-text-input" type="text" name="propertyBathrooms" value="<?php echo $propertyBathrooms ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyFurnishing">Furnishing</label><br>
              <p class="property-details-text"><?php echo $propertyFurnishing ?></p>
              <input class="property-text-input" type="text" name="propertyFurnishing" value="<?php echo $propertyFurnishing ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyFacilities">Facilities</label><br>
              <p class="property-details-text"><?php echo $propertyFacilities ?></p>
              <input class="property-text-input" type="text" name="propertyFacilities" value="<?php echo $propertyFacilities ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyDesc">Description</label><br>
              <p class="property-details-text"><?php echo $propertyDesc ?></p>
              <input class="property-text-input" type="text" name="propertyDesc" value="<?php echo $propertyDesc ?>" placeholder="N/A" readonly>
            </div>
            <div class="property-detail">
              <label for="propertyNumRooms">Rent Price</label><br>
              <p class="property-details-text"><h2>RM <?php echo $rentPrice ?></h2></p>
              <input class="property-text-input" type="text" name="rentPrice" value="<?php echo $rentPrice ?>" placeholder="N/A" readonly>
            </div>

            <input id="listing-submit" type="submit" name="listing-submit" style="display: none;">
            <input id="cancel-update-property" type="submit" name="cancel-update-property" style="display: none;">
            <input id="update-property" type="submit" name="update-property" value="Save" style="display: none;">
            <input id="delete-property" type="submit" name="delete-property" style="display: none;">
          </form> 
          <br>
          <?php 
            if ($_SESSION['userType'] == 'A' && isset($_GET['source']) && $_GET['source'] == 'details') {
          ?>
              <a class="return-dashboard" href="landlord-details.php?id=<?php echo $property['landlordRegNo']?>">
                <img src="assets/icons/back-button.png"></img>
                <h4>Back</h4>
              </a>
          <?php
            } else {
          ?>
              <a class="return-dashboard" href="dashboard.php">
                <img src="assets/icons/back-button.png"></img>
                <h4>Return to Dashboard</h4>
              </a>
          <?php
            }
          ?>
        </div>
        <div class="property-section-right">
          <form class="property-manage-form" method="POST">
            <input class="property-manage-button" type="submit" name="listing-submit" value="Add to Listing">
            <input class="property-manage-button update-property-button" type="button" name="" value="Save" onclick="saveEditProperty()" style="display: none;">
            <input class="property-manage-button edit-property-button" type="button" name="edit-property-button" onclick="toggleEditProperty()" value="Edit">
            <input class="property-delete-button delete-property-button" type="button" name="delete-property-button" onclick="toggleDeleteForm()" value="Delete Property">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");

  if (isset($_POST['listing-submit'])) {
    include("dbconnect.php");
    $sql = "INSERT INTO listing (propertyID)
            VALUES ('".$_POST['propertyID']."')";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    mysqli_close($connect);

    if ($result) {
      echo "<script>alert('Your property has been successfully listed!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }

  if (isset($_POST['update-property'])) {
    include("dbconnect.php");

    if ($_POST['propertyName'] != $property['propertyName']) {
      $propertyName = mysqli_real_escape_string($connect, $_POST['propertyName']);
    }
    if ($_POST['propertyAddress'] != $property['propertyAddress']) {
      $propertyAddress = mysqli_real_escape_string($connect, $_POST['propertyAddress']);
    }
    if ($_POST['propertyCity'] != $property['propertyCity']) {
      $propertyCity = mysqli_real_escape_string($connect, $_POST['propertyCity']);
    }
    if ($_POST['propertyPoscode'] != $property['propertyPoscode']) {
      $propertyPoscode = mysqli_real_escape_string($connect, $_POST['propertyPoscode']);
    }
    if ($_POST['propertyState'] != $property['propertyState']) {
      $propertyState = mysqli_real_escape_string($connect, $_POST['propertyState']);
    }
    if ($_POST['propertyType'] != $property['propertyType']) {
      $propertyType = mysqli_real_escape_string($connect, $_POST['propertyType']);
    }
    if ($_POST['propertyFloorLevel'] != $property['propertyFloorLevel']) {
      $propertyFloorLevel = mysqli_real_escape_string($connect, $_POST['propertyFloorLevel']);
    }
    if ($_POST['propertyFloorSize'] != $property['propertyFloorSize']) {
      $propertyFloorSize = mysqli_real_escape_string($connect, $_POST['propertyFloorSize']);
    }
    if ($_POST['propertyNumRooms'] != $property['propertyNumRooms']) {
      $propertyNumRooms = mysqli_real_escape_string($connect, $_POST['propertyNumRooms']);
    }
    if ($_POST['propertyBathrooms'] != $property['propertyBathrooms']) {
      $propertyBathrooms = mysqli_real_escape_string($connect, $_POST['propertyBathrooms']);
    }
    if ($_POST['propertyFurnishing'] != $property['propertyFurnishing']) {
      $propertyFurnishing = mysqli_real_escape_string($connect, $_POST['propertyFurnishing']);
    }
    if ($_POST['propertyFacilities'] != $property['propertyFacilities']) {
      $propertyFacilities = mysqli_real_escape_string($connect, $_POST['propertyFacilities']);
    }
    if ($_POST['propertyDesc'] != $property['propertyDesc']) {
      $propertyDesc = mysqli_real_escape_string($connect, $_POST['propertyDesc']);
    }
    if ($_POST['rentPrice'] != $property['rentPrice']) {
      $rentPrice = mysqli_real_escape_string($connect, $_POST['rentPrice']);
    }

    $sql = "UPDATE property SET 
            propertyName = '$propertyName',
            propertyAddress = '$propertyAddress',
            propertyCity = '$propertyCity',
            propertyPoscode = '$propertyPoscode',
            propertyState = '$propertyState',
            propertyType = '$propertyType',
            propertyFloorLevel = '$propertyFloorLevel',
            propertyFloorSize = '$propertyFloorSize',
            propertyNumRooms = '$propertyNumRooms',
            propertyBathrooms = '$propertyBathrooms',
            propertyFurnishing = '$propertyFurnishing',
            propertyFacilities = '$propertyFacilities',
            propertyDesc = '$propertyDesc',
            rentPrice = '$rentPrice'
            WHERE propertyID = '$prop_id'";
    $update_result = mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));
    mysqli_close($connect);

    if ($update_result) {
      echo "<script>alert('Successfully updated property!');</script>";
    } else {
      echo "<script>alert('Something went wrong!');</script>";
    }
  }

  if (isset($_POST["cancel-update-property"])) {
    // echo "<script>alert('Edit Canceled.')</script>";
  }

  if (isset($_POST["delete-property"])) {
    include("dbconnect.php");
    $sql = "DELETE FROM property 
            WHERE propertyID = '$prop_id'";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    mysqli_close($connect);
  
    if ($result) {
      if (!is_dir($dir)) {
        throw new InvalidArgumentException("$dir must be a directory");
      }
      if (substr($dir, strlen($dir) - 1, 1) != '/') {
        $dir .= '/';
      }
      $files = glob($dir . '*', GLOB_MARK);
      foreach ($files as $file) {
        if (is_dir($file)) {
            self::deleteDir($file);
        } else {
            unlink($file);
        }
      }
      rmdir($dir);

      echo "<script>alert('Successfully deleted the property!');</script>";
      echo "<script>window.location.replace('dashboard-landlord.php');</script>";
    } else {
      echo "<script>alert('Something went wrong! Failed to delete the property.');</script>";
    }
  }
?>
<script>
  $(document).ready(function(){
    $(".property-details input").hide();
  });

  function toggleDeleteForm() {
    $(".confirm-delete-property-container").fadeToggle(100,"swing");
  }

  $(document).mouseup(function(e) {
    var confirmform = $(".confirm-delete-property");
    var container = $(".confirm-delete-property-container");
    if (!confirmform.is(e.target) && confirmform.has(e.target).length == 0) {
      container.fadeOut(100,"swing");
    }
  });

  function toggleEditProperty() {
    $(".property-details-text").hide();
    $(".update-property-button").css("display", "inherit");
    $(".property-details input").attr("readonly", false);
    $(".delete-property-button").attr("disabled", true);
    $(".delete-property-button").css("opacity", 0.5);
    $(".delete-property-button").css("pointer-events", "none");
    $(".edit-property-button").attr("value", "Cancel");
    $(".edit-property-button").attr("onclick", "cancelEditProperty()");
    $(".property-text-input").show();
  }
  function cancelEditProperty() {
    $("#cancel-update-property").click();
    $(".property-details input").attr("readonly", true);
    $(".delete-property-button").attr("disabled", false);
    $(".delete-property-button").css("opacity", 1);
    $(".delete-property-button").css("pointer-events", "default");
    $(".edit-property-button").attr("value", "Edit");
    $(".edit-property-button").attr("onclick", "toggleEditProperty()");
    $(".property-text-input").hide();
    $(".property-details-text").show();
  }
  function saveEditProperty() {
    $(".property-details input").attr("readonly", true);
    $("#update-property").click();
  }

</script>