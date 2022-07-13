<?php 
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 'T') {
    header("Location: dashboard.php");
  }
  include("dbconnect.php");
  $sql = "SELECT * FROM user WHERE userID = ".$_SESSION['userID']."";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
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
        <link rel="stylesheet" href="./styles/style.css" type="text/css">
      </head>
      <body style="display: inline-flex; background-color: #257b9f;">
        <!-- Splashscreen & logo on the left side -->
        <div class="register-splashscreen">
          <a href="index.php">
            <img height="32" src="assets/images/TrustexLogo.png" alt="Trustex Logo">
          </a>
          <a href="dashboard.php" class="return-dashboard-landlord">
            <h3>Return to Dashboard</h3>
          </a>
        </div>
        <!-- Sign up section/container -->
        <div class="landlord-application-section">
          <div class="landlord-application-form-container">
            <h1>Landlord Application Form</h1>
            <!-- Sign up form -->
            <form class="landlord-application-form" name="landlord-application" method="POST" action="">
              <div class="application-input">
                <input type="text" name="firstname" placeholder="First Name" value="<?php echo $firstname ?>" required><br>
                <input type="text" name="lastname" placeholder="Last Name" value="<?php echo $lastname ?>"><br>
              </div><br>
              <div class="application-input">
                <input type="text" name="useric" placeholder="IC Number" value="<?php echo $ic ?>" required><br>
              </div><br>
              <div class="application-input">
                <div class="radio-gender">
                  <input type="radio" id="male" name="gender" value="M" <?php if ($gender == "Male"){ echo 'checked="checked"'; } ?>>
                  <label for="male"><b>Male</b></label><br>
                  <input type="radio" id="female" name="gender" value="F" <?php if ($gender == "Female"){ echo 'checked="checked"'; } ?>>
                  <label for="female"><b>Female</b></label>
                </div>
              </div><br>
              <div class="application-input">
                <input type="text" name="phoneno" placeholder="Phone Number" value="<?php echo $phoneno ?>" required><br>
              </div><br>
              <div class="application-input">
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
    // Capture values from user sign-up form
    include("dbconnect.php");
    $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
    $ic = mysqli_real_escape_string($connect, $_POST['useric']);
    $gender = $_POST['gender'];
    $phoneno = mysqli_real_escape_string($connect, $_POST['phoneno']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);

    $sql = "INSERT INTO applications (userID, userFName, userLName, userIC, userGender, userAddress, userPhoneNo) 
            VALUES ('".$_SESSION['userID']."','".$firstname."','".$lastname."','".$ic."','".$gender."','".$address."','".$phoneno."')";
    $result = mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));
    mysqli_close($connect);

    if ($result) {
      echo "<script>
              alert('Your Application has been submitted!');
              window.location.replace('dashboard.php');
            </script>";
    } else {
      echo "<script>alert('Something went wrong!');</script>";
    }
  } 
?>
