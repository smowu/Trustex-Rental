<?php
  include("dbconnect.php");

  $sql_req = "SELECT *
              FROM request
              LEFT JOIN (
                SELECT property.propertyID, landlord.landlordRegNo, propertyName, propertyAddress, propertyCity, propertyPoscode, propertyState, propertyType,
                       propertyFloorLevel, propertyFloorSize, propertyNumRooms, propertyBathrooms, propertyFurnishing, propertyFacilities, propertyDesc,
                       listingID,  userFName, userLName, rentPrice
                FROM property, listing, user, landlord
                WHERE listing.propertyID = property.propertyID AND landlord.landlordRegNo = property.landlordRegNo AND user.userID = landlord.userID
              ) AS list ON request.listingID = list.listingID
              WHERE userID = '$id' AND requestStatus = 'Expired'";
  $result_req = mysqli_query($connect, $sql_req);

  while ($request = mysqli_fetch_assoc($result_req)) {
    $sql = "INSERT INTO history (
            ticketNo, 
            userID, 
            listingID,
            requestTimestamp,
            rentStartDate,
            rentEndDate,
            rentDuration,
            rentNumTenants,
            propertyID,
            landlordRegNo,
            propertyName,
            propertyAddress,
            propertyCity,
            propertyPoscode,
            propertyState,
            propertyType,
            propertyFloorLevel,
            propertyFloorSize,
            propertyNumRooms,
            propertyBathrooms,
            propertyFurnishing,
            propertyFacilities,
            propertyDesc,
            rentPrice
          ) VALUES (
            '".$request['ticketNo']."',
            '".$request['userID']."',
            '".$request['listingID']."',
            '".$request['requestTimestamp']."',
            '".$request['rentStartDate']."',
            '".$request['rentEndDate']."',
            '".$request['rentDuration']."',
            '".$request['rentNumTenants']."',
            '".$request['propertyID']."',
            '".$request['landlordRegNo']."',
            '".$request['propertyName']."',
            '".$request['propertyAddress']."',
            '".$request['propertyCity']."',
            '".$request['propertyPoscode']."',
            '".$request['propertyState']."',
            '".$request['propertyType']."',
            '".$request['propertyFloorLevel']."',
            '".$request['propertyFloorSize']."',
            '".$request['propertyNumRooms']."',
            '".$request['propertyBathrooms']."',
            '".$request['propertyFurnishing']."',
            '".$request['propertyFacilities']."',
            '".$request['propertyDesc']."',
            '".$request['rentPrice']."'
          )";
    $result = mysqli_query($connect, $sql);

    if (!$result) {
    echo "<script>alert('');</script>";
    } else {
      $sql_update = "UPDATE request SET 
                     requestStatus = 'Archived'
                     WHERE ticketNo = '".$request['ticketNo']."'";
      $result_update = mysqli_query($connect, $sql_update);
    }
  }
  mysqli_close($connect);
?>