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
                      <a href="add-property-form.php" onclick="">
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
      <form method="POST" action="" enctype="multipart/form-data">
        <div id="listing-form">
          <p>Select your property to be listed.</p><br>
        </div>
      </form>
      <br>
      <a class="return-dashboard" href="dashboard.php">
        <img src="assets/icons/back-button.png"></img>
        <h4>Cancel</h4>
      </a>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
  if (isset($_POST['listing-submit'])) {
    include("dbconnect.php");
    $sql = "INSERT INTO listing (propertyID)
            VALUES ('".$_POST['propertyID']."')";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    mysqli_close($connect);

    if ($result) {
      echo "<script>alert('Your property has been successfully listed!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }
?>
<script>
  // Fill listing form
  function fillListing(prop) {
    $(".dashboard-table td").css("background-color", "#cccccc22");
    $(".dashboard-table tr").css("outline", "none");

    $("#list-id-" + prop + " td").css("background-color", "#c9dee777");
    $("#list-id-" + prop + "").css("outline", "3px solid #257b9f");
    if (prop == "") {
      document.getElementById("listing-form").innerHTML = "";
      return;
    }
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
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