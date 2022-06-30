<?php 
  session_start();
  if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
  }
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
    $sql = "SELECT userID, applicationID, applicationStatus FROM applications WHERE applications.userID = $id";
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
              $status = null;
              $app_id = null;
              while ($application = mysqli_fetch_assoc($resultapplication)) {
                $status = $application['applicationStatus'];
                $app_id = $application['applicationID'];
              }
              if ($status == "Pending") {
          ?>
                <p>Your landlord application has been sent.</p><br>
                <button class="apply-landlord-button button-disable" disabled>Application Pending</button>
          <?php
              } else if ($status == "Approved") {
          ?>
                <p>Your landlord application has been <b>APPROVED!</b></p><br>
                <form method="POST" action="switch-landlord.php">
                  <input type="text" name="application-id" value="<?php echo $app_id ?>" style="display: none;">
                  <input class="apply-landlord-button" type="submit" name="switch-landlord" value="Switch to Landlord account">
                </form>
          <?php
              } else if ($status == "Rejected") {
          ?>
                <p>Your landlord application has been <b>REJECTED!</b><br>Try re-applying again.</p><br>
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
          <div>
            <h3>Rental Status</h3>
            <div class="dashboard-table-content">
              <?php
                include("dbconnect.php");
                $sql = "SELECT *
                        FROM request, rent
                        WHERE request.ticketNo = rent.ticketNo AND request.userID = '$id'";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($result);
                // $numrows = 5;
                if ($numrows > 0) {
              ?>
                  <div class="dashboard-table">
                    <div style="height:400px;"></div>
                  </div> 
              <?php
                } else {
              ?>
                  <div class="dashboard-empty">
                    <div>
                      <p>You don't have any active rents!</p><br>
                      <a href="index.php#listing-body" onclick="focusSearch(600)">
                        <button>Explore listings</button>
                      </a>
                    </div>
                  </div>
              <?php  
                }
              ?>
            </div>
          </div>
          <div>
            <h3>Rental History</h3>
            <div class="dashboard-table-content">
              <?php 
                include("dbconnect.php");
                $sql = "SELECT *
                        FROM request
                        WHERE request.userID = '$id'";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($result);
                // $numrows = 5;
                if ($numrows > 0) {
              ?>
                  <div class="dashboard-table">
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
                      // for ($i = 0; $x = mysqli_fetch_assoc($result); $i++) {
                         for ($i = 0; $i < $numrows; $i++) {
                          // $location = "location.href='xxxxx.php?id=".$x['xxx']."'";
                           $location = "";
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
                  <div class="dashboard-empty">
                    <div>
                      <p>You don't have any previous rents!</p><br>
                      <a href="index.php#listing-body" onclick="focusSearch(600)">
                        <button>Start renting</button>
                      </a>
                    </div>
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
?>