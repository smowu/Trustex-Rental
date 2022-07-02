<?php
  $prop_id = intval($_GET['id']);
  include("dbconnect.php");
  $sql = "SELECT *
          FROM property
          WHERE propertyID = '$prop_id'";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);

  $prop = mysqli_fetch_assoc($result);

  $facilities = explode(",",$prop['propertyFacilities']);

  function facility($facilities, $str) {
    foreach ($facilities as $faci) {
      if ($faci == $str) {
        return true;
      }
    }
  }
  

?>
<form id="listing-form" class="listing-form" action="" method="POST" enctype="multipart/form-data">

  <div class="image-upload-form" action="uploadImage.php" method="post" enctype="multipart/form-data">
    <image class="" src=""></image>
    <br>
    <div>
      <input type="file" name="fileToUpload" onchange="readImageURL(this)">
    </div>
  </div><br>

  <label for="name">Name: </label>
  <input type="text" name="name" value="<?php echo $prop['propertyName'] ?>" placeholder="Property Name" required readonly><br><br>
  <label for="address">Address: </label>
  <input type="text" name="address" value="<?php echo $prop['propertyAddress'] ?>" placeholder="Property Address" required readonly><br><br>
  <label for="city">City: </label>
  <input type="text" name="city" value="<?php echo $prop['propertyCity'] ?>" placeholder="Property City" required readonly><br><br>
  <label for="poscode">Poscode: </label>
  <input type="text" name="poscode" value="<?php echo $prop['propertyPoscode'] ?>" placeholder="Property Poscode" required readonly><br><br>

  <label for="state">State: </label>
  <select name="state" id="state" required readonly>
    <option disabled selected value><?php echo $prop['propertyState'] ?></option>
  </select><br><br>

  <label for="type">Property Type</label><br>
  <input type="radio" id="condominium" name="type" value="Condominium" <?php if ($prop['propertyType'] == "Condominium"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
  <label for="condominium">Condominium</label><br>
  <input type="radio" id="apartment" name="type" value="Apartment" <?php if ($prop['propertyType'] == "Apartment"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
  <label for="apartment">Apartment</label><br>
  <input type="radio" id="terrace" name="type" value="Terrace" <?php if ($prop['propertyType'] == "Terrace"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
  <label for="terrace">Terrace</label><br>
  <input type="radio" id="bungalow" name="type" value="Bungalow" <?php if ($prop['propertyType'] == "Bungalow"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
  <label for="bungalow">Bungalow</label><br>
  <input type="radio" id="semid" name="type" value="Semi-D" <?php if ($prop['propertyType'] == "Semi-D"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
  <label for="semid">Semi-D</label><br>
  <input type="radio" id="townhouse" name="type" value="Townhouse" <?php if ($prop['propertyType'] == "Townhouse"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
  <label for="townhouse">Town House</label><br>
  <input type="radio" id="others" name="type" value="Others" required <?php if ($prop['propertyType'] == "Others"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
  <label for="others">Others</label><br><br>

  <label for="floor-level">Floor Level</label>
  <input type="text" name="floor-level" value="<?php echo $prop['propertyFloorLevel'] ?>" placeholder="Floor Level" readonly><br><br>
  <label for="floor-size">Floor Size</label>
  <input type="text" name="floor-size" value="<?php echo $prop['propertyFloorSize'] ?>" placeholder="Floor Size" readonly><br><br>
  <label for="num-rooms">No. of Rooms</label>
  <input type="text" name="num-rooms" value="<?php echo $prop['propertyNumRooms'] ?>" placeholder="No. of Rooms" required readonly><br>
  <label for="num-bathrooms">No. of Bathrooms</label>
  <input type="text" name="num-bathrooms" value="<?php echo $prop['propertyBathrooms'] ?>" placeholder="No. of Bathrooms" required readonly><br><br>

  <label for="furnishing">Furnishing</label>
  <select name="furnishing" id="furnishing" readonly>
    <option disabled selected value><?php echo $prop['propertyFurnishing'] ?></option>
  </select><br><br>

  <label for="facilities[]">Facilities</label><br>
  <input type="checkbox" id="facilities1" name="facilities[]" value="Wifi" disabled <?php if (facility($facilities,"Wifi")){ echo 'checked="checked"'; } ?>>
  <label for="facilities1"> Wifi</label><br>
  <input type="checkbox" id="facilities2" name="facilities[]" value="Parking" disabled <?php if (facility($facilities,"Parking")){ echo 'checked="checked"'; } ?>>
  <label for="facilities2"> Parking Lot</label><br>
  <input type="checkbox" id="facilities3" name="facilities[]" value="Gym" disabled <?php if (facility($facilities,"Gym")){ echo 'checked="checked"'; } ?>>
  <label for="facilities3"> Gymnasium</label><br>
  <input type="checkbox" id="facilities4" name="facilities[]" value="Pool" disabled <?php if (facility($facilities,"Pool")){ echo 'checked="checked"'; } ?>>
  <label for="facilities4"> Swimming Pool</label><br>
  <input type="checkbox" id="facilities5" name="facilities[]" value="Security" disabled <?php if (facility($facilities,"Security")){ echo 'checked="checked"'; } ?>>
  <label for="facilities5"> Security Guard</label><br>

  <input type="checkbox" id="other1" name="facilities[]" value="Others" disabled <?php if (facility($facilities,"Others")){ echo 'checked="checked"'; } ?>>
  <label for="other1"> Others</label><br><br>

  <label for="rent-price">Rent Price</label>
  RM <input type="text" name="rent-price" value="<?php echo $prop['rentPrice'] ?>" placeholder="Renting Price" readonly><br><br>

  <label for="description">Description</label><br>
  <textarea name="description" cols="50" rows="10" placeholder="Enter property description..." readonly><?php echo $prop['propertyDesc'] ?></textarea><br>
  <br>
  <input type="submit" name="listing-submit" value="Add Property">
</form><br>