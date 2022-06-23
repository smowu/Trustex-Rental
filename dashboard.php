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
      $resultuser = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());

      $user = mysqli_fetch_assoc($resultuser);
      $username = $user['userName'];
      
      $firstname = $user['userFName'];
      if ($firstname == null) {
        $firstname = "--";
      }

      $sql = "SELECT * FROM request WHERE request.userID = $id";
      $resultreq = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
      $row = mysqli_num_rows($resultreq);
      mysqli_close($connect);

      $req = mysqli_fetch_assoc($resultreq);

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
              <p><?php echo $firstname ?></p>
            </div>
          </div>
          <a href="landlord-sign-up.php">
            <button class="register-landlord-button">Become a Landlord</button>
          </a>
        </div>
        <div class="container-right">
          <div class="rental-status">
            <h3>Rental Status</h3>
            <div class="rent-status">
              <div>
                <p>You don't have any active rents!</p><br>
                <a href="index.php#listing-body" onclick="focusSearch(600)">
                  <button>Explore listings</button>
                </a>
              </div>
            </div>
            <!-- 
            <div class="rent-status">
              <ul>

              </ul>
            </div> -->
          </div>
          <div class="rental-history">
            <h3>Rental History</h3>
            <div class="rental-history-table">
              <?php $numrows = 24; 
                if ($numrows > 0) {
              ?>
              <div class="rent-history">
                <table>
                  <tr class="no-hover">
                    <th>Req ID</th>
                    <th>Property Name</th>
                    <th>Landlord</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Duration</th>
                    <th>Rent Price</th>
                  </tr>
                  <tr class="no-hover"><th class="th-border" colspan="7"></th></tr>
                  <?php
                    
                    for ($i = 0; $i < $numrows; $i++) {
                  ?>
                    <tr>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                    </tr>
                  <?php
                      if ($i < $numrows-1) {
                        echo "<tr class='spacer'><td></td></tr>";
                      }
                    }
                  ?>
                </table>
              </div> 
              <?php
                } else {
              ?>
              <div class="rent-history">
                <p>No previous rents was found!</p>
              </div>
              <?php  
                }
              ?>
              </div>
            
           
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