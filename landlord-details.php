<?php 
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != "A") {
    header("Location: dashboard.php");
  }
  $reg_no = $_GET['id'];
  include("dbconnect.php");
  $sql = "SELECT * 
          FROM landlord, user
          WHERE landlord.userID = user.userID AND landlordRegNo = '$reg_no'";
  $result = mysqli_query($connect, $sql);
  mysqli_close($connect);
  $landlord = mysqli_fetch_assoc($result);

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="property">
    <div class="default-container container-margin">
      <?php
        $profileicon = "assets/images/users/user-".sprintf('%010d', $landlord['userID'])."/profile-picture/profile-picture.png";
      ?>
      <div class="propic-container propic-landlord-details-container">
        <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
      </div>
      <h1><?php echo $landlord['userFName'] . " " . $landlord['userLName'] ?></h1>
      <p>Landlord Registration No.: <?php echo sprintf('%06d', $landlord['landlordRegNo']) ?></p>
      
      <div class="request-details">
        <label>Username</label>
        <p><?php echo $landlord['userName'] ?></p>
      </div>
      <div class="request-details">
        <label>Email Address</label>
        <p><?php echo $landlord['userEmail'] ?></p>
      </div>
      <div class="request-details">
        <label>Name</label>
        <p><?php echo $landlord['userFName'] . " " . $landlord['userLName'] ?></p>
      </div>
      <div class="request-details">
        <label>IC Number</label>
        <p><?php echo $landlord['userIC'] ?></p>
      </div>
      <div class="request-details">
        <label>Gender</label>
        <p>
          <?php 
            if ($landlord['userGender'] == 'M') {
              echo "Male";
            } else if ($landlord['userGender'] == 'F') {
              echo "Female";
            } else {
              echo "N/A";
            }
          ?>
        </p>
      </div>
      <div class="request-details">
        <label>Address</label>
        <p><?php echo $landlord['userAddress'] ?></p>
      </div>
      <div class="request-details">
        <label>Phone No.</label>
        <p><?php echo $landlord['userPhoneNo'] ?></p>
      </div>
      <div class="landlord-property-container">
        <h3><?php echo $landlord['userName'] ?>'s Properties</h3>
        <div class="dashboard-table-content">
          <?php
          include("dbconnect.php");
            $sql = "SELECT *
                    FROM property
                    WHERE landlordRegNo = '$reg_no'";
            $result = mysqli_query($connect, $sql);
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
                      $location = "location.href='property.php?id=".$property['propertyID']."&source=details'";
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
                  <p>No properties were found.</p>
                </div>
              </div>
          <?php  
            }
          ?>
        </div>
      </div>
      <div class="landlord-property-container">
        <h3><?php echo $landlord['userName'] ?>'s Active Listings</h3>
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
            $result = mysqli_query($connect, $sql);
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
                    <th>Rent Price (RM)</th>
                    <th>Date Listed</th>
                    <th></th>
                  </tr>
                  <tr class="no-hover"><th class="th-border" colspan="6"></th></tr>
                  <?php
                    for ($i = 0; $listing = mysqli_fetch_assoc($result); $i++) {
                      $location = "location.href='listing.php?id=".$listing['listingID']."&source=details'";
                  ?>
                    <tr ondblclick="<?php echo $location ?>" style="user-select: none;">
                      <td><?php echo sprintf('%012d', $listing['listingID']) ?></td>
                      <td><?php echo sprintf("%08d", $listing['propertyID']) ?></td>
                      <td><?php echo $listing['propertyName'] ?></td>
                      <td><?php echo $listing['rentPrice'] ?>/month</td>
                      <td><?php echo date("Y-m-d",strtotime($listing['listingTimestamp'])) ?></td>
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
                  <p>No active listing is found.</p>
                </div>
              </div>
          <?php  
            }
          ?>
        </div>
      </div>
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