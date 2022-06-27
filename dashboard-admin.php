<?php
  session_start();
  if (isset($_SESSION['userID']) && $_SESSION['userType'] == 'A') {
    include("dbconnect.php");
    $sql = "SELECT * FROM user WHERE userID = ".$_SESSION['userID']."";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    mysqli_close($connect);

    $user = mysqli_fetch_assoc($result);

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
        </div>
        <div class="container-right">
          <div class="rental-history admin-landlord-applicants">
            <h3>Landlord Applicants</h3>
            <div class="rental-history-table">
              <?php 
                include("dbconnect.php");
                $sql = "SELECT * FROM applications WHERE applicationStatus = 'Pending'";
                $list_result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($list_result);
                // $numrows = 0; 
                if ($numrows > 0) {
              ?>
              <div class="rent-history">
                <table>
                  <tr class="no-hover">
                    <th>Application ID</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>IC Number</th>
                    <th>Details</th>
                    <th>Accept</th>
                    <th>Reject</th>
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
                <p>No active application.</p>
              </div>
              <?php  
                }
              ?>
              </div>
          </div>
          <div class="rental-history">
            <h3>Current Landlord</h3>
            <div class="rental-history-table">
              <?php $numrows = 10; 
                if ($numrows > 0) {
              ?>
              <div class="rent-history">
                <table>
                  <tr class="no-hover">
                    <th>Reg No</th>
                    <th>Name</th>
                    <th>IC Number</th>
                    <th>Approved By</th>
                  </tr>
                  <tr class="no-hover"><th class="th-border" colspan="8"></th></tr>
                  <?php
                    
                    for ($i = 0; $i < $numrows; $i++) {
                  ?>
                    <tr onclick="location.href='property.php'">
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
  } else {
    header("Location: dashboard.php");
  }
?>