<?php
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 'L') {
    header("Location: dashboard.php");
  }
  $reg_no = $_SESSION['landlordRegNo'];
  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="list-property">
    <div class="default-container container-margin">
      <h1>New Listing</h1>
      <br>
      <div class="listing-content">
        <div class="container-max">
          <div>
            <h3>Select Your Property</h3>
            <div class="dashboard-table-content">
              <?php
              include("dbconnect.php");
                $sql = "SELECT propertyID, propertyName, propertyCity, propertyState, propertyType
                        FROM property
                        WHERE landlordRegNo = '$reg_no'";
                $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
                mysqli_close($connect);

                $numrows = mysqli_num_rows($result);
                if ($numrows > 0) {
              ?>
                  <div class="dashboard-table">
                    <table>
                      <tr class="no-hover">
                        <th>Property ID</th>
                        <th>Name</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Type</th>
                      </tr>
                      <tr class="no-hover"><th class="th-border" colspan="5"></th></tr>
                      <?php
                      for ($i = 0; $property = mysqli_fetch_assoc($result); $i++) {
                      ?>
                        <tr id="list-id-<?php echo $property['propertyID']?>" onclick="fillListing(<?php echo $property['propertyID']?>)" style="user-select: none; border-radius: 0.5rem;">
                          <td><?php echo sprintf("%06d",$property['propertyID']) ?></td>
                          <td><?php echo $property['propertyName'] ?></td>
                          <td><?php echo $property['propertyCity'] ?></td>
                          <td><?php echo $property['propertyState'] ?></td>
                          <td><?php echo $property['propertyType'] ?></td>
                        </tr>
                      <?php
                          // Gap between rows
                          if ($i < $numrows-1) {
                            echo "<tr class='spacer'><td></td></tr>";
                          }
                        }
                      ?>
                    </table>
                  </div> 
              <?php
                } else {
              ?>
                  <div class="dashboard-empty">
                    <div>
                      <p>No properties were found.</p>
                      <br>
                      <a href="add-property.php" onclick="">
                        <button>Add new property</button>
                      </a>
                    </div>
                  </div>
              <?php  
                }
              ?>
            </div>
          </div>
        </div>
      </div>
      <br>

      <div id="listing-form">
        <form id="listing-form" class="listing-form" action="" method="POST" enctype="multipart/form-data">

          <div class="image-upload-form" action="uploadImage.php" method="post" enctype="multipart/form-data">
            <image class="" src=""></image>
            <br>
            <div>
              <input type="file" name="fileToUpload" onchange="readImageURL(this)">
            </div>
          </div><br>

          <label for="name">Name</label>
          <input type="text" name="name" value="" placeholder="Property Name" required><br><br>
          <label for="address">Address</label>
          <input type="text" name="address" value="" placeholder="Property Address" required><br><br>
          <label for="city">City</label>
          <input type="text" name="city" value="" placeholder="Property City" required><br><br>
          <label for="poscode">Poscode</label>
          <input type="text" name="poscode" value="" placeholder="Property Poscode" required><br><br>

          <label for="state">State</label>
          <select name="state" id="state" required>
            <option disabled selected value> -- Select a state -- </option>
          </select><br><br>

          <label for="type">Property Type</label><br>
          <input type="radio" id="condominium" name="type" value="Condominium">
          <label for="condominium">Condominium</label><br>
          <input type="radio" id="apartment" name="type" value="Apartment">
          <label for="apartment">Apartment</label><br>
          <input type="radio" id="terrace" name="type" value="Terrace">
          <label for="terrace">Terrace</label><br>
          <input type="radio" id="bungalow" name="type" value="Bungalow">
          <label for="bungalow">Bungalow</label><br>
          <input type="radio" id="semid" name="type" value="Semi-D">
          <label for="semid">Semi-D</label><br>
          <input type="radio" id="townhouse" name="type" value="Townhouse">
          <label for="townhouse">Town House</label><br>
          <input type="radio" id="others" name="type" value="Others" required>
          <label for="others">Others</label><br><br>

          <label for="floor-level">Floor Level</label>
          <input type="text" name="floor-level" value="" placeholder="Floor Level"><br><br>
          <label for="floor-size">Floor Size</label>
          <input type="text" name="floor-size" value="" placeholder="Floor Size"><br><br>
          <label for="num-rooms">No. of Rooms</label>
          <input type="text" name="num-rooms" value="" placeholder="No. of Rooms" required><br>
          <label for="num-bathrooms">No. of Bathrooms</label>
          <input type="text" name="num-bathrooms" value="" placeholder="No. of Bathrooms" required><br><br>

          <label for="furnishing">Furnishing</label>
          <select name="furnishing" id="furnishing">
            <option disabled selected value> -- Select furnishing -- </option>
          </select><br><br>

          <label for="facilities[]">Facilities</label><br>
          <input type="checkbox" id="facilities1" name="facilities[]" value="Wifi">
          <label for="facilities1"> Wifi</label><br>
          <input type="checkbox" id="facilities2" name="facilities[]" value="Parking">
          <label for="facilities2"> Parking Lot</label><br>
          <input type="checkbox" id="facilities3" name="facilities[]" value="Gym">
          <label for="facilities3"> Gymnasium</label><br>
          <input type="checkbox" id="facilities4" name="facilities[]" value="Pool">
          <label for="facilities4"> Swimming Pool</label><br>
          <input type="checkbox" id="facilities5" name="facilities[]" value="Security">
          <label for="facilities5"> Security Guard</label><br>

          <input type="checkbox" id="other1" name="facilities[]" value="Others">
          <label for="other1"> Others</label><br><br>

          <label for="rent-price">Rent Price</label>
          RM <input type="text" name="rent-price" value="" placeholder="Renting Price"><br><br>

          <label for="description">Description</label><br>
          <textarea name="description" cols="50" rows="10" placeholder="Enter property description..."></textarea><br>
          <br>
          <input type="submit" name="listing-submit" value="Add Property">

        </form>
      </div>
      <br>

      <button onclick="location.href='dashboard-landlord.php'">Cancel</button>
    </div>
  </body>
