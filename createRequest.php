<?php 
  session_start();
  $list_id = $_GET['id'];
  if (!isset($_SESSION['userID'])) {
    header("Location: listing.php?id=".$list_id."");
  }
  $user_id = $_SESSION['userID'];
  include("dbconnect.php");
  $sql_list = "SELECT *
               FROM listing, property
               WHERE listing.propertyID = property.propertyID AND listing.listingID = '$list_id'";
  $result_list = mysqli_query($connect, $sql_list) or die ("Error: ".mysqli_error());

  $sql_user = "SELECT * FROM user WHERE userID = '$user_id'";
  $result_user = mysqli_query($connect, $sql_user) or die ("Error: ".mysqli_error());
  
  mysqli_close($connect);
  $listing = mysqli_fetch_assoc($result_list);
  $user = mysqli_fetch_assoc($result_user);

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="createRequest">
    <div class="default-container container-margin">
      <h1>Request Inquiry</h1><br>
      <form class="request-details" action="" method="POST" enctype="multipart/form-data">
        <div class="request-property-details">
          <h2>Property Details</h2><br>
          <p>Property ID: <?php echo sprintf("%06d", $listing['propertyID']) ?></p><br>
          <label>Property: </label>
          <p><b><?php echo $listing['propertyName'] ?></b></p><br>

          RM <input class="property-h1" type="text" name="rentPrice" value="<?php echo $listing['rentPrice'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyFloorSize">Floor Size: </label><br>
          <input class="" type="text" name="propertyFloorSize" value="<?php echo $listing['propertyFloorSize'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyNumRooms">No. of Rooms: </label><br>
          <input class="" type="text" name="propertyNumRooms" value="<?php echo $listing['propertyNumRooms'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyBathrooms">No. of Bathrooms: </label><br>
          <input class="" type="text" name="propertyBathrooms" value="<?php echo $listing['propertyBathrooms'] ?>" placeholder="N/A" readonly><br><br>

          
          <label for="propertyAddress">Address: </label><br>
          <input class="property-text-input" type="text" name="propertyAddress" value="<?php echo $listing['propertyAddress'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyCity">City: </label><br>
          <input class="property-text-input" type="text" name="propertyCity" value="<?php echo $listing['propertyCity'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyPoscode">Poscode: </label><br>
          <input class="property-text-input" type="text" name="propertyPoscode" value="<?php echo $listing['propertyPoscode'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyState">State: </label><br>
          <input class="property-text-input" type="text" name="propertyState" value="<?php echo $listing['propertyState'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyType">Type: </label><br>
          <input class="property-text-input" type="text" name="propertyType" value="<?php echo $listing['propertyType'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyFloorLevel">Floor Level: </label><br>
          <input class="property-text-input" type="text" name="propertyFloorLevel" value="<?php echo $listing['propertyFloorLevel'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyFloorSize">Floor Size: </label><br>
          <input class="property-text-input" type="text" name="propertyFloorSize" value="<?php echo $listing['propertyFloorSize'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyFurnishing">Furnishing: </label><br>
          <input class="property-text-input" type="text" name="propertyFurnishing" value="<?php echo $listing['propertyFurnishing'] ?>" placeholder="N/A" readonly><br><br>

          <label for="propertyFacilities">Facilities: </label><br>
          <input class="property-text-input" type="text" name="propertyFacilities" value="<?php echo $listing['propertyFacilities'] ?>" placeholder="N/A" readonly><br><br>
        </div><br>

        <div class="renting-details">
          <h2>Renting Details</h2><br>
          <label for="num-tenant">Number of Tenants: </label>
          <input class="num-tenant" min="1" max="16" name="num-tenant" value="1" type="number" required> person(s)<br><br>
          <div class="calendar-container">
            <h3>Select Date</h3><br>
            <label for="duration">Duration: </label>
            <input class="duration" min="1" max="24" name="duration" value="1" type="number" required> month(s)
            <br>
            <label for="start-date">Start Date</label>
            <input class="start-date" type="date" name="start-date" required>
            <label for="end-date">End Date</label>
            <input class="end-date" type="date" name="end-date" readonly required>
          </div>
        </div><br>

        <div class="tenant-details">
          <h2>Tenant Details</h2><br>
          <label for="firstname">First Name: </label>
          <input type="text" name="firstname" placeholder="First Name" value="<?php echo $user['userFName']?>" required>
          <label for="lastname">Last Name: </label>
          <input type="text" name="lastname" placeholder="Last Name" value="<?php echo $user['userLName']?>" required><br>
          <label for="ic">IC Number: </label>
          <input type="text" name="ic" placeholder="IC Number" value="<?php echo $user['userIC']?>" required><br>
          <label for="gender">Gender: </label>
          <input type="text" name="gender" placeholder="Gender" value="<?php echo $user['userGender']?>" required><br>
          <label for="address">Address: </label>
          <input type="text" name="address" placeholder="Address" value="<?php echo $user['userAddress']?>" required><br>
          <label for="phoneno">Phone No.: </label>
          <input type="text" name="phoneno" placeholder="Phone Number" value="<?php echo $user['userPhoneNo']?>" required><br>

          <!-- <div class="number-input">
            <button onclick="this.parentNode.querySelector('input[type=number]').stepDown()" class="minus"></button>
            <input class="quantity" min="1" name="quantity" value="1" type="number">
            <button onclick="this.parentNode.querySelector('input[type=number]').stepUp()" class="plus"></button>
          </div><br> -->

        </div>
        <br>
        <input type="reset" name="clear-form" value="Clear Form">
        <input type="submit" name="confirm-request" value="Confirm Request">
      </form>
      
    </div>
  </body>
</html>
<?php
  include("html/footer.html");

  if (isset($_POST["confirm-request"])) {

    include("dbconnect.php");

    $duration = mysqli_real_escape_string($connect,$_POST["duration"]);
    $start_date = mysqli_real_escape_string($connect,$_POST["start-date"]);
    $end_date = mysqli_real_escape_string($connect,$_POST["end-date"]);
    $num_tenant = mysqli_real_escape_string($connect,$_POST["num-tenant"]);

    $sql = "INSERT INTO request (userID, listingID, rentStartDate, rentEndDate, rentDuration, rentNumTenants)
            VALUES('".$user_id."','".$list_id."','".$start_date."','".$end_date."','".$duration."','".$num_tenant."')";
    $result = mysqli_query($connect,$sql);
    mysqli_close($connect);

    if ($result) {
      echo "<script>alert('Your renting request has been sent!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong! Failed to send your inquiry.')</script>";
    }
  }
?>
<script>
  window.onload = function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementsByName("start-date")[0].setAttribute('min', today);
  }

  $('.start-date, .duration').change(function () {
    var stVal = $(".start-date").val()
    var d = new Date(stVal.split("/").reverse().join("-"));
    var month = parseInt($(".duration").val());
    d.setMonth(d.getMonth() + month);
    var dd = ("0" + d.getDate()).slice(-2);
    var mm = ("0" + (d.getMonth() + 1)).slice(-2);
    var newdate = d.getFullYear()+"-"+(mm)+"-"+(dd) ;
    $('.end-date').val(newdate);
  });
</script>