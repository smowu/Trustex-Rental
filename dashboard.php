<?php 
  session_start();
  if (isset($_SESSION['userID'])) {
    if ($_SESSION['userType'] == 'A') {
      header("Location: dashboard-admin.php");
    } else if ($_SESSION['userType'] == 'L') {
      header("Location: dashboard-landlord.php");
    } else {
      $id = $_SESSION['userID'];
      $username = $_SESSION['userName'];
      $email = $_SESSION['userEmail'];
      $usertype = $_SESSION['userType'];

      include("dbconnect.php");
      $sql = "SELECT userID, applicationStatus FROM applications WHERE applications.userID = $id";
      $resultapplication = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());

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
              <p><?php echo $email ?></p><br>
              <p><?php echo $usertype ?> Account</p><br>
            </div>
          </div>
          <?php
            if (mysqli_num_rows($resultapplication) != 0) {
              $application = mysqli_fetch_assoc($resultapplication);
              if ($application['applicationStatus'] == "Pending") {
          ?>
          <p>Your landlord application has been sent.</p><br>
          <button class="apply-landlord-button button-disable" disabled>Application Pending</button>
          <?php
              } else if ($application['applicationStatus'] == "Accepted") {
          ?>
          <p>Your landlord application has been ACCEPTED!</p><br>
          <a href="dashboard-landlord.php">
            <button class="apply-landlord-button">Switch to Landlord account</button>
          </a>
          <?php
              } else if ($application['applicationStatus'] == "Rejected") {
          ?>
          <p>Your landlord application has been REJECTED!<br>Try re-applying again.</p><br>
          <a href="landlord-application.php">
            <button class="apply-landlord-button">Re-apply</button>
          </a>
          <?php
              } else {
                echo "<p>Unable to fetch application details.</p>";
              }
            } else {
          ?>
          <p>Want to list your property on Trustex?<br><br>Apply for a Landlord account now!</p><br>
          <a href="landlord-application.php">
            <button class="apply-landlord-button">Become a Landlord</button>
          </a>
          <?php
            }
          ?>
        </div>
        <div class="container-right">
          <div class="rental-status">
            <h3>Rental Status</h3>
            <div class="rent-status">
              <div>
                <p>You don't have any active rents!</p><br>
                <a href="index.php#listing-body" onclick="focusSearch(600)">
                  <button class="rental-status-explore-button">Explore listings</button>
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
                    <tr onclick="location.href='property.php'">
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                      <td>text</td>
                    </tr>
                  <?php
                      // Gap between rows
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