</html>
<?php

  if (isset($_POST['listing-submit'])) {
    include("dbconnect.php");
    $sql = "INSERT INTO listing (landlordRegNo, propertyName, propertyAddress, propertyCity) 
            VALUES('".$_SESSION['landlordRegNo']."','".$_POST['name']."','".$_POST['address']."','".$_POST['city']."')";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    $prop_id = mysqli_insert_id($connect);
    mysqli_close($connect);

    if ($result) {
      $dir = "/assets/images/properties/property-" . sprintf('%06d', $prop_id) . "";

      echo "<script>alert('Successfully added property to listings!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }
  include("html/footer.html");
?>

<script>
  // Fill listing form
  function fillListing(prop) {
    $(".dashboard-table td").css("background-color", "#cccccc22");
    $(".dashboard-table tr").css("outline", "none");

    $("#list-id-"+prop+" td").css("background-color", "#c9dee777");
    $("#list-id-"+prop+"").css("outline", "3px solid #257b9f");
    if (prop == "") {
      document.getElementById("listing-form").innerHTML = "";
      return;
    }
    var xmlhttp=new XMLHttpRequest();
    xmlhttp.onreadystatechange=function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("listing-form").innerHTML = this.responseText;
      }
    }
    xmlhttp.open("GET","getProperty.php?id=" + prop, true);
    xmlhttp.send();
  }

  var sel_state = document.getElementById("state");
  var states = ["W.P. Kuala Lumpur","Johor","Kedah","Kelantan",
                "Melaka","Negeri Sembilan","Pahang","Perak",
                "Perlis","Pulau Pinang","Sabah","Sarawak",
                "Selangor","Terengganu","W.P. Labuan","W.P. Putrajaya"];

  var sel_furnishing = document.getElementById("furnishing");
  var furnish = ["Unfurnished","Partially Furnished","Fully Furnished"];
  
  var selections = Array();
  selections = [[sel_state,states],[sel_furnishing,furnish]];

  for (var i = 0; i < selections.length; i++) {
    selections[i][1].sort();
    options = selections[i][1];
    for (var j = 0; j < options.length; j++) {
      var optn = options[j];
      var el = document.createElement("option");
      el.textContent = optn;
      el.value = optn;
      selections[i][0].appendChild(el);
    }
  }
</script>