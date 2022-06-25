<?php
  include("html/header.html");
?>
<!-- Overlay for changing profile picture -->
<div class="image-upload-overlay">
  <form class="image-upload-form" action="uploadImage.php" method="post" enctype="multipart/form-data">
    <div>
      <h3>
        Upload Image
        <image class="icon close-icon" src="assets/icons/close.png" onclick="toggleImageForm()">
      </h3>
    </div>
    <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
    <hr><br>
    <div>
      <input type="file" name="fileToUpload" onchange="readImageURL(this)">
      <input type="submit" value="Save Image" name="upload-image" class="save-image-button" disabled>
      <input type="button" value="Remove Profile Picture" name="remove-profile-picture" onclick="removeImage()">
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
  $useremail = $user['userEmail'];
  $userpassword = $user['userPassword'];
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
  $address = $user['userAddress'];
  $phoneno = $user['userPhoneNo'];

  $profileicon = "assets/images/users/user-".sprintf('%010d', $id)."/profile-picture/profile-picture.png";

  // if (password_verify($oldpassword, $userpassword)) {

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
          <h3>Account Info</h3>
          <div class="profile-info">
            <div class="profile-pic-container" onclick="toggleImageForm('<?php echo $profileicon ?>')">
              <image class="camera-icon" src="assets/icons/camera.png">
                <h4 class="camera-icon-text">Change profile picture</h4>
              </image>
              <image class="profile-pic" src=" <?php echo $profileicon ?> " onerror="this.onerror=null; this.src='assets/images/profile-default.png'"></image>
            </div>
            <div>
              <button class="edit-button" onclick="enableEdit()">
                <image class="icon edit-icon" src="assets/icons/write.png"><span>Edit</span>
              </button>
              <h1><?php echo $username ?></h1>
              <h4><?php echo $useremail ?></h4><br>
              <p><?php echo $usertype ?> Account</p>
              <p>User ID: <?php echo sprintf('%010d', $user['userID'])?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="settings-content">
        <div class="personal-details">
          <h3>
            Personal Details
            <button class="edit-button">
              <image class="icon edit-icon" src="assets/icons/write.png"><span>Edit</span>
            </button>
          </h3>
          
          <div class="personal-info">
            <div>
              <p>First Name</p><br>
              <h4><?php echo $firstname ?></h4>
            </div>
            <div>
              <p>Last Name</p><br>
              <h4><?php echo $lastname ?></h4>
            </div>
            <div>
              <p>IC Number</p><br>
              <h4><?php echo $ic ?></h4>
            </div>
            <div>
              <p>Gender</p><br>
              <h4><?php echo $gender ?></h4>
            </div>
            <div>
              <p>Address</p><br>
              <h4><?php echo $address ?></h4>
            </div>
            <div>
              <p>Phone No.</p><br>
              <h4><?php echo $phoneno ?></h4>
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