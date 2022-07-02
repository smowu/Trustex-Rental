<?php
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 'L') {
    header("Location: dashboard.php");
  }
  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="new-property">
    <div class="default-container container-margin">
      <h1>New Property</h1>
      <br>
      <form class="add-property-form" action="" method="POST" enctype="multipart/form-data">

        <div class="image-upload-form" action="uploadImage.php" method="post" enctype="multipart/form-data">
          <image class="" src=""></image>
          <br>
          <div>
            <input type="file" name="fileToUpload" onchange="readImageURL(this)">
          </div>
        </div><br>

        <label for="name">Name</label>
        <input type="text" name="name" value="" placeholder="Property Name" required><br><br>
        <label for="address">Address</label>
        <input type="text" name="address" value="" placeholder="Property Address" required><br><br>
        <label for="city">City</label>
        <input type="text" name="city" value="" placeholder="Property City" required><br><br>
        <label for="poscode">Poscode</label>
        <input type="text" name="poscode" value="" placeholder="Property Poscode" required><br><br>

        <!-- State -->
        <label for="state">State</label>
        <select name="state" id="state" required>
          <option disabled selected value> -- Select a state -- </option>
        </select><br><br>

        <label for="type">Property Type</label><br>
        <input type="radio" id="condominium" name="type" value="Condominium">
        <label for="condominium">Condominium</label><br>
        <input type="radio" id="apartment" name="type" value="Apartment">
        <label for="apartment">Apartment</label><br>
        <input type="radio" id="terrace" name="type" value="Terrace">
        <label for="terrace">Terrace</label><br>
        <input type="radio" id="bungalow" name="type" value="Bungalow">
        <label for="bungalow">Bungalow</label><br>
        <input type="radio" id="semid" name="type" value="Semi-D">
        <label for="semid">Semi-D</label><br>
        <input type="radio" id="townhouse" name="type" value="Townhouse">
        <label for="townhouse">Town House</label><br>
        <input type="radio" id="others" name="type" value="Others" required>
        <label for="others">Others</label><br><br>

        <label for="floor-level">Floor Level</label>
        <input type="text" name="floor-level" value="" placeholder="Floor Level"><br><br>
        <label for="floor-size">Floor Size</label>
        <input type="text" name="floor-size" value="" placeholder="Floor Size"><br><br>
        <label for="num-rooms">No. of Rooms</label>
        <input type="text" name="num-rooms" value="" placeholder="No. of Rooms" required><br>
        <label for="num-bathrooms">No. of Bathrooms</label>
        <input type="text" name="num-bathrooms" value="" placeholder="No. of Bathrooms" required><br><br>

        <!-- Furnishing -->
        <label for="furnishing">Furnishing</label>
        <select name="furnishing" id="furnishing">
          <option disabled selected value> -- Select furnishing -- </option>
        </select><br><br>

        <!-- Facilities -->
        <label for="facilities[]">Facilities</label><br>
        <input type="checkbox" id="facilities1" name="facilities[]" value="Wifi">
        <label for="facilities1"> Wifi</label><br>
        <input type="checkbox" id="facilities2" name="facilities[]" value="Parking">
        <label for="facilities2"> Parking Lot</label><br>
        <input type="checkbox" id="facilities3" name="facilities[]" value="Gym">
        <label for="facilities3"> Gymnasium</label><br>
        <input type="checkbox" id="facilities4" name="facilities[]" value="Pool">
        <label for="facilities4"> Swimming Pool</label><br>
        <input type="checkbox" id="facilities5" name="facilities[]" value="Security">
        <label for="facilities5"> Security Guard</label><br>

        <input type="checkbox" id="other1" name="facilities[]" value="Others">
        <label for="other1"> Others</label><br><br>

        <label for="rent-price">Rent Price</label>
        RM <input type="text" name="rent-price" value="" placeholder="Renting Price"><br><br>

        <label for="description">Description</label><br>
        <textarea name="description" cols="50" rows="10" placeholder="Enter property description..."></textarea><br>
        <br>
        <input type="reset" name="reset" value="Clear">
        <input type="submit" name="property-submit" value="Add Property">
      </form><br>
      <button onclick="location.href='dashboard-landlord.php'">Cancel</button>
    </div>
  </body>
</html>
<?php

  if (isset($_POST['property-submit'])) {

    $checkbox = $_POST['facilities'];  
    $facilities = "";  
    foreach ($checkbox as $faci) {  
      $facilities .= $faci.",";  
    }

    include("dbconnect.php");
    $sql = "INSERT INTO property (landlordRegNo, propertyName, propertyAddress, propertyCity, propertyPoscode, propertyState, 
                                  propertyType, propertyFloorLevel, propertyFloorSize, propertyNumRooms, propertyBathrooms,
                                  propertyFurnishing, propertyFacilities, propertyDesc, rentPrice) 
            VALUES('".$_SESSION['landlordRegNo']."','".$_POST['name']."','".$_POST['address']."','".$_POST['city']."','".$_POST['poscode']."','".$_POST['state']."',
                   '".$_POST['type']."','".$_POST['floor-level']."','".$_POST['floor-size']."','".$_POST['num-rooms']."','".$_POST['num-bathrooms']."',
                   '".$_POST['furnishing']."','".$facilities."','".$_POST['description']."','".$_POST['rent-price']."')";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    $prop_id = mysqli_insert_id($connect);
    mysqli_close($connect);

    if ($result) {
      $dir = "/assets/images/properties/property-" . sprintf('%06d', $prop_id) . "";
      $mkdir_success = mkdir(__DIR__ . $dir, 0777, true);

      if ($mkdir_success) {

      } else {
        echo "<script>alert('Something went wrong while uploading property images!')</script>";
      }
      echo "<script>alert('Successfully added new property!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }
  include("html/footer.html");
?>
<script>
  var sel_state = document.getElementById("state");
  var states = ["W.P. Kuala Lumpur","Johor","Kedah","Kelantan",
                "Melaka","Negeri Sembilan","Pahang","Perak",
                "Perlis","Pulau Pinang","Sabah","Sarawak",
                "Selangor","Terengganu","W.P. Labuan","W.P. Putrajaya"];

  var sel_furnishing = document.getElementById("furnishing");
  var furnish = ["Unfurnished","Partially Furnished","Fully Furnished"];
  
  var selections = Array();
  selections = [[sel_state,states],[sel_furnishing,furnish]];

  for (var i = 0; i < selections.length; i++) {
    selections[i][1].sort();
    options = selections[i][1];
    for (var j = 0; j < options.length; j++) {
      var optn = options[j];
      var el = document.createElement("option");
      el.textContent = optn;
      el.value = optn;
      selections[i][0].appendChild(el);
    }
  }
</script>