<?php 
  session_start();
  $username = "";
  $email = "";
  if (isset($_POST["register-submit"])) {
    // Capture values from user sign-up form
    $userid = $_SESSION['userID'];
    $username = $_POST['username'];
    $email = $_POST['useremail'];

  } 
  // echo "<script>alert('Password is not matched.');</script>";
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
    <div class="user-signup-section">
      <div class="user-signup-form-container">
        <h2>Landlord Application Form</h2>
        <!-- Sign up form -->
        <form class="user-signup-form" name="user-signup-form" method="POST" action="">
          <div class="form-textinput signup-input">
            <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>" required><br>
          </div><br>
          <div class="form-textinput signup-input">
            <input type="text" id="useremail" name="useremail" placeholder="Email" value="<?php echo $email; ?>" required><br>
          </div><br>
  
          <input type="submit" name="register-submit" value="Register">
        </form>
      </div>
    </div>
  </body>
</html>