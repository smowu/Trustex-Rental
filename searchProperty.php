<?php
  include("dbconnect.php"); 
  $query = mysqli_real_escape_string($connect,$_POST['value']); 
?>
  <div class="listing-grid">
  <?php
    $numlistperpage = 8;
    if (isset($_GET["page"])) {
      $page = $_GET["page"];
    } else {
      $page = 1;
    }
    $startfrom = ($page-1) * $numlistperpage;

    $sql = "SELECT * FROM listing, property 
            WHERE listing.propertyID = property.propertyID 
            AND ((propertyName LIKE '%".$query."%') 
            OR (propertyAddress LIKE '%".$query."%')
            OR (propertyCity LIKE '%".$query."%')
            OR (propertyPoscode LIKE '%".$query."%')
            OR (propertyState LIKE '%".$query."%')
            OR (propertyType LIKE '%".$query."%'))
            ORDER BY listing.listingID ASC
            LIMIT $startfrom, $numlistperpage";
    $result = mysqli_query($connect, $sql);
    mysqli_close($connect);

    $num_result = mysqli_num_rows($result);
    if ($num_result == 0) {
      $numlistperpage = 0;
      echo "<p>No result found!</p>";
    }
    for ($i = 0; $i < $numlistperpage; $i++) {
      if ($rows = mysqli_fetch_array($result)) {
        include("dbconnect.php"); 
        $regNo = $rows['landlordRegNo'];
        $sql = "SELECT userFName, userLName FROM user, landlord, property 
                WHERE landlord.userID = user.userID AND landlord.landlordRegNo = '$regNo'";
        $landlordResult = mysqli_query($connect, $sql);
        mysqli_close($connect);

        $landlord = mysqli_fetch_array($landlordResult);
        $list_id = $rows['listingID'];
        $prop_id = $rows['propertyID'];

        $link = "location.href='listing.php?id=".$list_id."'";

        $dir = "assets/images/properties/property-" . sprintf('%06d', $prop_id) . "";
        $file = "";
        $files = array();
        if ($f = opendir($dir)) {
          while (($file = readdir($f)) != false) {
            if ($file != '.' && $file != '..') {
              $files[] = $file;
            }
          }
          sort($files);
          $file = $files[0];
          closedir($f);
        }

        $thumb = "assets/images/properties/property-" . sprintf('%06d', $prop_id) . "/" . $file . "";
        $alt = "Property Image Banner";
        $propertyname = $rows['propertyName'];
        $propertyaddress = $rows['propertyAddress'];
        $numofrooms = $rows['propertyNumRooms'];
        $bedrooms = $rows['propertyBathrooms'];
        $floorsize = $rows['propertyFloorSize'];
        $pricepersqft = sprintf('%0.2f', $rows['rentPrice']/$rows['propertyFloorSize']);
        $rentprice = number_format(round($rows['rentPrice'],0));
        $landlordFName = $landlord['userFName'];
        $landlordLName = $landlord['userLName'];
        $display = "";
      } else {
        $link = "";
        $thumb = "";
        $alt = "";
        $propertyname = "--";
        $propertyaddress = "--";
        $numofrooms = "-";
        $bedrooms = "-";
        $floorsize = "-.--";
        $pricepersqft = "-.--";
        $rentprice = "----";
        $landlordFName = "";
        $landlordLName = "";
        $display = "opacity: 0; cursor: default;";
      }
  ?>
  <div class="list-property" onclick="<?php echo $link?>" style="<?php echo $display ?>">
    <div class="listing-property-container">
      <div class="listing-property-image-container">
        <image src="<?php echo $thumb?>" alt="<?php echo $alt?>" onerror="this.style.display='none'">
      </div>
        <div class="listing-property-info-container">
          <div>
            <h3><?php echo $propertyname?></h3><br>
            <p class="listing-property-address">
            <?php echo $propertyaddress?>
            </p><br>
            <div class="listing-property-info">
              <h4>
                <image class="icon" src="assets/icons/bed.png" alt="Bedroom icon"><?php echo $numofrooms ?></image>
                <image class="icon" src="assets/icons/bath.png" alt="Bedroom icon"><?php echo $bedrooms?></image>
              </h4>
              <p><?php echo $floorsize?> sqft</p><p>RM <?php echo $pricepersqft?> psf</p>
            </div><br>
            <h3>RM <?php echo $rentprice?>/month</h3>
        </div>
      </div>
    </div>
    <div class="listing-property-owner">
      <hr>
      <p>Listed by <b><?php echo $landlordFName . " " . $landlordLName?></b></p>
    </div>
  </div>
  <?php
    }
  ?>
</div>
<div class="listing-page-nav-container">
  <div class="listing-page-nav">
    <?php
      if ($num_result != 0) {
        include("dbconnect.php"); 
        $sql = "SELECT * FROM listing, property
                WHERE listing.propertyID = property.propertyID AND ((propertyName LIKE '%".$query."%') OR (propertyAddress LIKE '%".$query."%'))";
        $rs = mysqli_query($connect, $sql);
        mysqli_close($connect);
        $totallistings = mysqli_num_rows($rs);
        
        $numofpages = ceil($totallistings/$numlistperpage);

        for ($i = 1; $i <= $numofpages; $i++) {
          $pagelink = "location.href='index.php?page=" . $i . "#listing-container'";
          $activepage = "";
          if ($i == $page) {
            $activepage = " active-page ";
          }
          echo '<button class="page-button' . $activepage . '"onclick="' . $pagelink . '"></button>';
        }
      }
    ?>
  </div>
</div>