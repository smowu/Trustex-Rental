<?php
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 'L') {
    header("Location: dashboard.php");
  }
  $id = $_SESSION['userID'];
  include("dbconnect.php");
  $sql = "SELECT * FROM user
          LEFT JOIN landlord ON landlord.userID = user.userID
          WHERE user.userID = $id";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  $row = mysqli_num_rows($result);
  mysqli_close($connect);

  $user = mysqli_fetch_assoc($result);
  $reg_no = $_SESSION['landlordRegNo'] = $user['landlordRegNo'];
  $username = $user['userName'];

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
        </div>
        <div class="container-right">
          <div>
            <h3>Requests</h3>
            <div class="dashboard-table-content">
              <?php
              include("dbconnect.php");
                $sql = "SELECT ticketNo, requestTimestamp, request.listingID, list.propertyName, requestType, user.userName
                        FROM request
                        LEFT JOIN user ON request.userID = user.userID
                        LEFT JOIN (
                          SELECT propertyName, listingID, landlordRegNo
                          FROM property, listing
                          WHERE listing.propertyID = property.propertyID
                        ) AS list ON request.listingID = list.listingID
                        WHERE list.landlordRegNo = '$reg_no'";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($result);
                if ($numrows > 0) {
              ?>
                  <div class="dashboard-table">
                    <table>
                      <tr class="no-hover">
                        <th>Request Date</th>
                        <th>Listing ID</th>
                        <th>Property Name</th>
                        <th>Type</th>
                        <th>Requested By</th>
                        <th></th>
                        <th></th>
                      </tr>
                      <tr class="no-hover"><th class="th-border" colspan="7"></th></tr>
                      <?php
                      for ($i = 0; $request = mysqli_fetch_assoc($result); $i++) {
                          $location = "location.href='request.php?t=".$request['ticketNo']."'";
                      ?>
                        <tr ondblclick="<?php echo $location ?>" style="user-select: none;">
                          <td><?php echo date("Y-m-d",strtotime($request['requestTimestamp'])) ?></td>
                          <td><?php echo sprintf('%012d', $request['listingID']) ?></td>
                          <td><?php echo $request['propertyName'] ?></td>
                          <td><?php echo $request['requestType'] ?></td>
                          <td><?php echo $request['userName'] ?></td>
                          <td><button onclick="<?php echo $location ?>">View</button></td>
                          <td>
                            <form method="POST" action="request-result.php">
                              <input type="text" name="id" value="<?php echo "" ?>" style="display: none;">
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
                      <p>No new request is found.</p>
                    </div>
                  </div>
              <?php  
                }
              ?>
            </div>
          </div>
          <div>
            <h3>Active Listings</h3>
            <div class="dashboard-table-content">
              <?php
              include("dbconnect.php");
                $sql = "SELECT listingID, listing.propertyID, prop.propertyName, prop.rentPrice, listingTimestamp
                        FROM listing
                        LEFT JOIN (
                            SELECT *
                            FROM property
                            WHERE property.landlordRegNo = '$reg_no'
                        ) AS prop ON listing.propertyID = prop.propertyID
                        WHERE listing.propertyID = prop.propertyID";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($result);
                // $numrows = 5;
                if ($numrows > 0) {
              ?>
                  <div class="dashboard-table">
                    <table>
                      <tr class="no-hover">
                        <th>Listing ID</th>
                        <th>Property ID</th>
                        <th>Name</th>
                        <th>Rent Price</th>
                        <th>Date Listed</th>
                        <th></th>
                      </tr>
                      <tr class="no-hover"><th class="th-border" colspan="6"></th></tr>
                      <?php
                        for ($i = 0; $listing = mysqli_fetch_assoc($result); $i++) {
                          $location = "location.href='listing.php?id=".$listing['listingID']."'";
                      ?>
                        <tr ondblclick="<?php echo $location ?>" style="user-select: none;">
                          <td><?php echo sprintf('%012d', $listing['listingID']) ?></td>
                          <td><?php echo sprintf("%08d", $listing['propertyID']) ?></td>
                          <td><?php echo $listing['propertyName'] ?></td>
                          <td><?php echo $listing['rentPrice'] ?></td>
                          <td><?php echo date("Y-m-d",strtotime($listing['listingTimestamp'])) ?></td>
                          <td>
                            <button class="view-button" onclick="<?php echo $location ?>">
                              <image class="icon view-icon" src="assets/icons/eye.png"><span>View</span>
                            </button>
                          </td>
                        </tr>
                      <?php
                          // Gap between rows
                          if ($i < $numrows) {
                            echo "<tr class='spacer'><td></td></tr>";
                          }
                        }
                      ?>
                      <tr class="no-hover bottom-row">
                        <td colspan="6">
                          <a href="add-listing.php">
                          <button class="add-button">
                            <image class="icon add-icon" src="assets/icons/plus.png">
                          </button>
                          </a>
                        </td>
                        <td></td>
                      </tr>
                    </table>
                  </div> 
              <?php
                } else {
              ?>
                  <div class="dashboard-empty">
                    <div>
                      <p>No active listing is found.</p>
                      <br>
                      <a href="add-listing.php">
                        <button>Create new listing</button>
                      </a>
                    </div>
                  </div>
              <?php  
                }
              ?>
            </div>
          </div>
          <div>
            <h3>My Properties</h3>
            <div class="dashboard-table-content">
              <?php
              include("dbconnect.php");
                $sql = "SELECT *
                        FROM property
                        WHERE landlordRegNo = '$reg_no'";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($result);
                // $numrows = 5;
                if ($numrows > 0) {
              ?>
                  <div class="dashboard-table">
                    <table>
                      <tr class="no-hover">
                        <th>Property ID</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Type</th>
                        <th></th>
                      </tr>
                      <tr class="no-hover"><th class="th-border" colspan="6"></th></tr>
                      <?php
                      for ($i = 0; $property = mysqli_fetch_assoc($result); $i++) {
                          $location = "location.href='property.php?id=".$property['propertyID']."'";
                      ?>
                        <tr ondblclick="<?php echo $location ?>" style="user-select: none;">
                          <td><?php echo sprintf("%06d",$property['propertyID']) ?></td>
                          <td><?php echo $property['propertyName'] ?></td>
                          <td><?php echo $property['propertyCity'] ?></td>
                          <td><?php echo $property['propertyState'] ?></td>
                          <td><?php echo $property['propertyType'] ?></td>
                          <td>
                            <button class="view-button" onclick="<?php echo $location ?>">
                              <image class="icon view-icon" src="assets/icons/eye.png"><span>View</span>
                            </button>
                          </td>
                        </tr>
                      <?php
                          // Gap between rows
                          if ($i < $numrows) {
                            echo "<tr class='spacer'><td></td></tr>";
                          }
                        }
                      ?>
                      <tr class="no-hover bottom-row">
                        <td colspan="6">
                          <a href="add-property-form.php">
                          <button class="add-button">
                            <image class="icon add-icon" src="assets/icons/plus.png">
                          </button>
                          </a>
                        </td>
                        <td></td>
                      </tr>
                    </table>
                  </div> 
              <?php
                } else {
              ?>
                  <div class="dashboard-empty">
                    <div>
                      <p>No properties were found.</p>
                      <br>
                      <a href="add-property-form.php">
                        <button>Add new property</button>
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
?>