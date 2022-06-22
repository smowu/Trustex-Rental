<?php 
  session_start();
  if (isset($_SESSION['userID'])) {
    if ($_SESSION['userType'] == 'A') {
      header("Location: dashboard-admin.php");
    } else if ($_SESSION['userType'] == 'L') {
      header("Location: dashboard-landlord.php");
    } else {
      $id = $_SESSION['userID'];
      include("dbconnect.php");
      $sql = "SELECT * FROM user WHERE userID = $id";
      $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
      $row = mysqli_num_rows($result);
      mysqli_close($connect);

      $user = mysqli_fetch_assoc($result);
      $username= $user['userName'];
      include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="dashboard">
    <div class="dashboard-container container-margin">
      <h1>Dashboard</h1>
      <div class="dashboard-content">
        <div class="container-left">
          <div class="account-info">
            <div class="account-profile">
              <image src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
              <h2><?php echo $username ?></h2>
              <p><?php echo $useremail ?></p><br>
              <p><?php echo $usertype ?> Account</p>
              <p>User ID: <?php echo sprintf('%010d', $id)?></p><br>
              <hr>
            </div>
          </div>
          <a href="landlord-sign-up.php">
            <button class="register-landlord-button">Become a Landlord</button>
          </a>
        </div>
        <div class="container-right">
          <div class="rental-status">

          </div>
          <div class="rental-history">

          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
      include("html/footer.html");
    }
  } else {
    header("Location: login.php");
  }
?>