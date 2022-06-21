<?php
  session_start();
  if (isset($_SESSION['userID']) && $_SESSION['userType'] == 'A') {
    $id = $_SESSION['userID'];
    include("dbconnect.php");
    $sql = "SELECT * FROM user WHERE userID = $id";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    mysqli_close($connect);

    $user = mysqli_fetch_assoc($result);
    $username= $user['userName'];
    include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="dashboard">
    <h1 style="height: 70vh; padding: 8rem 16vw;">
      Successful log in to admin page! Welcome <?php echo $username;?>.<br>
      User ID: <?php echo sprintf('%010d', $id)?><br>
      <a href="logout.php">Logout</a>
    </h1>
  </body>
</html>
<?php
    include("html/footer.html");
  } else {
    header("Location: dashboard.php");
  }
?>