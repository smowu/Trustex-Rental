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
        <div class="property-details-container">
          <div>
            <div class="property-detail">
              <label for="name">Name</label><br>
              <input type="text" name="name" value="" placeholder="Property Name" required>
            </div>
            <div class="property-detail">
              <label for="address">Address</label><br>
              <input type="text" name="address" value="" placeholder="Property Address" required>
            </div>
            <div class="property-detail">
              <label for="city">City</label><br>
              <input type="text" name="city" value="" placeholder="Property City" required>
            </div>
            <div class="property-detail">
              <label for="poscode">Poscode</label><br>
              <input type="text" name="poscode" value="" placeholder="Property Poscode" maxlength="5" required>
            </div>
            <div class="property-detail">
              <label for="state">State</label><br>
              <select name="state" id="state" required>
                <option disabled selected value> -- Select a state -- </option>
              </select>
            </div>
            <div class="property-detail">
              <label for="type">Property Type</label><br>
              <input type="radio" id="condominium" name="type" value="Condominium">
              <label for="condominium">Condominium</label><br>
              <input type="radio" id="apartment" name="type" value="Apartment">
              <label for="apartment">Apartment</label><br>
              <input type="radio" id="service_residence" name="type" value="Service Residence">
              <label for="service_residence">Service Residence</label><br>
              <input type="radio" id="terrace" name="type" value="Terrace">
              <label for="terrace">Terrace</label><br>
              <input type="radio" id="bungalow" name="type" value="Bungalow">
              <label for="bungalow">Bungalow</label><br>
              <input type="radio" id="semid" name="type" value="Semi-D">
              <label for="semid">Semi-D</label><br>
              <input type="radio" id="townhouse" name="type" value="Townhouse">
              <label for="townhouse">Town House</label><br>
              <input type="radio" id="others" name="type" value="Others" required>
              <label for="others">Others</label>
            </div>
            <div class="property-detail">
              <label for="floor-level">Floor Level</label><br>
              <input type="text" name="floor-level" value="" placeholder="Floor Level">
            </div>
            <div class="property-detail">
              <label for="floor-size">Floor Size</label><br>
              <input type="text" name="floor-size" value="" placeholder="Floor Size"> sqft
            </div>
            <div class="property-detail">
              <label for="num-rooms">No. of Rooms</label><br>
              <input type="text" name="num-rooms" value="" placeholder="No. of Rooms" required><br>
              <label for="num-bathrooms">No. of Bathrooms</label><br>
              <input type="text" name="num-bathrooms" value="" placeholder="No. of Bathrooms" required>
            </div>
            <div class="property-detail">
              <label for="furnishing">Furnishing</label><br>
              <select name="furnishing" id="furnishing">
                <option disabled selected value> -- Select furnishing -- </option>
              </select>
            </div>
            <div class="property-detail">
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
              <label for="facilities5"> Security Guard</label>
            </div>
            <div class="property-detail">
              <label for="rent-price">Rent Price</label><br>
              RM <input type="text" name="rent-price" value="" placeholder="Renting Price">/month
            </div>
            <div class="property-detail">
              <label for="description">Description</label><br>
              <textarea name="description" cols="50" rows="10" placeholder="Enter property description..."></textarea>
            </div>
            <br>
            <label for="fileToUpload"><h3>Upload Property Images</h3></label>
            <div class="property-image-upload-container">
              <div id="property-upload-preview" class="property-upload-preview"></div>
              
              <input id="upload-property-image" type="file" name="propertyImage[]" multiple onchange="selectPropertyImage()" style="display: none;">
              <div class="property-image-upload-thumb-container thumb-empty" onclick="$('#upload-property-image').click()">
                <image class="property-image-upload-thumb property-image-upload-thumb-empty" src="assets/icons/plus.png"></image>
              </div>
            </div>
          </div>
        </div>
        <br>
        <div class="property-detail-buttons">
          <input type="reset" name="reset" value="Clear Form">
          <input type="submit" onclick="uploadPropertyImage()" name="property-submit" value="Add Property">
        </div>
      </form>
      <br>
      <a class="return-dashboard" href="dashboard.php">
        <img src="assets/icons/back-button.png"></img>
        <h4>Cancel</h4>
      </a>
    </div>
  </body>
