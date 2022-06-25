<?php
  session_start();
  $target_dir = "assets/images/users/user-".sprintf('%010d', $_SESSION['userID'])."/profile-picture/";
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // if (isset($_POST["remove-profile-picture"])) {
  //   echo "<script>alert('Image is removed');</script>";
  // }

  // Check if file already exists
  // if (file_exists($target_file)) {
  //   echo "Sorry, file already exists.";
  //   $uploadOk = 0;
  // }

  if (empty($_FILES["fileToUpload"]["tmp_name"])) {
    echo "<script>alert('Image is removed');</script>";
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
      && $imageFileType != "gif" ) {
      echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "<script>alert('Sorry, your file was not uploaded.');</script>";
    // if everything is ok, try to upload file
    } else {
      // $temp = explode(".", $_FILES["fileToUpload"]["name"]);
      // $newfilename = "profile-picture." . end($temp);
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . "profile-picture.png")) {
        echo "<script>alert('The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.');</script>";
        echo "<script> window.location.replace('settings.php');</script>";
       
      } else {
        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
      }
    }
  }

  echo "<script>history.go(-1);</script>";
?>