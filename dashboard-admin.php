<?php
  session_start();
  if (isset($_SESSION['userID']) && $_SESSION['userType'] == 'A') {
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
          <div>
            <h3>Landlord Applications</h3>
            <div class="dashboard-table-content">
              <?php 
                include("dbconnect.php");
                $sql = "SELECT * FROM applications WHERE applicationStatus = 'Pending'";
                $app_list_result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($app_list_result);
                // $numrows = 0; 
                if ($numrows > 0) {
              ?>
                  <div class="dashboard-table">
                    <table>
                      <tr class="no-hover">
                        <th>Application ID</th>
                        <th>Date</th>
                        <th>Name</th>
                        <th>IC Number</th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr class="no-hover"><th class="th-border" colspan="7"></th></tr>
                      <?php
                        for ($i = 0; $applicant = mysqli_fetch_assoc($app_list_result); $i++) {
                          $location = "location.href='application-details.php?id=".$applicant['applicationID']."'";
                      ?>
                          <tr ondblclick="<?php echo $location ?>" style="user-select: none;">
                            <td><?php echo sprintf('%06d', $applicant['applicationID']); ?></td>
                            <td>date</td>
                            <td><?php echo $applicant['userFName']." ".$applicant['userLName']; ?></td>
                            <td><?php echo $applicant['userIC']; ?></td>
                            <td><button onclick="<?php echo $location ?>">View</button></td>
                            <td>
                              <form method="POST" action="application-result.php">
                                <input type="text" name="id" value="<?php echo $applicant['applicationID'] ?>" style="display: none;">
                                <input type="submit" name="approve" value="Approve">
                                <input type="submit" name="reject" value="Reject">
                              </form>
                            </td>
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
                      <p>You don't have any active rents!</p>
                    </div>
                  </div>
              <?php  
                }
              ?>
            </div>
          </div>
          <div>
            <h3>Current Landlord</h3>
            <div class="dashboard-table-content">
              <?php 
                include("dbconnect.php");
                $sql = "SELECT landlordRegNo, landlord.userID, user.userFName, user.userLName, user.userIC, adm.userName AS admin_username
                        FROM landlord
                        LEFT JOIN user ON landlord.userID = user.userID
                        LEFT JOIN (
                          SELECT administrator.administratorID, user.userName
                          FROM administrator, user
                          WHERE user.userID = administrator.userID
                        ) AS adm ON adm.administratorID = landlord.administratorID";

                $landlord_list_result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($landlord_list_result);
                // $numrows = 0; 
                if ($numrows > 0) {
              ?>
              <div class="dashboard-table">
                <table>
                  <tr class="no-hover">
                    <th>Reg No</th>
                    <th>Name</th>
                    <th>IC Number</th>
                    <th>Approved By</th>
                    <th></th>
                  </tr>
                  <tr class="no-hover"><th class="th-border" colspan="5"></th></tr>
                  <?php
                    for ($i = 0; $landlord = mysqli_fetch_assoc($landlord_list_result); $i++) {
                      $location = "location.href='landlord-details.php?id=".$landlord['landlordRegNo']."'";
                  ?>
                    <tr ondblclick="<?php echo $location ?>" style="user-select: none;">
                      <td><?php echo sprintf('%06d', $landlord['landlordRegNo']); ?></td>
                      <td><?php echo $landlord["userFName"]." ".$landlord["userLName"] ?></td>
                      <td><?php echo $landlord["userIC"] ?></td>
                      <td><?php echo $landlord["admin_username"] ?></td>
                      <td><button onclick="<?php echo $location ?>">View</button></td>
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
            </div>
              <?php
                } else {
              ?>
                  <div class="dashboard-empty">
                    <div>
                      <p>No landlord found!</p>
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
  } else {
    header("Location: dashboard.php");
  }
?>