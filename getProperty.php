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
  
  // if (isset($_POST['add-listing'])) {
  //   include("dbconnect.php");
  //   $sql = "INSERT INTO listing (propertyID)
  //           VALUES ('".$prop_id."')";
  //   $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  //   mysqli_close($connect);

  //   if ($result) {
  //     echo "<script>alert('Your property has been successfully listed!')</script>";
  //     echo "<script>window.location.replace('dashboard.php');</script>";
  //   } else {
  //     echo "<script>alert('Something went wrong!')</script>";
  //   }
  // }

?>
<div class="image-upload-form" action="uploadImage.php" method="post" enctype="multipart/form-data">
  <image class="" src=""></image>
  <br>
  <div>
    <input type="file" name="fileToUpload" onchange="readImageURL(this)">
  </div>
</div><br>

<label for="name">Name: </label><br>
<p><?php echo $prop['propertyName'] ?></p><br>

<label for="address">Address: </label><br>
<p><?php echo $prop['propertyAddress'] ?></p><br>

<label for="city">City: </label>
<p><?php echo $prop['propertyCity'] ?></p><br>

<label for="poscode">Poscode: </label>
<p><?php echo $prop['propertyPoscode'] ?></p><br>

<label for="state">State: </label>
<p><?php echo $prop['propertyState'] ?></p><br>

<label for="type">Property Type: </label><br>
<input type="radio" id="condominium" name="type" value="Condominium" <?php if ($prop['propertyType'] == "Condominium"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
<label for="condominium">Condominium</label><br>
<input type="radio" id="apartment" name="type" value="Apartment" <?php if ($prop['propertyType'] == "Apartment"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
<label for="apartment">Apartment</label><br>
<input type="radio" id="service_residence" name="type" value="Service Residence" <?php if ($prop['propertyType'] == "Service Residence"){ echo 'checked="checked"'; }else{ echo 'disabled'; } ?>>
<label for="service_residence">Service Residence</label><br>
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

<label for="floor-level">Floor Level: </label>
<p><?php echo $prop['propertyFloorLevel'] ?></p><br>
<label for="floor-size">Floor Size: </label>
<p><?php echo $prop['propertyFloorSize'] ?> sqft</p><br>
<label for="num-rooms">No. of Rooms: </label>
<p><?php echo $prop['propertyNumRooms'] ?></p><br>
<label for="num-bathrooms">No. of Bathrooms: </label>
<p><?php echo $prop['propertyBathrooms'] ?></p><br>

<label for="furnishing">Furnishing: </label>
<p><?php echo $prop['propertyFurnishing'] ?></p><br>

<label for="facilities[]">Facilities: </label><br>
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

<label for="rent-price">Rent Price: </label>
<p>RM <?php echo number_format(round($prop['rentPrice'],0)) ?></p><br>

<label for="description">Description: </label><br>
<p><?php echo $prop['propertyDesc'] ?></p><br>

<input type="text" name="propertyID" value="<?php echo $prop['propertyID'] ?>" style="display: none;">
<input type="submit" name="listing-submit" value="Add to Listing">