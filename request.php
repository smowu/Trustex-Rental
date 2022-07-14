<?php 
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != "L") {
    header("Location: dashboard.php");
  }
  $ticket = $_GET['t'];
  include("dbconnect.php");
  $sql = "SELECT *
          FROM property, listing, request
          LEFT JOIN user ON request.userID = user.userID
          WHERE listing.propertyID = property.propertyID AND request.listingID = listing.listingID AND ticketNo = '$ticket'";

  $result = mysqli_query($connect, $sql);
  mysqli_close($connect);
  $request = mysqli_fetch_assoc($result);

  if ($request['landlordRegNo'] != $_SESSION['landlordRegNo']) {
    header("Location: dashboard-landlord.php");
  }
  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="property">
    <div class="default-container container-margin">
      <h1>Request Details</h1><br>
      <p>Ticket No.: <?php echo sprintf("%08d",$request['ticketNo']) ?></p>
      <p>Requested on: <?php echo $request['requestTimestamp'] ?></p><br>

      <div class="max-container request-details-container">
        <h2>Requested Property Details</h2><br>
        Property ID: <a href="property.php?id=<?php echo $request['propertyID'] ?>"><?php echo sprintf("%08d",$request['propertyID']) ?></a><br>
        Listing ID: <a href="listing.php?id=<?php echo $request['listingID'] ?>"><?php echo sprintf("%012d",$request['listingID']) ?></a><br><br>
        <div class="request-details">
          <label>Property Name</label>
          <p><?php echo $request['propertyName'] ?></p>
        </div>
        <div class="request-details">
          <label>Rent Price</label>
          <p>RM <?php echo $request['rentPrice'] ?>/month</p>
        </div>
      </div>
      
      <div class="max-container request-details-container">
        <h2>Renting Details</h2><br>
        <div class="request-details">
          <label>No. of Tenant(s)</label>
          <p><?php echo $request['rentNumTenants'] ?></p>
        </div>
        <div class="request-details">
          <label>Duration</label>
          <p><?php echo $request['rentDuration'] ?> month(s)</p>
        </div>
        <div class="request-details">
          <label>Start Date</label>
          <p><?php echo (new DateTime($request['rentStartDate']))->format("d-m-Y") ?></p>
        </div>
        <div class="request-details">
          <label>End Date</label>
          <p><?php echo (new DateTime($request['rentEndDate']))->format("d-m-Y") ?></p>
        </div>
      </div>
      
      <div class="max-container request-details-container">
        <h2>Tentant Details</h2><br>
        <?php
          $profileicon = "assets/images/users/user-".sprintf('%010d', $request['userID'])."/profile-picture/profile-picture.png";
        ?>
        <div class="propic-container propic-tenant-details-container">
          <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
        </div>
        <div class="request-details">
          <label>Username</label>
          <p><?php echo $request['userName'] ?></p>
        </div>
        <div class="request-details">
          <label>Email Address</label>
          <p><?php echo $request['userEmail'] ?></p>
        </div>
        <div class="request-details">
          <label>Name</label>
          <p><?php echo $request['userFName'] . " " . $request['userLName'] ?></p>
        </div>
        <div class="request-details">
          <label>IC Number</label>
          <p><?php echo $request['userIC'] ?></p>
        </div>
        <div class="request-details">
          <label>Gender</label>
          <p>
            <?php 
              if ($request['userGender'] == 'M') {
                echo "Male";
              } else if ($request['userGender'] == 'F') {
                echo "Female";
              } else {
                echo "N/A";
              }
            ?>
          </p>
        </div>
        <div class="request-details">
          <label>Address</label>
          <p><?php echo $request['userAddress'] ?></p>
        </div>
        <div class="request-details">
          <label>Phone No.</label>
          <p><?php echo $request['userPhoneNo'] ?></p>
        </div>
      </div>
      
      
      <?php
        if (isset($_GET['status']) && $_GET['status'] == "Pending") {
      ?>
        <form method="POST" action="request-result.php">
          <input type="text" name="ticketNo" value="<?php echo $request['ticketNo'] ?>" style="display: none;">
          <input class="application-form-button approve-button" type="submit" name="accept" value="Accept">
          <input class="application-form-button reject-button" type="submit" name="reject" value="Reject">
        </form><br>
      <?php
        }

        // if (isset($_GET['status']) && ($_GET['status'] == "Active" || $_GET['status'] == "Upcoming")) {
      ?>
          <div class="transaction-container">
           <?php
              include("dbconnect.php");
              $sql = "SELECT *
                      FROM payment
                      WHERE ticketNo = '$ticket'";
              $result = mysqli_query($connect, $sql);
              $payments = mysqli_query($connect, $sql);
              mysqli_close($connect);

              $num_payments_made = 0;
              while ($payment = mysqli_fetch_array($payments)) {
                $num_payments_made += $payment['paymentDuration'];
              }
              $months_left = $request['rentDuration'] - $num_payments_made;
              $payments_left = $months_left * $request['rentPrice'];
              $numrows = mysqli_num_rows($result);
            ?>
            <h3>Payment History</h3>
            <div class="dashboard-table-content">
            <?php if ($numrows > 0) { ?>
              <div class="dashboard-table">
                <table>
                  <tr class="no-hover">
                    <th>Transaction ID</th>
                    <th>Timestamp</th>
                    <th>Rent Price</th>
                    <th>Duration</th>
                    <th>Type</th>
                  </tr>
                  <tr class="no-hover"><th class="th-border" colspan="5"></th></tr>
                  <?php
                  for ($i = 0; $transaction = mysqli_fetch_assoc($result); $i++) {
                  ?>
                    <tr>
                      <td><?php echo sprintf("%012d",$transaction['transactionID']) ?></td>
                      <td><?php echo $transaction['paymentTimestamp'] ?></td>
                      <td><?php echo sprintf("%.2f",$transaction['rentPrice']) ?></td>
                      <td><?php echo $transaction['paymentDuration'] ?> month(s)</td>
                      <td>RM <?php echo sprintf("%.2f",$transaction['paymentAmount']) ?></td>
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
              <div class="request-details">
                No. of Payments Remaining: <b><?php echo $months_left ?></b><br>
                Total Remaining: <b>RM <?php echo sprintf("%.2f",$payments_left) ?></b>
              </div>
              <?php
                } else {
              ?>
                  <div class="dashboard-empty">
                    <div>
                      <p>No transaction has been made.</p>
                    </div>
                  </div>
              <?php  
                }
              ?>
            </div>
          </div>
      <?php
        // }
      ?>
      <br>
      <a class="return-dashboard" href="dashboard.php">
        <img src="assets/icons/back-button.png"></img>
        <h4>Return to Dashboard</h4>
      </a>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>