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
    <div class="about-container new-property-container container-margin">
      <h1>New Property</h1>
      <br>
      <form class="add-property-form" action="" method="POST">
        <label for="name">Name</label>
        <input type="text" name="name" value="" placeholder="Property Name" required><br>
        <label for="address">Address</label>
        <input type="text" name="address" value="" placeholder="Property Address" required><br>
        <label for="city">City</label>
        <input type="text" name="city" value="" placeholder="Property City" required><br>
        <label for="poscode">Poscode</label>
        <input type="text" name="poscode" value="" placeholder="Property Poscode" required><br>
        <label for="state">State</label>
        <input type="text" name="state" value="" placeholder="Property State" required><br>
        <label for="type">Type</label>
        <input type="text" name="type" value="" placeholder="Property Type" required><br>
        <label for="floor-level">Floor Level</label>
        <input type="text" name="floor-level" value="" placeholder="Floor Level"><br>
        <label for="floor-size">Floor Size</label>
        <input type="text" name="floor-size" value="" placeholder="Floor Size"><br>
        <label for="num-rooms">No. of Rooms</label>
        <input type="text" name="num-rooms" value="" placeholder="No. of Rooms" required><br>
        <label for="num-bathrooms">No. of Bathrooms</label>
        <input type="text" name="num-bathrooms" value="" placeholder="No. of Bathrooms" required><br>
        <label for="furnishing">Furnishing</label>
        <input type="text" name="furnishing" value="" placeholder="Furnishing"><br>
        <label for="facilities">Facilities</label>
        <input type="text" name="facilities" value="" placeholder="Facilities"><br>
        <label for="description">Description</label><br>
        <textarea name="description" cols="50" rows="10" placeholder="Enter property description...">
        </textarea><br>
        <label for="rent-price">Rent Price</label>
        <input type="text" name="rent-price" value="" placeholder="Renting Price"><br>

        <br>
        <input type="reset" name="reset" value="Clear">
        <input type="submit" name="property-submit" value="Add Property">
      </form>
    </div>
  </body>
</html>
<?php

  if (isset($_POST['property-submit'])) {
    include("dbconnect.php");
    $sql = "INSERT INTO property (landlordRegNo, propertyName, propertyAddress, propertyCity, propertyPoscode, propertyState, 
                                  propertyType, propertyFloorLevel, propertyFloorSize, propertyNumRooms, propertyBathrooms,
                                  propertyFurnishing, propertyFacilities, propertyDesc, rentPrice) 
            VALUES('".$_SESSION['landlordRegNo']."','".$_POST['name']."','".$_POST['address']."','".$_POST['city']."','".$_POST['poscode']."','".$_POST['state']."',
                   '".$_POST['type']."','".$_POST['floor-level']."','".$_POST['floor-size']."','".$_POST['num-rooms']."','".$_POST['num-bathrooms']."',
                   '".$_POST['furnishing']."','".$_POST['facilities']."','".$_POST['description']."','".$_POST['rent-price']."')";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    $prop_id = mysqli_insert_id($connect);
    mysqli_close($connect);

    if ($result) {
      $dir = "/assets/images/properties/property-" . sprintf('%06d', $prop_id) . "";
      mkdir(__DIR__ . $dir, 0777, true);

      echo "<script>alert('Successfully added new property!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    }

  }

  include("html/footer.html");
?>