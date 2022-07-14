<?php 
  include("html/header.html");

  $members = array();
  $members[0] = array ("imageLink"=>"assets/images/group_members/durrani.jpg",
                      "name"=>"Durrani Afiq Bin Saidin",
                      "studentNo"=>"2020769853",
                      "ic"=>"990509145655",
                      "programCode"=>"CS110",
                      "programName"=>"Diploma in Computer Science",
                      "group"=>"A4CS1104C",
                      "email"=>"durraniafiq@gmail.com");
  $members[1] = array ("imageLink"=>"assets/images/group_members/athirah.jpg",
                       "name"=>"Nurain Athirah Binti Mohd Khir",
                       "studentNo"=>"2020815476",
                       "ic"=>"021017140636",
                       "programCode"=>"CS110",
                       "programName"=>"Diploma in Computer Science",
                       "group"=>"A4CS1104C",
                       "email"=>"nurainathirah1710@gmail.com");
  $members[2] = array ("imageLink"=>"assets/images/group_members/irdina.jpg",
                       "name"=>"Nur Irdina bt Mohd Yusman",
                       "studentNo"=>"2020482284",
                       "ic"=>"020819141038",
                       "programCode"=>"CS110",
                       "programName"=>"Diploma in Computer Science",
                       "group"=>"A4CS1104C",
                       "email"=>"irdinaaa19@gmail.com");      
  $members[3] = array ("imageLink"=>"assets/images/group_members/alysh.jpeg",
                       "name"=>"Nurrul Alysh Qhalysha binti Hamni @ Farid",
                       "studentNo"=>"2020815514",
                       "ic"=>"021016140386",
                       "programCode"=>"CS110",
                       "programName"=>"Diploma in Computer Science",
                       "group"=>"A4CS1104C",
                       "email"=>"alyshhamni@gmail.com");   
  $members[4] = array ("imageLink"=>"assets/images/group_members/zikry.jpeg",
                       "name"=>"Muhammad Zikry Bin Mohd Zakwan",
                       "studentNo"=>"2020894056",
                       "ic"=>"020912140873",
                       "programCode"=>"CS110",
                       "programName"=>"Diploma in Computer Science",
                       "group"=>"A4CS1104C",
                       "email"=>"zikryzakwan@gmail.com");   

?>
<!DOCTYPE html>
<html>
  <body id="about">
    <div class="default-container container-margin">
      <h1>About Us</h1>
      <div class="trustex-logo">
        <img src="assets/images/TrustexLogo.png">
      </div>
      <div class="about-text">
        <h2>Trustext Residence Rental is a house that may be rented for a charge and used for a specific period of time. Created to provide affordable housing by renting it to people who needs it.</h2>
      </div>
      
      <br>
      <h1>Our Team</h1>
      <div>
        <div class="member-table-content">
          <div class="member-table">
            <table>
              <tr class="no-hover">
                <th></th>
                <th>Name</th>
                <th>Student No.</th>
                <th>IC No.</th>
                <th>Program Code</th>
                <th>Program Name</th>
                <th>Group</th>
                <th>Email</th>
              </tr>
              <tr class="no-hover"><th class="th-border" colspan="8"></th></tr>
              <?php
              for ($i = 0; $i < count($members) ; $i++) {
              ?>
                <tr>
                  <td>
                    <div class="member-propic-container">
                      <img class="member-propic" src="<?php echo $members[$i]['imageLink'] ?>" alt="Member Picture">
                    </div>
                  </td>
                  <td><?php echo $members[$i]['name'] ?></td>
                  <td><?php echo $members[$i]['studentNo'] ?></td>
                  <td><?php echo $members[$i]['ic'] ?></td>
                  <td><?php echo $members[$i]['programCode'] ?></td>
                  <td><?php echo $members[$i]['programName'] ?></td>
                  <td><?php echo $members[$i]['group'] ?></td>
                  <td><?php echo $members[$i]['email'] ?></td>
                </tr>
              <?php
                  if ($i < count($members)-1) {
                    echo "<tr class='spacer'><td></td></tr>";
                  }
                }
              ?>
            </table>
          </div> 
        </div>
      </div>
      
      


    </div>
  </body>
</html>
<?php
  include("html/footer.html");
?>