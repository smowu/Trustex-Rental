<?php 
  // session_start(); 
  include("dbconnect.php"); 

  if (isset($connect)) {
    echo file_get_contents("html/header.html");
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
          <input class="home-button" type="button" onclick="location.href='sign-up.php'" value="Get started" />
          <input class="home-button" type="button" onclick="location.href='landlord-sign-up.php'" value="Get Trusted" />
        </h1>
      </div>
    </div>
    <!-- Property listings/menu -->
    <div id="listing-body" class="listing-body">
      <div class="listing-container container-margin">
        <div class="listing-search-bar-container">
          <input class="listing-search-bar" type="textbox" placeholder="Search location">
        </div>
        <div class="listing-grid">
          <div class="list-item" onclick="location.href='listing/property-sample.php'">
            <div class="listing-grid-image-container">
              <image src="assets/images/properties/property-sample/image-property-sample-1.jpg" alt="Property Image Banner">
            </div>
            <div class="listing-grid-info-container">
              <div>
                <h3>M Condominium @ Larkin</h3><br>
                <p>Jalan Dewata Off Susur Larkin Perdana 2, Larkin, Johor Bahru, Johor</p><br>
                <p>3 Bedroom(s)</p><p>2 Bathroom(s)</p><p>1143 sqft RM 1.31 psf</p><br>
                <h3>RM 1,500/month</h3>
              </div>
            </div>
            
            <div class="listing-grid-owner">
              <hr>
              <p>Listed by Max Yee</p>
            </div>
          </div>

          <div class="list-item" onclick="location.href='listing/property-2.php'">
            <div class="listing-grid-image-container">
              <image src="assets/images/properties/property-sample/image-property-sample-2.jpg" alt="Property Image Banner">
            </div>
            <div class="listing-grid-info-container">
              <div>
                <h3>Plaza Setia Kuantan</h3><br>
                <p>Jalan Jalan Cari Makan, Kuantan, Pahang</p><br>
                <p>4 Bedroom(s)</p><p>3 Bathroom(s)</p><p>1560 sqft RM 1.51 psf</p><br>
                <h3>RM 2,200/month</h3>
              </div>
            </div>
            
            <div class="listing-grid-owner">
              <hr>
              <p>Listed by Mohd Amiruddin</p>
            </div>
          </div>

          <div class="list-item">

          </div>
          <div class="list-item">

          </div>
          <div class="list-item">

          </div>
          <div class="list-item">

          </div>
          <div class="list-item">

          </div>
          <div class="list-item">

          </div>
        </div>
        <div class="listing-page-nav">
          
        </div>
      </div>
    </div>
    
  </body>
</html>

<?php
    echo file_get_contents("html/footer.html");
    mysqli_close($connect);
  }
?>