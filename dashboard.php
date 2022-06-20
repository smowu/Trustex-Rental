<?php 
  include("dbconnect.php");
  session_start(); 
  if (isset($_SESSION['userID'])) {
    $id = $_SESSION['userID'];

    $sql = "SELECT * FROM user WHERE userID = $id";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    $row = mysqli_num_rows($result);
    mysqli_close($connect);
    
    if ($row == 0) {
      header("Location: login.php");
    } else {
      $user = mysqli_fetch_assoc($result);
      $username= $user['userName'];
      include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="dashboard">
    <h1 style="height: 70vh; padding: 8rem 16vw;">
      Successful log in! Welcome <?php echo $username;?>. <br>
      <a href="logout.php">Logout</a>
    </h1>
  </body>
</html>
<?php
      include("html/footer.html");
    }
  } else {
    header("Location: login.php");
  }
?>