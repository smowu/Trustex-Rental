<link rel="stylesheet" href="./styles/style.css" type="text/css">
<?php
  $target_dir = "assets/images/properties/property-" . sprintf('%06d', $prop_id) . "/";
  $target_file = $target_dir . basename($imageName);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  if (empty($tmpName)) {
    $filepath = $target_dir . "profile-picture.png";
    if (file_exists($filepath)) {
      unlink($filepath);
    }
  } else {
    // Check if image file is a actual image or fake image
    if(isset($_POST["property-submit"])) {
      $check = getimagesize($tmpName);
      if($check != false) {
        echo "<script>'File is an image - " . $check["mime"] . ".');</script>";
        $uploadOk = 1;
      } else {
        echo "<script>alert('File is not an image');</script>";
        $uploadOk = 0;
      }
    }
    // Check file size
    if ($_FILES["propertyImage"]["size"][$i] > 20000000) {
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
      // $newname = $imageName . "_" . uniqid();
      if (!move_uploaded_file($tmpName, $target_dir . "property-image-" . $i . ".png")) {
        echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
      }
    }
  }
?>
<script src="scripts/script.js"></script>