<?php 
  include("dbconnect.php");
  if (isset($_SESSION['userID'])) {
    session_start(); 
    $id = $_SESSION['userID'];

    $sql = "SELECT * FROM user WHERE userID = $id";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    $row = mysqli_num_rows($result);

    if ($row == 0) {
      echo "No record found";
    } else {
      $u = mysqli_fetch_assoc($result);
      $username= $u['userName'];
    
    echo file_get_contents("html/header.html");
  
?>
<!DOCTYPE html>
<html>
  <body id="dashboard">
    <h1 style="height: 70vh; padding: 8rem 16vw;">
      Successful log in! Welcome <?php echo $username; ?>. <br>
      <a href="logout.php">Logout</a>
    </h1>
  </body>
</html>
<?php
      echo file_get_contents("html/footer.html");
    }
    mysqli_close($connect);
  } else {
    echo "<script>
      alert('Please log in first!');
      window.location.replace('index.php'); </script>";
  }
?>