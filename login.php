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
    <div id="login-splashscreen">
      <a href="index.php">
        <img height="32" src="assets/images/TrustexLogo.png" alt="Trustex Logo">
      </a>
    </div>
    <!-- Log in section/container -->
    <div class="user-login-section">
      <div class="user-login-form-container">
        <h1>Log in</h1>
        <!-- Log in form -->
        <form class="user-login-form" name="user-login-form" method="POST" action="login0.php">
          <div class="form-textinput login-input">
            <input type="text" id="useremail" name="useremail" placeholder="Email" required><br>
          </div><br>
          <div class="form-textinput login-input">
            <input type="password" id="userpassword" name="userpassword" placeholder="Password" required><br>
          </div><br>
  
          <input type="submit" name="login-submit" value="Log in">
        </form>
        <br><hr><br>
        <!-- For going to the sign up page -->
        <p>Don't have an account? <a href="sign-up.php"><b>Sign Up</b></a></p> 
      </div>
    </div>
  </body>
</html>
<?php
    mysqli_close($connect);
  }
?>