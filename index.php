<?php
  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="home">
    <!-- Button for going back to the top of the page -->
    <div id="backToTop" onclick="backToTop()">
      <div><i class="backToTop-button arrow up"></i></div>
    </div>
    <!-- Homepage splashscreen -->
    <div class="home-header">
      <img src="assets/images/Frontpage-image.png" alt="Homepage image">
      <div class="home-content container-margin">
        <h1>
          One click closer to your next home.<br>
          <input class="home-button" type="button" onclick="location.href='sign-up.php'" value="Get started"/>
          <input class="home-button" type="button" onclick="location.href='landlord-sign-up.php'" value="Get Trusted"/>
        </h1>
      </div>
    </div>
    <!-- Property listings/menu -->
    <div id="listing-body" class="listing-body">
      <div id="listing-container" class="listing-container container-margin">
        <div class="listing-search-bar-container">
          <input id="listing-search-bar" class="listing-search-bar" type="textbox" placeholder="Search location">
            <image class="listing-search-bar-icon icon" src="assets/icons/find.png" onclick="focusSearch(0)">
          </input>
        </div>
        <div class="listing-grid">
          <?php
            $numlistperpage = 8;

            if (isset($_GET["page"])) {
              $page = $_GET["page"];
            } else {
              $page = 1;
            }
            $startfrom = ($page-1) * $numlistperpage;

            include("dbconnect.php"); 
            $sql = "SELECT * FROM listing, property WHERE listing.propertyID = property.propertyID LIMIT $startfrom, $numlistperpage";
            $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
            mysqli_close($connect);

            for ($i = 0; $i < $numlistperpage || $rows = mysqli_fetch_array($result); $i++) {

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

              if ($rows = mysqli_fetch_array($result)) {
                include("dbconnect.php"); 
                $regNo = $rows['landlordRegNo'];
                $sql = "SELECT userFName, userLName FROM user, landlord, property 
                        WHERE landlord.userID = user.userID AND landlord.landlordRegNo = '$regNo'";
                $landlordResult = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $landlord = mysqli_fetch_array($landlordResult);
                $id = $rows['propertyID'];

                $link = "location.href='listing/property-" . sprintf('%06d', $id) . ".php'";
                $thumb = "assets/images/properties/property-" . sprintf('%06d', $id) . "/image-property-1.jpg";
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
              }
          ?>
          <div class="list-property" onclick="<?php echo $link?>">
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
              include("dbconnect.php"); 
              $sql = "SELECT * FROM listing";
              $rs = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
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
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</html>

<?php
  include("html/footer.html");
?>