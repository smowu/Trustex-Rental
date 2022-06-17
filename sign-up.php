<?php 
  include("dbconnect.php"); 
  
  if (isset($connect)) {
    $username = "";
    $email = "";
    if (isset($_POST['signup-submit'])) {
      // Capture values from user sign-up form
      $username = $_POST['username'];
      $email = $_POST['useremail'];
      $password = md5($_POST['userpassword']); // md5() used for data encryption
      $confirmpassword = md5($_POST['confirmpassword']);
  
      if ($password == $confirmpassword) {
        // Checks if the email address is already exist in the database
        $sql = "SELECT * FROM user WHERE userEmail = '$email'";
        $result = mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));

        if (mysqli_num_rows($result) == 0) {
          // Inserting new data into the database
          $sql = "INSERT INTO user (userName, userEmail, userPassword) 
                  VALUES('".$username."','".$email."','".$password."')";

          $result = mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));
          
          if ($result) {
            echo "<script>alert('Registration successful!');</script>";
            $username = "";
            $email = "";
            $_POST['userpassword'] = "";
            $_POST['confirmpassword'] = "";
          } else {
            echo "<script>alert('Error: Something went wrong!');</script>";
          }
        } else {
          echo "<script>alert('The email is already registered! Sign in instead.');</script>";
        }
      } else {
        echo "<script>alert('Password is not matched.');</script>";
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
        <form class="user-signup-form" name="user-signup-form" method="POST" action="">
          <div class="form-textinput signup-input">
            <input type="text" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>" required><br>
          </div><br>
          <div class="form-textinput signup-input">
            <input type="text" id="useremail" name="useremail" placeholder="Email" value="<?php echo $email; ?>" required><br>
          </div><br>
          <div class="form-textinput signup-input">
            <input type="password" id="userpassword" name="userpassword" placeholder="Password" value="" required><br>
          </div><br>
          <div class="form-textinput signup-input">
            <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" value="" required><br>
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