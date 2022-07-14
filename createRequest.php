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
  $result_list = mysqli_query($connect, $sql_list);

  $sql_user = "SELECT * FROM user WHERE userID = '$user_id'";
  $result_user = mysqli_query($connect, $sql_user);
  
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
      <form class="request-inquiry max-container" action="" method="POST" enctype="multipart/form-data">
        <h2>Property Details</h2><br>
        <p>Property ID: <?php echo sprintf("%06d", $listing['propertyID']) ?></p><br> 

        <div class="request-inquiry-details">
          <label>Property</label>
          <h2><?php echo $listing['propertyName'] ?></h2>
        </div>
        <div class="request-inquiry-details">
          <label>Property</label>
          <h2>RM <?php echo $listing['rentPrice'] ?>/month</h2>
        </div>
        <div class="request-inquiry-details">
          <label>Floor Size</label><br>
          <p><?php echo $listing['propertyFloorSize'] ?> sqft</p>
        </div>
        <div class="request-inquiry-details">
          <label>No. of Rooms</label><br>
          <p><?php echo $listing['propertyNumRooms'] ?></p><br>
          <label>No. of Bathrooms</label><br>
          <p><?php echo $listing['propertyBathrooms'] ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>Address</label><br>
          <p><?php echo $listing['propertyAddress'] ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>City</label><br>
          <p><?php echo $listing['propertyCity'] ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>Poscode</label><br>
          <p><?php echo $listing['propertyPoscode'] ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>State</label><br>
          <p><?php echo $listing['propertyState'] ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>Type</label><br>
          <p><?php echo $listing['propertyType'] ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>Floor Level</label><br>
          <p><?php if ($listing['propertyFloorLevel'] != "") { echo $listing['propertyFloorLevel']; } else { echo "N/A"; } ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>Furnishing</label><br>
          <p><?php echo $listing['propertyFurnishing'] ?></p>
        </div>
        <div class="request-inquiry-details">
          <label>Facilities</label><br>
          <p><?php if ($listing['propertyFacilities'] != "") { echo $listing['propertyFacilities']; } else { echo "N/A"; } ?></p>
        </div>
        <br>

        <div class="renting-details request-inquiry-details">
          <h2>Renting Details</h2><br>
          <label for="num-tenant">Number of Tenants</label>
          <div class="num-input-container">
            <input type="button" onclick="dec('num-tenant',1)" value=" - ">
            <input class="num-input-box num-tenant" name="num-tenant" type="text" readonly required value="1">
            <input type="button" onclick="inc('num-tenant',16)" value=" + ">
            person(s)
          </div><br>
          
          <div class="calendar-container">
            <h3>Select Date</h3><br>
            <label for="duration">Duration</label>
            <div class="num-input-container">
              <input type="button" onclick="dec('duration',1)" value=" - ">
              <input class="num-input-box duration" name="duration" type="text" readonly required value="1">
              <input type="button" onclick="inc('duration',48)" value=" + ">
              month(s)
            </div><br>
            <div class="inquiry-calendar-container">
              <div>
                <label for="start-date">Start Date</label><br>
                <input class="start-date" type="date" name="start-date" required>
              </div>
              <div>
                <label for="end-date">End Date</label><br>
                <input class="end-date" type="date" name="end-date" readonly required style="outline: none;">
              </div>
            </div>
          </div>
        </div><br>

        <div class="tenant-details request-inquiry-details">
          <h2>Tenant Details</h2><br>
          <div class="inquiry-name-details">
            <div>
              <label for="firstname">First Name</label><br>
              <input type="text" name="firstname" placeholder="First Name" value="<?php echo $user['userFName']?>" required>
            </div>
            <div>
              <label for="lastname">Last Name</label><br>
              <input type="text" name="lastname" placeholder="Last Name" value="<?php echo $user['userLName']?>" required>
            </div>
          </div><br>
          <label for="ic">IC Number</label><br>
          <input type="text" name="ic" placeholder="IC Number" value="<?php echo $user['userIC']?>" required><br><br>
          <label for="gender">Gender</label><br>
          <div class="inquiry-radio-gender">
            <input type="radio" id="male" name="gender" value="M" <?php if ($user['userGender'] == "M"){ echo 'checked="checked"'; } ?>>
            <label for="male" style="color: #333333;"><b>Male</b></label><br>
            <input type="radio" id="female" name="gender" value="F" <?php if ($user['userGender'] == "F"){ echo 'checked="checked"'; } ?>>
            <label for="female" style="color: #333333;"><b>Female</b></label>
          </div><br>
          <label for="address">Address</label><br>
          <textarea name="address" placeholder="Address" rows="4" cols="50"><?php echo $user['userAddress']?></textarea><br><br>
          <label for="phoneno">Phone No.</label><br>
          <input type="text" name="phoneno" placeholder="Phone Number" value="<?php echo $user['userPhoneNo']?>" required>

        </div>
        <br>
        <div class="inquiry-form-button-container">
          <input class="inquiry-form-button" type="reset" name="reset-form" value="Reset Form">
          <input class="inquiry-form-button" type="submit" name="confirm-request" value="Confirm Request">
        </div>
        
      </form>
      <br>
      <a class="return-dashboard" href="javascript:history.back()">
        <img src="assets/icons/back-button.png"></img>
        <h4>Cancel</h4>
      </a>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");

  if (isset($_POST["confirm-request"])) {

    include("dbconnect.php");

    $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
    $ic = mysqli_real_escape_string($connect, $_POST['ic']);
    $gender = mysqli_real_escape_string($connect, $_POST['gender']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $phoneno = mysqli_real_escape_string($connect, $_POST['phoneno']);

    $sql_user = "UPDATE user SET 
                 userFName = '$firstname',
                 userLName = '$lastname',
                 userIC = '$ic',
                 userGender = '$gender',
                 userAddress = '$address',
                 userPhoneNo = '$phoneno'
                 WHERE user.userID = '$user_id'";
    $update_result = mysqli_query($connect,$sql_user);

    $duration = mysqli_real_escape_string($connect,$_POST["duration"]);
    $start_date = mysqli_real_escape_string($connect,$_POST["start-date"]);
    $end_date = mysqli_real_escape_string($connect,$_POST["end-date"]);
    $num_tenant = mysqli_real_escape_string($connect,$_POST["num-tenant"]);

    $sql = "INSERT INTO request (userID, listingID, rentStartDate, rentEndDate, rentDuration, rentNumTenants)
            VALUES('".$user_id."','".$list_id."','".$start_date."','".$end_date."','".$duration."','".$num_tenant."')";
    $result = mysqli_query($connect,$sql);
    mysqli_close($connect);

    if ($result && $update_result) {
      echo "<script>alert('Your renting request has been sent!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong! Failed to send your inquiry.')</script>";
    }
  }
?>
<script>
  Date.prototype.addDays = function(days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    return date;
  }

  window.onload = function() {
    var date = new Date();
    date = date.addDays(8);
    var today = date.toISOString().split('T')[0];
    document.getElementsByName("start-date")[0].setAttribute('min', today);
  }

  $('.start-date, .duration').change(function () {
    var stVal = $(".start-date").val();
    var d = new Date(stVal.split("/").reverse().join("-"));
    var month = parseInt($(".duration").val());
    d.setMonth(d.getMonth() + month);
    var dd = ("0" + d.getDate()).slice(-2);
    var mm = ("0" + (d.getMonth() + 1)).slice(-2);
    var newdate = d.getFullYear()+"-"+(mm)+"-"+(dd) ;
    $('.end-date').val(newdate);
  });
</script>