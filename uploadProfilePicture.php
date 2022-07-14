<link rel="stylesheet" href="./styles/style.css" type="text/css">
<?php
  session_start();
  $target_dir = "assets/images/users/user-".sprintf('%010d', $_SESSION['userID'])."/profile-picture/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (empty($_FILES["fileToUpload"]["tmp_name"])) {
    $filepath = $target_dir . "profile-picture.png";
    if (file_exists($filepath)) {
      unlink($filepath);
      echo "<script>alert('Successfully removed profile picture!');</script>";
    }
    echo "<script> window.location.replace('settings.php');</script>";
  } else {
    // Check if image file is a actual image or fake image
    if(isset($_POST["upload-submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check != false) {
        echo "<script>'File is an image - " . $check["mime"] . ".');</script>";
        $uploadOk = 1;
      } else {
        echo "<script>alert('File is not an image');</script>";
        $uploadOk = 0;
      }
    }
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 20000000) {
      echo "<script>alert('Image file must be <20 MB');</script>";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
      && $imageFileType != "gif" && $imageFileType != "webp") {
      echo "<script>alert('Sorry, only .jpg, .jpeg, .png, .gif & .webp files are allowed.');</script>";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "<script>alert('Sorry, your file was not uploaded.');</script>";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . "profile-picture.png")) {
        echo "<script>alert('Successfully changed profile picture!');</script>";
      } else {
        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
      }
    }
    echo "<script> window.location.replace('settings.php');</script>";
  }
?>
<script src="scripts/script.js"></script>