<?php
  session_start();
  if (!isset($_SESSION['userID'])) {
    header("Location: login.php");
  }
  include("html/header.html");
?>
<!-- Overlay for changing profile picture -->
<div class="image-upload-overlay">
  <form class="image-upload-form" action="uploadProfilePicture.php" method="post" enctype="multipart/form-data">
    <div>
      <h3>
        Upload Image
        <image class="icon close-icon" src="assets/icons/close.png" onclick="toggleImageForm()">
      </h3>
    </div>
    <image class="profile-pic" src="" onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
    <hr><br>
    <div>
      <input type="file" name="fileToUpload" onchange="readImageURL(this)">
      <input type="submit" value="Save Image" name="upload-image" class="save-image-button" disabled>
      <input type="button" value="Remove Profile Picture" name="remove-profile-picture" onclick="resetProfilePicture()">
    </div>
  </form>
</div>

<?php
  include("dbconnect.php");
  $sql = "SELECT * FROM user WHERE userID = ".$_SESSION['userID']."";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);
  $user = mysqli_fetch_assoc($result);

  $id = $user['userID'];
  $username = $user['userName'];
  $email = $user['userEmail'];
  $password = $user['userPassword'];
  if ($user['userType'] == 'A') {
    $usertype = "Admin";
  } else if ($user['userType'] == 'L') {
    $usertype = "Landlord";
  } else { 
    $usertype = "Tenant";
  }
  $firstname = $user['userFName'];
  $lastname = $user['userLName'];
  $ic = $user['userIC'];
  $gender = $user['userGender'];
  if (strtoupper($gender) == 'M') {
    $gender = "Male";
  } else if (strtoupper($gender) == 'F') {
    $gender = "Female";
  }
  $address = $user['userAddress'];
  $phoneno = $user['userPhoneNo'];

  $profileicon = "assets/images/users/user-".sprintf('%010d', $id)."/profile-picture/profile-picture.png";

  // For editing password
  // if (password_verify($oldpassword, $password)) {

  //   // Asks new password and confirmation

  //   include("dbconnect.php");
  //   $sql = "UPDATE user SET userPassword = $newpassword WHERE userID = $id";
  //   $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  //   mysqli_close();
  //   if ($result) {
  //     echo "<script>alert('Successfully changed password!');</script>";
  //   } else {
  //     echo "<script>alert('Something went wrong!');</script>";
  //   }
  // }
?>
<!DOCTYPE html>
<html>
  <body id="settings">
    <div class="settings-container container-margin">
      <h1>Profile settings</h1>
      <div class="settings-content">
        <div class="profile-section">
          <h3>
            Account Info
            <button class="edit-button profile-edit">
              <image class="icon edit-icon" src="assets/icons/write.png"><span>Edit</span>
            </button>
          </h3>
          
          <div class="profile-info">
            <div class="profile-pic-container" onclick="toggleImageForm()">
              <image class="camera-icon" src="assets/icons/camera.png">
                <h4 class="camera-icon-text">Change profile picture</h4>
              </image>
              <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
            </div>
            <div>
              <form class="account-info-form" action="" method="POST" enctype="multipart/form-data">
                <input class="profile-username input-account" type="text" name="username" value="<?php echo $username ?>" required readonly>
                <input class="profile-email input-account" type="text" name="email" value="<?php echo $email ?>" required readonly>
                <input class="save-account-edit" type="submit" name="save-account-edit" value="" style="display: none;">
              </form>
              <br>
              <p><?php echo $usertype ?> Account</p>
              <?php
                if ($_SESSION['userType'] == 'L') {
              ?>
              <p>Registration No.: <?php echo sprintf('%06d', $_SESSION['landlordRegNo'])?></p><br>
              <?php
                } else if ($_SESSION['userType'] == 'A') {
              ?>
              <p>Admin ID: <?php echo sprintf('%04d', $_SESSION['administratorID'])?></p><br>
              <?php
                }
              ?>
              <p>User ID: <?php echo sprintf('%010d', $user['userID'])?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="settings-content">
        <div class="personal-details">
          <h3>
            Personal Details
            <button class="edit-button personal-edit">
              <image class="icon edit-icon" src="assets/icons/write.png"><span>Edit</span>
            </button>
          </h3>
          <form class="personal-info-form" action="" method="POST" enctype="multipart/form-data">
            <div class="personal-info-firstname">
              <p>First Name</p><br>
              <input class="personal-firstname input-personal" type="text" name="firstname" value="<?php echo $firstname ?>" placeholder="N/A" readonly>
            </div>
            <div class="personal-info-lastname">
              <p>Last Name</p><br>
              <input class="personal-lastname input-personal" type="text" name="lastname" value="<?php echo $lastname ?>" placeholder="N/A" readonly>
            </div>
            <div class="personal-info-ic">
              <p>IC Number</p><br>
              <input class="personal-ic input-personal" type="text" name="ic" value="<?php echo $ic ?>" placeholder="N/A" readonly>
            </div>
            <div class="personal-info-gender">
              <p>Gender</p><br>
              <input class="personal-gender input-personal" type="text" name="gender" value="<?php echo $gender ?>" placeholder="N/A" readonly>
            </div>
            <div class="personal-info-address">
              <p>Address</p><br>
              <input class="personal-address input-personal" type="text" name="address" value="<?php echo $address ?>" placeholder="N/A" readonly>
            </div>
            <div class="personal-info-phoneno">
              <p>Phone No.</p><br>
              <input class="personal-phoneno input-personal" type="text" name="phoneno" value="<?php echo $phoneno ?>" placeholder="N/A" readonly>
            </div>
            <input class="save-profile-edit" type="submit" name="save-profile-edit" value="" style="display: none;">
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");

  if (isset($_POST['save-account-edit']) || isset($_POST['save-profile-edit'] )) {
    
    if (isset($_POST['save-account-edit'])) {
      if ($_POST['username'] != $user['userName'] && isset($_POST['username'])) {
        $username = $_POST['username'];
      }
      if ($_POST['email'] != $user['userEmail'] && isset($_POST['email'])) {
        $email = $_POST['email'];
      }
    } else {
      if ($_POST['firstname'] != $user['userFName']) {
        $firstname = $_POST['firstname'];
      }
      if ($_POST['lastname'] != $user['userLName']) {
        $lastname = $_POST['lastname'];
      }
      if ($_POST['ic'] != $user['userIC']) {
        $ic = $_POST['ic'];
      }

      if ($_POST['gender'] != $user['userGender']) {
        $gender = $_POST['gender'];
      }
      if ($_POST['address'] != $user['userAddress']) {
        $address = $_POST['address'];
      }
      if ($_POST['phoneno'] != $user['userPhoneNo']) {
        $phoneno = $_POST['phoneno'];
      }
    }
    
    include("dbconnect.php");
    $sql = "UPDATE user SET 
            userName = '$username',
            userEmail = '$email',
            userFName = '$firstname',
            userLName = '$lastname',
            userIC = '$ic',
            userGender = '$gender',
            userAddress = '$address',
            userPhoneNo = '$phoneno'
            WHERE user.userID = ".$_SESSION['userID']."";
    $update_result = mysqli_query($connect,$sql) or die ("Error: " .mysqli_error($connect));
    mysqli_close($connect);

    if (!$update_result) {
      echo "<script>alert('Something went wrong!');</script>";
    }
    echo "<script>history.go(-1);</script>";
  }
  
?>