</html>
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

  var totalUploaded = 0;
  var images = [];
  function selectPropertyImage() {
    var image = document.getElementById('upload-property-image').files;

    totalUploaded += image.length;
    if (totalUploaded > 6) {
      totalUploaded -= image.length;
      alert("Maximum 6 images are allowed.");
      return;
    }
    if (totalUploaded == 6) {
      $(".thumb-empty").hide();
    } 
    for (var i = 0; i < image.length; i++) {
      images.push({
        "name" : image[i].name,
        "url" : URL.createObjectURL(image[i]),
        "file" : image[i],
      })
      totalUploaded++;
    }
    document.getElementById('property-upload-preview').innerHTML = displayPropertyImage();
  }

  function displayPropertyImage() {
    var image = "";
    images.forEach((i) => {
      image += "<div class='property-image-upload-thumb-container'> <image class='property-image-upload-thumb' src='" + i.url + "'><span class='delete-button-icon' onclick='deleteImage("+images.indexOf(i)+")'></span></div>";
    })
    return image;
  }

  function deleteImage(e) {
    images.splice(e,1);
    document.getElementById('property-upload-preview').innerHTML = displayPropertyImage();
  }

  function uploadPropertyImage() {
    $(document).ready(function() {
      var formData = new FormData();
      var uploaded = document.getElementById('upload-property-image').files.length;
      for (var i = 0; i < images.length; i++) {
        formData.append("propertyImage[]", images[i]);
      }
    })
  }

</script>
<?php
  include("html/footer.html");

  if (isset($_POST['property-submit'])) {
    $checkbox = $_POST['facilities'];  
    $facilities = "";  
    foreach ($checkbox as $faci) {  
      $facilities .= $faci.",";  
    }

    include("dbconnect.php");
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $city = mysqli_real_escape_string($connect, $_POST['city']);
    $poscode = mysqli_real_escape_string($connect, $_POST['poscode']);
    $state = mysqli_real_escape_string($connect, $_POST['state']);
    $type = mysqli_real_escape_string($connect, $_POST['type']);
    $floor_level = mysqli_real_escape_string($connect, $_POST['floor-level']);
    $floor_size = mysqli_real_escape_string($connect, $_POST['floor-size']);
    $num_rooms = mysqli_real_escape_string($connect, $_POST['num-rooms']);
    $num_bathrooms = mysqli_real_escape_string($connect, $_POST['num-bathrooms']);
    $furnishing = mysqli_real_escape_string($connect, $_POST['furnishing']);
    $facilities = mysqli_real_escape_string($connect, $facilities);
    $desc = mysqli_real_escape_string($connect, $_POST['description']);
    $price = mysqli_real_escape_string($connect, $_POST['rent-price']);
    $sql = "INSERT INTO property (landlordRegNo, propertyName, propertyAddress, propertyCity, propertyPoscode, propertyState, 
                                  propertyType, propertyFloorLevel, propertyFloorSize, propertyNumRooms, propertyBathrooms,
                                  propertyFurnishing, propertyFacilities, propertyDesc, rentPrice) 
            VALUES('".$_SESSION['landlordRegNo']."','".$name."','".$address."','".$city."','".$poscode."','".$state."',
                   '".$type."','".$floor_level."','".$floor_size."','".$num_rooms."','".$num_bathrooms."',
                   '".$furnishing."','".$facilities."','".$desc."','".$price."')";
    $result = mysqli_query($connect, $sql);
    $prop_id = mysqli_insert_id($connect);
    mysqli_close($connect);

    if ($result) {
      $dir = "/assets/images/properties/property-" . sprintf('%06d', $prop_id) . "/";
      $mkdir_success = mkdir(__DIR__ . $dir, 0777, true);
        
      if ($mkdir_success && isset($_FILES["propertyImage"]["name"])) {
        $totalFiles = count($_FILES["propertyImage"]["name"]);
        for ($i = 0; $i < $totalFiles; $i++) {
          $imageName = $_FILES["propertyImage"]["name"][$i];
          $tmpName = $_FILES["propertyImage"]["tmp_name"][$i];
          include("uploadPropertyImage.php");
        }
      } else if (!$mkdir_success) {
        echo "<script>alert('Something went wrong while uploading property images!')</script>";
      }
      echo "<script>alert('Successfully added new property!')</script>";
      echo "<script>window.location.replace('property.php?id=".$prop_id."');</script>";
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }
?>
