<?php 
  $email = "";
  if (isset($_POST['login-submit'])) {
    include("dbconnect.php");
    // Capture values from user login form
    $email = $_POST['useremail'];
    $password = md5($_POST['userpassword']); // md5() used for encryption

    // Checks if the username/email and the matched password is in the database
    $sql = "SELECT * FROM user 
            WHERE userName = '$email' OR userEmail = '$email' AND userPassword = '$password'";
    $result = mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));
    mysqli_close($connect);
    
    if (mysqli_num_rows($result) != 0) {
      session_start();
      $row = mysqli_fetch_assoc($result);
      $_SESSION['userID'] = $row['userID'];
      $usertype = $row['userType'];
      
      if ($usertype == 'A') {
        echo "
          <script>
            alert('User is admin');
            window.location.replace('dashboard.php'); 
          </script>
        ";
        // header("Location: dashboard.php");
      } else if ($usertype == 'L') {
        echo "
          <script>
            alert('User is landlord');
            window.location.replace('dashboard.php'); 
          </script>
        ";
        // header("Location: dashboard.php");
      } else {
        echo "
          <script>
            alert('User is normal user/tenant');
            window.location.replace('dashboard.php'); 
          </script>
        ";
        // header("Location: dashboard.php");
      }
      
    } else {
      echo "<script>alert('Incorrect email or password!');</script>";
    }
  }
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
        <form class="user-login-form" name="user-login-form" method="POST" action="">
          <div class="form-textinput login-input">
            <input type="text" id="useremail" name="useremail" placeholder="Username or Email" value="<?php echo $email; ?>" required><br>
          </div><br>
          <div class="form-textinput login-input">
            <input type="password" id="userpassword" name="userpassword" placeholder="Password" value="" required><br>
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
