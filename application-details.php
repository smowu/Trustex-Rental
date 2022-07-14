<?php
  session_start();
  if ($_SESSION['userType'] == 'A') {

    include("html/header.html");
    include("dbconnect.php");
    $sql_app = "SELECT * FROM applications WHERE applicationID = '".$_GET['id']."'";
    $result_app = mysqli_query($connect, $sql_app);
    $applicant = mysqli_fetch_assoc($result_app);

    $sql_user = "SELECT userName, userEmail FROM user WHERE userID = '".$applicant["userID"]."'";
    $result_user = mysqli_query($connect, $sql_user);
    mysqli_close($connect);
    $applicant_user = mysqli_fetch_assoc($result_user);

    $applicantid = $applicant["applicationID"];
    $userid = $applicant["userID"];
    $username = $applicant_user["userName"];
    $email = $applicant_user["userEmail"];
    $firstname = $applicant["userFName"];
    $lastname = $applicant["userLName"];
    $ic = $applicant["userIC"];
    $gender = $applicant["userGender"];
    if ($gender == "M") {
      $gender = "Male";
    } else if ($gender == "F") {
      $gender = "Female";
    } else {
      $gender = "N/A";
    }
    $address = $applicant["userAddress"];
    $phoneno = $applicant["userPhoneNo"];
    $status = $applicant["applicationStatus"];
?>
<!DOCTYPE html>
<html>
  <body id="application-form">
    <div class="default-container container-margin">
      <h1>Landlord Application Details</h1><br>
      <p>Application ID: <?php echo sprintf('%06d', $applicantid) ?></p>
      <p>Application Timestamp: <?php echo $applicant['applicationTimestamp'] ?></p><br>

      <div class="max-container application-details-container">
        <h2>Applicant Details</h2>
        <p>User ID: <?php echo sprintf('%010d', $userid) ?></p><br><br>
        <?php
          $profileicon = "assets/images/users/user-".sprintf('%010d', $applicant['userID'])."/profile-picture/profile-picture.png";
        ?>
        <div class="propic-container propic-applicant-details-container">
          <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
        </div><br>

        <div class="application-details">
          <label>Username</label><br><br>
          <p><?php echo $username ?></p>
        </div>
        <div class="application-details">
          <label>Email</label><br><br>
          <p><?php echo $email ?></p>
        </div>
        <div class="application-details">
          <label>First Name</label><br><br>
          <p><?php echo $firstname ?></p>
        </div>
        <div class="application-details">
          <label>Last Name</label><br><br>
          <p><?php echo $lastname ?></p>
        </div>
        <div class="application-details">
          <label>IC Number</label><br><br>
          <p><?php echo $ic ?></p>
        </div>
        <div class="application-details">
          <label>Gender</label><br><br>
          <p><?php echo $gender ?></p>
        </div>
        <div class="application-details">
          <label>Address</label><br><br>
          <p><?php echo $address ?></p>
        </div>
        <div class="application-details">
          <label>Phone No.</label><br><br>
          <p><?php echo $phoneno ?></p>
        </div>
        <div class="application-details">
          <label>Application Status</label><br><br>
          <p><?php echo $status ?></p>
        </div>
        <br>
        <form method="POST" action="application-result.php">
          <input type="text" name="id" value="<?php echo $applicantid ?>" style="display: none;">
          <input class="application-form-button approve-button" type="submit" name="approve" value="Approve">
          <input class="application-form-button reject-button" type="submit" name="reject" value="Reject">
        </form>
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
  } else {
    header("Location: dashboard.php");
  }
?>