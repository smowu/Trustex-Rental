<?php
  session_start();
  if (!isset($_SESSION['userID']) || $_SESSION['userType'] != 'T') {
    header("Location: dashboard.php");
  }
  $user_id = $_SESSION['userID'];
  $ticket_no = $_GET['ticket'];

  include("dbconnect.php");
  $sql = "SELECT *
          FROM request
          LEFT JOIN (
            SELECT propertyName, propertyAddress, listingID, landlord.landlordRegNo, userFName, userLName, rentPrice
            FROM property, listing, user, landlord
            WHERE listing.propertyID = property.propertyID AND landlord.landlordRegNo = property.landlordRegNo AND user.userID = landlord.userID
          ) AS list ON request.listingID = list.listingID
          WHERE ticketNo = '$ticket_no'";
  $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
  mysqli_close($connect);

  $rent = mysqli_fetch_assoc($result);

  if ($_SESSION['userID'] != $rent['userID']) {
    header("Location: dashboard.php");
  }

  include("html/header.html");
?>
<!DOCTYPE html>
<html>
  <body id="payment">
    <div class="default-container container-margin">
      <form method="POST" action="" enctype="multipart/form-data">
        <?php
          include("dbconnect.php");
          $sql = "SELECT *
                  FROM payment
                  WHERE ticketNo = '$ticket_no'";
          $payments = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
          mysqli_close($connect);

          $num_payments_made = mysqli_num_rows($payments);

          $months_left = $rent['rentDuration'] - $num_payments_made;
          $payments_left = $months_left * $rent['rentPrice'];

        ?>

        <h1>Make Payment</h1><br>
        <p>Request Ticket No.: <?php echo sprintf("%08d",$ticket_no) ?></p>
        <p>Remaining Amount To Pay: RM <?php echo sprintf("%.2f",$payments_left) ?></p><br>
        <label for="num-month">Paying for: </label>
        <input id="num-months" class="num-months" min="1" max="<?php echo $months_left ?>" name="num-tenant" value="1" type="number" required> month(s)<br>
        <?php
          $next_payment_date = new DateTime($rent['rentStartDate']);
          $num_days = $num_payments_made * 30;
          $next_payment_date->add(new DateInterval('P'.$num_days.'D'));
          $until_date = clone $next_payment_date;
          $num_days_paid = 1 * 30;
          $until_date->add(new DateInterval('P'.$num_days_paid.'D'));
        ?>
        <p id="pay-for-date">For renting from <b><?php echo $next_payment_date->format('d F Y') . "</b> until <b>~" . $until_date->format('d F Y') ?></b></p><br>

        <label for="amount-paid">Amount: </label><br>
        <b>RM <input id="amount-paid" type="text" name="amount-paid" value="<?php echo sprintf("%.2f", $rent['rentPrice']) ?>" readonly><br></b><br>

        <h2>Payment Details</h2><br>
        <label for="card-no">Card Number: </label><br>
        <input type="text" name="card-no" value="" required><br>
        <label for="card-no">Expiry Date: </label><br>
        <input type="text" name="card-exp" value="" required><br>
        <label for="card-no">CVC: </label><br>
        <input type="text" name="card-cvc" value="" required><br>

        <br>
        <input type="submit" name="confirm-payment" value="Confirm Payment" disabled>
      </form>
      <br>
      <button onclick="location.href='dashboard.php'">Cancel</button>
    </div>
  </body>
</html>
<?php
  include("html/footer.html");
  if (isset($_POST['confirm-payment'])) {

    function checkCard() {

    }

    function checkExpiryDate() {

    }

    function checkCVC() {

    }

    if (!checkCard() || !checkExpiryDate() || !checkCVC()) {
      echo "<script>alert('Invalid card details!')</script>";
      echo "<script>history.go(-1);</script>";
    }

    $payment_type = $_POST['paymentType'];
    $payment_amount = $_POST['paymentAmount'];

    include("dbconnect.php");


    $sql = "INSERT INTO payment (ticketNo, paymentType, paymentAmount)
            VALUES ('".$ticket_no."','".$payment_type."','".$payment_amount."')";
    $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
    mysqli_close($connect);

    if ($result) {
      echo "<script>alert('Transaction is completed!')</script>";
      echo "<script>window.location.replace('dashboard.php');</script>";
    } else {
      echo "<script>alert('Something went wrong!')</script>";
    }
  }
?>
<script>
  $(".num-months").bind('keyup mouseup', function () {
    var untilDate = new Date("<?php echo $until_date->format("Y-m-d")?>");
    var num_months = document.getElementById("num-months").value - 1;
    var newDate = new Date(untilDate.setDate(untilDate.getMonth() + (num_months * 30) + 1));
    day = newDate.getDate();
    month = newDate.toLocaleString('default', { month: 'long' });
    year = newDate.getFullYear();
    newDate_str = day + " " + month + " " + year; 

    document.getElementById("pay-for-date").innerHTML = 
      "For renting from <b><?php echo $next_payment_date->format('d F Y') ?></b> until <b>~" + newDate_str + "</b>";        
  });
</script>