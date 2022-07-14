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
    <div class="upload-image-container">
      <div class="propic-container propic-upload-container">
        <image class="profile-pic" src="" onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
      </div>
    </div>
    
    <hr>
    <div>
      <div class="choose-file">
        Choose File
        <input type="file" name="fileToUpload" onchange="readImageURL(this)">
      </div>
      <div class="propic-upload-action">
        <input type="submit" value="Save Image" name="upload-image" class="save-image-button" disabled>
        <input type="button" value="Remove Profile Picture" name="remove-profile-picture" onclick="resetProfilePicture()">
      </div>
    </div>
  </form>
</div>

<?php
  include("dbconnect.php");
  $sql = "SELECT * FROM user WHERE userID = ".$_SESSION['userID']."";
  $result = mysqli_query($connect, $sql);
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
  //   $result = mysqli_query($connect, $sql);
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
            <button class="settings-button edit-button">
              <image class="icon edit-icon" src="assets/icons/write.png"><span>Edit</span>
            </button>
            <button class="settings-button cancel-button">
              <image class="icon edit-icon" src="assets/icons/cancel.png"><span>Cancel</span>
            </button>
            <button class="settings-button save-button">
              <image class="icon edit-icon" src="assets/icons/save.png"><span>Save</span>
            </button>
          </h3>
          
          <div class="profile-info">
            <div class="profile-pic-container" onclick="toggleImageForm()">
              <image class="camera-icon" src="assets/icons/camera.png">
                <h4 class="camera-icon-text">Change profile picture</h4>
              </image>
              <div class="propic-container propic-settings-container">
                <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
              </div>
            </div>
            <div>
              <form class="account-info-form" action="" method="POST" enctype="multipart/form-data">
                <input class="profile-username input-account" type="text" name="username" value="<?php echo $username ?>" required readonly>
                <input class="profile-email input-account" type="email" name="email" value="<?php echo $email ?>" required readonly>
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
            <button class="settings-button edit-button">
              <image class="icon edit-icon" src="assets/icons/write.png"><span>Edit</span>
            </button>
            <button class="settings-button cancel-button">
              <image class="icon edit-icon" src="assets/icons/cancel.png"><span>Cancel</span>
            </button>
            <button class="settings-button save-button">
              <image class="icon edit-icon" src="assets/icons/save.png"><span>Save</span>
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
              <div class="radio-gender">
                <input type="radio" id="male" name="gender" value="M" <?php if ($gender == "Male"){ echo 'checked="checked"'; } ?>>
                <label for="male"><b>Male</b></label><br>
                <input type="radio" id="female" name="gender" value="F" <?php if ($gender == "Female"){ echo 'checked="checked"'; } ?>>
                <label for="female"><b>Female</b></label>
              </div>
              <br>
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
  
  if (isset($_POST['save-account-edit']) || isset($_POST['save-profile-edit'])) {

    include("dbconnect.php");
    if (isset($_POST['save-account-edit'])) {
      if ($_POST['username'] != $username && isset($_POST['username'])) {
        $username = mysqli_real_escape_string($connect, $_POST['username']);
      }
      if ($_POST['email'] != $email && isset($_POST['email'])) {
        $email = mysqli_real_escape_string($connect, $_POST['email']);
      }
    } else {
      if ($_POST['firstname'] != $firstname) {
        $firstname = mysqli_real_escape_string($connect, $_POST['firstname']);
      }
      if ($_POST['lastname'] != $lastname) {
        $lastname = mysqli_real_escape_string($connect, $_POST['lastname']);
      }
      if ($_POST['ic'] != $ic) {
        $ic = mysqli_real_escape_string($connect, $_POST['ic']);
      }
      if ($_POST['gender'] != $gender) {
        $gender = mysqli_real_escape_string($connect, $_POST['gender']);
      }
      if ($_POST['address'] != $address) {
        $address = mysqli_real_escape_string($connect, $_POST['address']);
      }
      if ($_POST['phoneno'] != $phoneno) {
        $phoneno = mysqli_real_escape_string($connect, $_POST['phoneno']);
      }
    }

    $sql = "UPDATE user SET 
            userName = '$username',
            userEmail = '$email',
            userFName = '$firstname',
            userLName = '$lastname',
            userIC = '$ic',
            userGender = '$gender',
            userAddress = '$address',
            userPhoneNo = '$phoneno'
            WHERE user.userID = '$id'";
    $update_result = mysqli_query($connect,$sql);
    mysqli_close($connect);

    if ($update_result) {

      $_SESSION['userName'] = $username;
      $_SESSION['userEmail'] = $email;

      echo "<script>alert('Succesfully updated profile!');</script>";
    } else {
      echo "<script>alert('Something went wrong!');</script>";
    }
    echo "<script>window.location.replace('settings.php');</script>";
  }
  
?>