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
              <div class="propic-container propic-dashboard-container">
                <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
              </div>
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
          <?php 
            include("dbconnect.php");
            $sql = "SELECT ticketNo, requestTimestamp, propertyName, requestStatus
                    FROM request
                    LEFT JOIN (
                      SELECT propertyName, listingID
                      FROM property, listing
                      WHERE listing.propertyID = property.propertyID
                    ) AS list ON request.listingID = list.listingID
                    WHERE userID = '$id' AND (requestStatus = 'Accepted' OR requestStatus = 'Rejected')";
            $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
            mysqli_close($connect);

            $numrows = mysqli_num_rows($result);
            if ($numrows > 0) {
          ?>
            <div>
              <h3>Recent Request Status</h3>
              <div class="dashboard-table-content">
                <div class="dashboard-table">
                  <table>
                    <tr class="no-hover">
                      <th>Request ID</th>
                      <th>Requested On</th>
                      <th>Property Name</th>
                      <th>Result</th>
                      <th></th>
                    </tr>
                    <tr class="no-hover"><th class="th-border" colspan="5"></th></tr>
                    <?php
                      for ($i = 0; $request = mysqli_fetch_assoc($result); $i++) {
                        $location = "location.href='request.php?id=".$request['ticketNo']."'";
                    ?>
                      <tr ondblclick="location.href='property.php'">
                        <td><?php echo sprintf("%08d",$request['ticketNo']) ?></td>
                        <td><?php echo date("Y-m-d", strtotime($request['requestTimestamp'])) ?></td>
                        <td><?php echo $request['propertyName'] ?></td>
                        <td><b><?php echo $request['requestStatus'] ?></b></td>
                        <td>
                          <form action="" method="POST">
                            <input type="submit" name="dismiss" value="Dismiss">
                            <input type="text" name="ticketNo" value="<?php echo $request['ticketNo'] ?>" style="display: none;">
                            <input type="text" name="requestStatus" value="<?php echo $request['requestStatus'] ?>" style="display: none;">
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
              </div>
            </div>
          <?php
            }
          ?>
          <div>
            <h3>Rental Status</h3>
            <div class="dashboard-table-content">
              <?php
                include("dbconnect.php");
                $sql_update = "UPDATE request SET requestStatus = CASE 
                               WHEN rentStartDate < NOW() THEN 'Active'
                               ELSE requestStatus
                               END
                               WHERE userID = '$id' AND (requestStatus = 'Accepted' OR requestStatus = 'Upcoming')";
                $update_result = mysqli_query($connect, $sql_update) or die ("Error: ".mysqli_error());

                if (!$update_result) {
                  echo "<script>alert('Something went wrong!');</script>";
                }

                $sql = "SELECT *
                        FROM request
                        LEFT JOIN (
                          SELECT propertyName, propertyAddress, listingID, landlord.landlordRegNo, userFName, userLName, rentPrice
                          FROM property, listing, user, landlord
                          WHERE listing.propertyID = property.propertyID AND landlord.landlordRegNo = property.landlordRegNo AND user.userID = landlord.userID
                        ) AS list ON request.listingID = list.listingID
                        WHERE userID = '$id' AND (requestStatus = 'Active' OR requestStatus = 'Upcoming' OR requestStatus = 'Accepted')
                        ORDER BY rentStartDate DESC
                        LIMIT 1";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());

                mysqli_close($connect);

                if ($rent = mysqli_fetch_assoc($result)) {
              ?>
                  <div class="rental-status">
                    <?php
                      $now = new DateTime('now');
                      $start_date = new DateTime($rent['rentStartDate']);
                      $end_date = new DateTime($rent['rentEndDate']);

                      if ($rent['requestStatus'] == "Upcoming" || $rent['requestStatus'] == "Accepted") {
                        $days_left = $now->diff($start_date);
                    ?>
                        <p>Your upcoming rent...</p>
                        <h2>in <?php echo $days_left->days ?> Day(s)</h2>
                    <?php
                      } else {
                        echo "<p>Your current rental status</p>";
                      }
                    ?><br>
                    <div class="status-container">
                      <p><b>Property</b></p>
                      <h2><?php echo $rent['propertyName'] ?></h2>
                      <p><?php echo $rent['propertyAddress'] ?></p>
                    </div><br>
                    <div class="status-container">
                      <p><b>Landlord</b></p>
                      <h2><?php echo $rent['userFName'] . " " . $rent['userLName'] ?></h2>
                      <p>Reg. No.: <?php echo sprintf("%06d", $rent['landlordRegNo']) ?></p>
                    </div><br>

                    <div class="status-container">
                      <p><b>Start Date</b></p>
                      <h2><?php echo $start_date->format('d F Y') ?></h2>

                      <p><b>End Date</b></p>
                      <h2><?php echo $end_date->format('d F Y') ?></h2>
                    </div><br>

                    <div class="status-container">
                      <p><b>Rent price per month</b></p>
                      <h2>RM <?php echo $rent['rentPrice'] ?></h2>
                      <br>

                      <p><b>Payments remaining</b></p>
                      <?php
                        $ticket_no = $rent['ticketNo'];
                        include("dbconnect.php");
                        $sql = "SELECT *
                                FROM payment
                                WHERE ticketNo = '$ticket_no'";
                        $result_payments = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                        mysqli_close($connect);

                        $num_payments_made = 0;
                        while ($payment = mysqli_fetch_array($result_payments)) {
                          $num_payments_made += $payment['paymentDuration'];
                        }

                        $months_left = $rent['rentDuration'] - $num_payments_made;
                        $payments_left = $months_left * $rent['rentPrice'];
                      ?>
                      <h2><?php echo $months_left . " (RM " . sprintf("%.2f",$payments_left) . ")" ?></h2>
                      <br>

                      <p><b>Your next payment in...</b></p>
                      <?php 
                        $next_payment_date = new DateTime($rent['rentStartDate']);
                        $num_days = $num_payments_made * 30;
                        $next_payment_date->add(new DateInterval('P'.$num_days.'D'));

                        $payment_days_left = $now->diff($next_payment_date);
                      ?>
                      <h2><?php echo $payment_days_left->days . " Day(s) on " . $next_payment_date->format('d F Y') ?></h2><br>

                      <a href="payment.php?ticket=<?php echo $rent['ticketNo'] ?>"><button>Make Payment</button></a>
                    </div>
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
                        FROM history
                        WHERE userID = '$id'";
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
                        <th></th>
                      </tr>
                      <tr class="no-hover"><th class="th-border" colspan="8"></th></tr>
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
                          <td>
                            <button class="view-button" onclick="<?php echo $location ?>">
                              <image class="icon view-icon" src="assets/icons/eye.png"><span>View</span>
                            </button>
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
    
    if (isset($_POST['dismiss'])) {
      $new_status = "";
      if ($_POST['requestStatus'] == "Accepted") {
        $new_status = "Upcoming";
      } else if ($_POST['requestStatus'] == "Rejected") {
        $new_status = "Archived";
      }

      $ticket_no = $_POST["ticketNo"];
      include("dbconnect.php");
      $sql = "UPDATE request SET
              requestStatus = '$new_status'
              WHERE ticketNo = '$ticket_no'";
      $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
      mysqli_close($connect);
      echo "<script>window.location.replace('dashboard.php');</script>";
    }

  }
?>