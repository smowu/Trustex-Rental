<?php
  if (isset($_POST['property-submit'])) {
    $checkbox = $_POST['facilities'];  
    $facilities = "";  
    foreach ($checkbox as $faci) {  
      $facilities .= $faci.",";  
    }

    include("dbconnect.php");
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $address = mysqli_real_escape_string($connect, $_POST['address']);
    $city = mysqli_real_escape_string($connect, $_POST['city']);
    $poscode = mysqli_real_escape_string($connect, $_POST['poscode']);
    $state = mysqli_real_escape_string($connect, $_POST['state']);
    $type = mysqli_real_escape_string($connect, $_POST['type']);
    $floor_level = mysqli_real_escape_string($connect, $_POST['floor-level']);
    $floor_size = mysqli_real_escape_string($connect, $_POST['floor-size']);
    $num_rooms = mysqli_real_escape_string($connect, $_POST['num-rooms']);
    $num_bathrooms = mysqli_real_escape_string($connect, $_POST['num-bathrooms']);
    $furnishing = mysqli_real_escape_string($connect, $_POST['furnishing']);
    $facilities = mysqli_real_escape_string($connect, $facilities);
    $desc = mysqli_real_escape_string($connect, $_POST['description']);
    $price = mysqli_real_escape_string($connect, $_POST['rent-price']);
    $sql = "INSERT INTO property (landlordRegNo, propertyName, propertyAddress, propertyCity, propertyPoscode, propertyState, 
                                  propertyType, propertyFloorLevel, propertyFloorSize, propertyNumRooms, propertyBathrooms,
                                  propertyFurnishing, propertyFacilities, propertyDesc, rentPrice) 
            VALUES('".$_SESSION['landlordRegNo']."','".$name."','".$address."','".$city."','".$poscode."','".$state."',
                  '".$type."','".$floor_level."','".$floor_size."','".$num_rooms."','".$num_bathrooms."',
                  '".$furnishing."','".$facilities."','".$desc."','".$price."')";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    $prop_id = mysqli_insert_id($connect);
    mysqli_close($connect);

    if ($result) {
      $dir = "../assets/images/properties/property-" . sprintf('%06d', $prop_id) . "/";
      $mkdir_success = mkdir(__DIR__ . $dir, 0777, true);
        
      if ($mkdir_success && isset($_FILES["propertyImage"]["name"])) {
        $totalFiles = count($_FILES["propertyImage"]["name"]);
        echo "<script>alert('Total files: " . $totalFiles . "');</script>";
        for ($i = 0; $i < $totalFiles; $i++) {
          $imageName = $_FILES["propertyImage"]["name"][$i];
          $tmpName = $_FILES["propertyImage"]["tmp_name"][$i];
          include("uploadPropertyImage.php");
        }
      } else if (!$mkdir_success || count($_FILES["propertyImage"]["name"]) > 0) {
        echo "<script>alert('Something went wrong while uploading property images!')</script>";
      }

      echo "<script>alert('Successfully added new property!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }
?>