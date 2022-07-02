<?php
  session_start();
  if ($_SESSION['userType'] == 'A') {

    include("html/header.html");
    include("dbconnect.php");
    $sql_app = "SELECT * FROM applications WHERE applicationID = '".$_GET['id']."'";
    $result_app = mysqli_query($connect, $sql_app) or die ("Error: ".mysqli_error($connect));
    $applicant = mysqli_fetch_assoc($result_app);

    $sql_user = "SELECT userName, userEmail FROM user WHERE userID = '".$applicant["userID"]."'";
    $result_user = mysqli_query($connect, $sql_user) or die ("Error: ".mysqli_error($connect));
    mysqli_close($connect);
    $applicant_user = mysqli_fetch_assoc($result_user);

    $applicantid = $applicant["applicationID"];
    $userid = $applicant["userID"];
    $username = $applicant_user["userName"];
    $email = $applicant_user["userEmail"];
    $firstname = $applicant["userFName"];
    $lastname = $applicant["userLName"];
    $ic = $applicant["userIC"];
    $address = $applicant["userAddress"];
    $phoneno = $applicant["userPhoneNo"];
    $status = $applicant["applicationStatus"];
?>
<!DOCTYPE html>
<html>
  <body id="application-form">
    <div class="default-container container-margin">
      <h1>Landlord Application Details</h1><br>
      <p>Application ID: <?php echo sprintf('%06d', $applicantid) ?></p><br>

      <p>User ID: <?php echo sprintf('%010d', $userid) ?></p>
      <p>Username: <?php echo $username ?></p>
      <p>Email: <?php echo $email ?></p>
      <p>First Name: <?php echo $firstname ?></p>
      <p>Last Name: <?php echo $lastname ?></p>
      <p>IC Number: <?php echo $ic ?></p>
      <p>Address: <?php echo $address ?></p>
      <p>Phone No.: <?php echo $phoneno ?></p>
      <p>Application Status: <?php echo $status ?></p>
      <br>
      <form method="POST" action="application-result.php">
        <input type="text" name="id" value="<?php echo $applicantid ?>" style="display: none;">
        <input type="submit" name="approve" value="Approve">
        <input type="submit" name="reject" value="Reject">
      </form><br>
      <a href="dashboard.php">
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