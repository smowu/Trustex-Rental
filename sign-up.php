<?php 
  // session_start(); 
  include("dbconnect.php"); 

  if (isset($connect)) {
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
    </div>
    <!-- Sign up section/container -->
    <div class="user-signup-section">
      <div class="user-signup-form-container">
        <h1>Sign Up</h1>
        <!-- Sign up form -->
        <form class="user-signup-form" name="user-signup-form" method="POST" action="sign-up0.php">
          <div class="form-textinput signup-input">
            <input type="text" id="username" name="username" placeholder="Username" required><br>
          </div><br>
          <div class="form-textinput signup-input">
            <input type="text" id="useremail" name="useremail" placeholder="Email" required><br>
          </div><br>
          <div class="form-textinput signup-input">
            <input type="password" id="userpassword" name="userpassword" placeholder="Password" required><br>
          </div><br>
          <div class="form-textinput signup-input">
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required><br>
          </div><br>
  
          <input type="submit" name="signup-submit" value="Sign Up">
        </form>
        <br><hr><br>
        <!-- For going to the sign in page -->
        <p>Already have an account? <a href="login.php"><b>Log in</b></a></p> 
      </div>
    </div>
  </body>
</html>
<?php
    mysqli_close($connect);
  }
?>