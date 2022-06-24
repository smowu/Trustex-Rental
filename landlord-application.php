<?php 
  session_start();
  if (isset($_SESSION['userID']) && $_SESSION['userType'] == 'T') {
    if (isset($_POST["apply-submit"])) {
      // Capture values from user sign-up form
      $userid = $_SESSION['userID'];
      $username = $_POST['username'];
      $email = $_POST['useremail'];
      $firstname = $_POST['firstname'];
      $lastname = $_POST['lastname'];
      $useric = $_POST['useric'];
      $phoneno = $_POST['phoneno'];
      $address = $_POST['address'];
  
      include("dbconnect.php");
      $sql = "INSERT INTO applications (userID, userFName, userLName, userIC, userAddress, userPhoneNo) 
              VALUES ('".$userid."','".$firstname."','".$lastname."','".$useric."','".$address."','".$phoneno."')";
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
    // echo "<script>alert('');</script>";
?>
    <!DOCTYPE html>
    <html>
      <head>
        <link rel="stylesheet" href="./styles/style.css" type="text/css">
      </head>
      <body style="display: inline-flex; background-color: #257b9f;">
        <!-- Splashscreen & logo on the left side -->
        <div id="signup-splashscreen">
          <a href="index.php">
            <img height="32" src="assets/images/TrustexLogo.png" alt="Trustex Logo">
          </a>
          <a href="dashboard.php">
            <h3>Return to Dashboard</h3>
          </a>
        </div>
        <!-- Sign up section/container -->
        <div class="landlord-application-section">
          <div class="landlord-application-form-container">
            <h1>Landlord Application Form</h1>
            <!-- Sign up form -->
            <form class="landlord-application-form" name="landlord-application" method="POST" action="">
              <div class="form-textinput application-input">
                <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $_SESSION['userName']; ?>" required readonly><br>
              </div><br>
              <div class="form-textinput application-input">
                <input type="text" id="useremail" name="useremail" placeholder="Email" value="<?php echo $_SESSION['userEmail']; ?>" required readonly><br>
              </div><br>
              <div class="form-textinput application-input">
                <input type="text" id="firstname" name="firstname" placeholder="First Name" value="" required><br>
                <input type="text" id="lastname" name="lastname" placeholder="Last Name" value="" required><br>
              </div><br>
              <div class="form-textinput application-input">
                <input type="text" id="useric" name="useric" placeholder="IC Number" value="" required><br>
              </div><br>
              <div class="form-textinput application-input">
                <input type="text" id="phoneno" name="phoneno" placeholder="Phone Number" value="" required><br>
              </div><br>
              <div class="form-textareainput application-input">
                <textarea id="address" name="address" rows="4" cols="50" placeholder="Enter your address here..." required></textarea><br>
              </div><br>
              <input type="reset" name="reset-form" value="Clear Form">
              <input type="submit" name="apply-submit" value="Apply">
            </form>
          </div>
        </div>
      </body>
    </html>
<?php
  } else {
    header("Location: dashboard.php");
  }
?>
