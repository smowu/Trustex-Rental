<?php 
  // session_start(); 
  include("dbconnect.php"); 
  if (isset($connect)) {
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
          <input class="home-button" type="button" onclick="location.href='sign-up.php'" value="Get started" />
          <input class="home-button" type="button" onclick="location.href='landlord-sign-up.php'" value="Get Trusted" />
        </h1>
      </div>
    </div>
    <!-- Property listings/menu -->
    <div id="listing-body" class="listing-body">
      <div class="listing-container container-margin">
        <div class="listing-search-bar-container">
          <input id="listing-search-bar" class="listing-search-bar" type="textbox" placeholder="Search location">
            <image class="listing-search-bar-icon icon" src="assets/icons/find.png" onclick="focusSearch(0)">
          </input>
        </div>
        <div class="listing-grid">

          <?php
            for ($i = 0; $i < 8; $i++) {
              echo '
                <div class="list-property" onclick="location.href=""listing/property-sample.php""">
                  <div class="listing-property-container">
                    <div class="listing-property-image-container">
                      <image src="assets/images/properties/property-sample/image-property-sample-1.jpg" alt="Property Image Banner">
                    </div>
                      <div class="listing-property-info-container">
                        <div>
                          <h3>M Condominium @ Larkin Johor Bharu Johor</h3><br>
                          <p class="listing-property-address">
                            Jalan Dewata Off Susur Larkin Perdana 2, Larkin, Johor Bahru, Johor
                          </p><br>
                          <div class="listing-property-info">
                            <h4>
                              <image class="icon" src="assets/icons/bed.png" alt="Bedroom icon">3</image>
                              <image class="icon" src="assets/icons/bath.png" alt="Bedroom icon">2</image>
                            </h4><br>
                            <p>1143 sqft RM</p><p>1.31 psf</p>
                          </div><br>
                          <h3>RM 1,500/month</h3>
                      </div>
                    </div>
                  </div>
                  <div class="listing-property-owner">
                    <hr>
                    <p>Listed by <b>Max Yee</b></p>
                  </div>
                </div>
              ';
            }
          ?>

          <!-- 
          <div class="list-property" onclick="location.href='listing/property-sample.php'">
            <div class="listing-property-container">
              <div class="listing-property-image-container">
                <image src="assets/images/properties/property-sample/image-property-sample-1.jpg" alt="Property Image Banner">
              </div>
                <div class="listing-property-info-container">
                  <div>
                    <h3>M Condominium @ Larkin</h3><br>
                    <p class="listing-property-address">
                      Jalan Dewata Off Susur Larkin Perdana 2, Larkin, Johor Bahru, Johor
                    </p><br>
                    <div class="listing-property-info">
                      <p>3 Bedroom(s)</p>
                      <p>2 Bathroom(s)</p>
                      <p>1143 sqft RM 1.31 psf</p>
                    </div><br>
                    <h3>RM 1,500/month</h3>
                </div>
              </div>
            </div>
            <div class="listing-property-owner">
              <hr>
              <p>Listed by Max Yee</p>
            </div>
          </div>
          
          <div class="list-property" onclick="location.href='listing/property-sample.php'">
            <div class="listing-property-container">
              <div class="listing-property-image-container">
                <image src="assets/images/properties/property-sample/image-property-sample-2.jpg" alt="Property Image Banner">
              </div>
              <div class="listing-property-info-container">
                <div>
                  <h3>Plaza Setia Kuantan</h3><br>
                  <p class="listing-property-address">
                    Jalan Jalan Cari Makan, Kuantan, Pahang
                  </p><br>
                  <div class="listing-property-info">
                    <p>4 Bedroom(s)</p>
                    <p>3 Bathroom(s)</p>
                    <p>1560 sqft RM 1.51 psf</p>
                  </div><br>
                  <h3>RM 2,200/month</h3>
                </div>
              </div>
            </div>
            <div class="listing-property-owner">
              <hr>
              <p>Listed by Mohd Amiruddin</p>
            </div>
          </div>

          <div class="list-property" onclick="location.href='listing/property-sample.php'">
            <div class="listing-property-container">
              <div class="listing-property-image-container">
                <image src="assets/images/properties/property-sample/image-property-sample-3.jpg" alt="Property Image Banner">
              </div>
              <div class="listing-property-info-container">
                <div>
                  <h3>Desa Mentari PJS 2</h3><br>
                  <p class="listing-property-address">
                    Desa Mentari PJS 2, Petaling Jaya, Selangor
                  </p><br>
                  <div class="listing-property-info">
                    <p>3 Bedroom(s)</p>
                    <p>2 Bathroom(s)</p>
                    <p>650 sqft RM 3.08 psf</p>
                  </div><br>
                  <h3>RM 2,000/month</h3>
                </div>
              </div>
            </div>
            <div class="listing-property-owner">
              <hr>
              <p>Listed by Nichole Khor</p>
            </div>
          </div>
          -->
        </div>
        <div class="listing-page-nav-container">
          <div class="listing-page-nav">
            <button class="page-button active-page"></button>
            <button class="page-button"></button>
            <button class="page-button"></button>
          </div>
        </div>
      </div>
    </div>
    
  </body>
</html>

<?php
    include("html/footer.html");
    mysqli_close($connect);
  }
?>