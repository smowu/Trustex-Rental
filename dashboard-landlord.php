<?php
  session_start();
  if (isset($_SESSION['userID']) && $_SESSION['userType'] == 'L') {
    $id = $_SESSION['userID'];
    include("dbconnect.php");
    $sql = "SELECT * FROM user WHERE userID = $id";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    $row = mysqli_num_rows($result);
    mysqli_close($connect);

    if ($row == 0) {
      header("Location: login.php");
    } else {
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
              <p><?php echo $usertype ?> Account</p><br>
              <hr>
            </div>
          </div>
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
    header("Location: dashboard.php");
  }
?>