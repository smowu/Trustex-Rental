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
  $result = mysqli_query($connect, $sql);
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
          $payments = mysqli_query($connect, $sql);
          mysqli_close($connect);

          $num_payments_made = 0;
          while ($payment = mysqli_fetch_array($payments)) {
            $num_payments_made += $payment['paymentDuration'];
          }

          $months_left = $rent['rentDuration'] - $num_payments_made;
          $payments_left = $months_left * $rent['rentPrice'];

        ?>
        <h1>Make Payment</h1><br>
        <p>Request Ticket No.: <?php echo sprintf("%08d",$ticket_no) ?></p><br>

        <div class="payment-details">
          <p>Rent Price</p>
          <h2>RM <?php echo $rent['rentPrice'] ?>/month</h2></p><br>
          <p>Remaining Amount To Pay</p>
          <h2>RM <?php echo sprintf("%.2f",$payments_left) . " (" . $months_left . " month(s))" ?></h2>
        </div>
        <div class="payment-details">
          <h2>Payment Details</h2><br>
          <label for="num-month">Paying for: </label>
          <div class="num-input-container">
            <input type="button" onclick="dec('num-months',1)" value=" - ">
            <input id="num-months" class="num-input-box num-months" name="num-months" type="text" readonly required value="1">
            <input type="button" onclick="inc('num-months',<?php echo $months_left ?>)" value=" + ">
            month(s)
          </div><br>
          <?php
            $next_payment_date = new DateTime($rent['rentStartDate']);
            $num_days = $num_payments_made * 30;
            $next_payment_date->add(new DateInterval('P'.$num_days.'D'));
            $until_date = clone $next_payment_date;
            $num_days_paid = 1 * 30;
            $until_date->add(new DateInterval('P'.$num_days_paid.'D'));
          ?>
          <div id="pay-for-date">For renting from <b><?php echo $next_payment_date->format('d F Y') . "</b> until <b>~" . $until_date->format('d F Y') ?></b></div>
        </div>
        <div class="payment-details">
          <label for="amount-paid">Total Amount</label><br>
          <input id="amount-paid" type="text" name="amount-paid" value="<?php echo sprintf("%.2f", $rent['rentPrice']) ?>" readonly style="display: none;">
          <h2 id="total-amount" style="font-size: 2rem;">RM <?php echo sprintf("%.2f", $rent['rentPrice']) ?></h2>
        </div>
        <div class="payment-details">
          <h2>Credit Card Details</h2><br>
          <label for="card-no">Card Number (16-digits)</label><br>
          <input type="text" name="card-no" value="" maxlength="16" required><br><br>
          <label for="card-exp">Expiry Date (MM/YY)</label><br>
          <input type="text" name="card-exp" value="" maxlength="5" required><br><br>
          <label for="card-cvc">CVC (3-digits)</label><br>
          <input type="password" name="card-cvc" value="" maxlength="3" required>
        </div>

        <br>
        <input class="make-payment-button" id="confirm-payment" type="submit" name="confirm-payment" value="Confirm Payment">
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
  if (isset($_POST['confirm-payment'])) {

    $cardNo = $_POST['card-no'];
    $expDate = $_POST['card-exp'];
    $cvc = $_POST['card-cvc'];

    function checkCard($cardNo) {
      if (!is_numeric($cardNo) || strlen($cardNo) != 16) {
        return false;
      } else { 
        return true;
      }
      
    }

    function checkExpiryDate($expDate) {
      $current = new DateTime('now');
      $valid = false;
      $format_len = (strlen($expDate) == 5 && strpos($expDate, "/") == 2);
      $cardMonth = 0; $cardYear = 0;
      $currentMonth = date_format($current,"n");
      $currentYear = substr(date_format($current,"Y"),2,4);
      $cardMonth = (int)substr($expDate,0,2);
      $cardYear = (int)substr($expDate,3,5);
      $format = ($cardMonth > 0 && $cardMonth < 13 && $format_len);
      
      if ($currentYear <= $cardYear && $format) {
        if ($currentYear == $cardYear && $currentMonth >= $cardMonth) {
          $valid = false;
        } else { 
          $valid = true;
        }
      } 
      return $valid;
    }

    function checkCVC($cvc) {
      if (!is_numeric($cvc) || strlen($cvc) != 3) {
        return false;
      } else { 
        return true;
      }
    }

    if (!checkCard($cardNo) || !checkExpiryDate($expDate) || !checkCVC($cvc)) {
      if (!checkCard($cardNo)) {
        echo "<script>alert('Invalid card number!')</script>";
      }
      if (!checkExpiryDate($expDate)) {
        echo "<script>alert('Your card has expired or Invalid expiry date!')</script>";
      }
      if (!checkCVC($cvc)) {
        echo "<script>alert('Invalid CVC number!')</script>";
      }
      echo "<script>window.location.replace('payment.php?ticket=".$ticket_no."');</script>";
    } else {
      $rent_price = $rent['rentPrice'];
      $payment_duration = $_POST['num-months'];
      $payment_amount = $_POST['amount-paid'];

      include("dbconnect.php");

      $sql = "INSERT INTO payment (ticketNo, rentPrice, paymentDuration, paymentAmount)
              VALUES ('".$ticket_no."','".$rent_price."','".$payment_duration."','".$payment_amount."')";
      $result = mysqli_query($connect, $sql);
      $transac_id = mysqli_insert_id($connect);
      mysqli_close($connect);

      if ($result) {
        echo "<script>alert('Transaction is completed!\\n\\nTransaction ID: ".sprintf("%012d",$transac_id)."')</script>";
        echo "<script>window.location.replace('dashboard.php');</script>";
      } else {
        echo "<script>alert('Something went wrong!')</script>";
      }
    }
  }
?>
<script>
  $('.num-months').change( function () {
    var untilDate = new Date("<?php echo $until_date->format("Y-m-d")?>");
    var num_months = document.getElementById("num-months").value;
    var newDate = new Date(untilDate.setDate(untilDate.getMonth() + untilDate.getDate() + ((num_months - 1) * 30)));
    day = newDate.getDate();
    month = newDate.toLocaleString('default', { month: 'long' });
    year = newDate.getFullYear();
    newDate_str = ('0' + day).slice(-2) + " " + month + " " + year; 

    document.getElementById("pay-for-date").innerHTML = 
      "For renting from <b><?php echo $next_payment_date->format('d F Y') ?></b> until <b>~" + newDate_str + "</b>";    
    
    var new_val = (<?php echo sprintf("%.2f", $rent['rentPrice']) ?> * num_months).toFixed(2);
    document.getElementById("amount-paid").value = new_val;
    document.getElementById("total-amount").innerHTML = "RM " + new_val;
  });
</script>