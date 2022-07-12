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

  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
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
      <p>Listing ID: <a href="listing.php?id=<?php echo $request['listingID'] ?>"><?php echo sprintf("%012d",$request['listingID']) ?></a></p>
      <p>Requested on: <?php echo $request['requestTimestamp'] ?></p><br>

      <h2>Requested Property Details</h2><br>
      <p>Property ID: <a href="property.php?id=<?php echo $request['propertyID'] ?>"><?php echo sprintf("%08d",$request['propertyID']) ?></a></p><br>
      <p>Property Name: </p>
      <p><?php echo $request['propertyName'] ?></p><br>
      <p>Rent Price: </p>
      <p>RM <?php echo $request['rentPrice'] ?>/month</p><br>

      <h2>Renting Details</h2><br>
      <p>No. of Tenant(s): </p>
      <p><?php echo $request['rentNumTenants'] ?></p><br>
      <p>Duration: </p>
      <p><?php echo $request['rentDuration'] ?> month(s)</p><br>
      <p>Start Date: </p>
      <p><?php echo $request['rentStartDate'] ?></p><br>
      <p>End Date: </p>
      <p><?php echo $request['rentEndDate'] ?></p><br>

      <h2>Tentant Details</h2><br>
      <?php
        $profileicon = "assets/images/users/user-".sprintf('%010d', $request['userID'])."/profile-picture/profile-picture.png";
      ?>
      <div class="propic-container propic-tenant-details-container">
        <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
      </div><br>
      <p>Username: </p>
      <p><?php echo $request['userName'] ?></p><br>
      <p>Email Address: </p>
      <p><?php echo $request['userEmail'] ?></p><br>
      <p>Name: </p>
      <p><?php echo $request['userFName'] . " " . $request['userLName'] ?></p><br>
      <p>IC Number: </p>
      <p><?php echo $request['userIC'] ?></p><br>
      <p>Gender: </p>
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
      </p><br>
      <p>Address: </p>
      <p><?php echo $request['userAddress'] ?></p><br>
      <p>Phone No.: </p>
      <p><?php echo $request['userPhoneNo'] ?></p><br>
      
      <?php
        if (isset($_GET['status']) && $_GET['status'] == "Pending") {
      ?>
        <form method="POST" action="request-result.php">
          <input type="text" name="ticketNo" value="<?php echo $request['ticketNo'] ?>" style="display: none;">
          <input type="submit" name="accept" value="Accept">
          <input type="submit" name="reject" value="Reject">
        </form><br>
      <?php
        }

        if (isset($_GET['status']) && ($_GET['status'] == "Active" || $_GET['status'] == "Upcoming")) {
      ?>
          <div class="transaction-container">
            <h3>Payment History</h3>
            <div class="dashboard-table-content">
              <?php
                include("dbconnect.php");
                $sql = "SELECT *
                        FROM payment
                        WHERE ticketNo = '$ticket'";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($result);
                if ($numrows > 0) {
              ?>
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
        }
      ?>

      <a href='dashboard-landlord.php'>Return to Dashboard</a>

    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>