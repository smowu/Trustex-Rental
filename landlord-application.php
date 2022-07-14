<?php 
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 'T') {
    header("Location: dashboard.php");
  }
  include("dbconnect.php");
  $sql = "SELECT * FROM user WHERE userID = ".$_SESSION['userID']."";
  $result = mysqli_query($connect, $sql);
  mysqli_close($connect);
  $user = mysqli_fetch_assoc($result);

  $id = $user['userID'];
  $username = $user['userName'];
  $email = $user['userEmail'];
  if ($user['userType'] == 'A') {
    $usertype = "Admin";
  } else if ($user['userType'] == 'L') {
    $usertype = "Landlord";
  } else { 
    $usertype = "Tenant";
  }
  $firstname = $user['userFName'];
  $lastname = $user['userLName'];
  $ic = $user['userIC'];
  $gender = $user['userGender'];
  if (strtoupper($gender) == 'M') {
    $gender = "Male";
  } else if (strtoupper($gender) == 'F') {
    $gender = "Female";
  } else {
    $gender = "No Data";
  }
  $address = $user['userAddress'];
  $phoneno = $user['userPhoneNo'];
?>
    <!DOCTYPE html>
    <html>
      <head>
        <link rel="icon" href="assets/images/trustex-favicon.png">
        <link rel="stylesheet" href="./styles/style.css" type="text/css">
      </head>
      <body style="display: inline-flex; background-color: #257b9f;">

        <div class="register-splashscreen">
          <a href="index.php">
            <img height="32" src="assets/images/TrustexLogo.png" alt="Trustex Logo">
          </a>
          <a href="dashboard.php" class="return-dashboard-landlord">
            <h3>Return to Dashboard</h3>
          </a>
        </div>

        <div class="landlord-application-section">
          <div class="landlord-application-form-container">
            <h1>Landlord Application Form</h1>

            <form class="landlord-application-form" name="landlord-application" method="POST" action="">
              <div class="application-input application-name">
                <div>
                  <label for="firstname">First Name</label><br>
                  <input type="text" name="firstname" placeholder="First Name" value="<?php echo $firstname ?>" required><br>
                </div>
                <div>
                  <label for="lastname">Last Name</label><br>
                  <input type="text" name="lastname" placeholder="Last Name" value="<?php echo $lastname ?>"><br>
                </div>
              </div><br>
              <div class="application-input">
                <label for="useric">IC Number</label><br>
                <input type="text" name="useric" placeholder="IC Number" value="<?php echo $ic ?>" required><br>
              </div><br>
              <div class="application-input">
                <label for="gender">Gender</label><br><br>
                <div class="radio-gender">
                  <input type="radio" id="male" name="gender" value="M" <?php if ($gender == "Male"){ echo 'checked="checked"'; } ?>>
                  <label for="male"><b>Male</b></label><br>
                  <input type="radio" id="female" name="gender" value="F" <?php if ($gender == "Female"){ echo 'checked="checked"'; } ?>>
                  <label for="female"><b>Female</b></label>
                </div>
              </div><br>
              <div class="application-input">
                <label for="phoneno">Phone No.</label><br>
                <input type="text" name="phoneno" placeholder="Phone Number" value="<?php echo $phoneno ?>" required><br>
              </div><br>
              <div class="application-input">
                <label for="address">Address</label><br>
                <textarea name="address" rows="4" cols="50" placeholder="Enter your address here..." required><?php 
                  echo $address 
                ?></textarea><br>
              </div><br>
              <input type="submit" name="apply-submit" value="Apply">
            </form>
          </div>
        </div>
      </body>
    </html>
<?php
  if (isset($_POST["apply-submit"])) {

    include("dbconnect.php");
    $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
    $ic = mysqli_real_escape_string($connect, $_POST['useric']);
    $gender = $_POST['gender'];
    $phoneno = mysqli_real_escape_string($connect, $_POST['phoneno']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);

    $sql = "INSERT INTO applications (userID, userFName, userLName, userIC, userGender, userAddress, userPhoneNo) 
            VALUES ('".$_SESSION['userID']."','".$firstname."','".$lastname."','".$ic."','".$gender."','".$address."','".$phoneno."')";
    $result = mysqli_query($connect,$sql);

    $sql = "UPDATE user SET 
            userFName = '$firstname',
            userLName = '$lastname',
            userIC = '$ic',
            userGender = '$gender',
            userAddress = '$address',
            userPhoneNo = '$phoneno'
            WHERE userID = '$id'";
    $update_result = mysqli_query($connect,$sql);

    mysqli_close($connect);

    if ($result && $update_result) {
      echo "<script>
              alert('Your Application has been submitted!');
              window.location.replace('dashboard.php');
            </script>";
    } else {
      echo "<script>alert('Something went wrong!');</script>";
    }
  } 
?>
