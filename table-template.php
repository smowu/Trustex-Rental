<div>
  <h3>Title</h3>
  <div class="dashboard-table-content">
    <?php
    include("dbconnect.php");
      $sql = "";
      // $result = mysqli_query($connect, $sql) or die ("Error: ".mysqli_error());
      mysqli_close($connect);

      // $numrows = mysqli_num_rows($result);
      $numrows = 24;
      // $numrows = 0;
      if ($numrows > 0) {
    ?>
        <div class="dashboard-table">
          <table>
            <tr class="no-hover">
              <th>Column</th>
              <th>Column</th>
              <th>Column</th>
              <th>Column</th>
              <th>Column</th>
              <th>Column</th>
              <th>Column</th>
            </tr>
            <tr class="no-hover"><th class="th-border" colspan="7"></th></tr>
            <?php
            // for ($i = 0; $x = mysqli_fetch_assoc($result); $i++) {
               for ($i = 0; $i < $numrows; $i++) {
                // $location = "location.href='xxxxx.php?id=".$x['xxx']."'";
                $location = "";
            ?>
              <tr onclick="location.href='xxxxx.php'">
                <td>text</td>
                <td>text</td>
                <td>text</td>
                <td>text</td>
                <td>text</td>
                <td>text</td>
                <td>text</td>
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
            <p>Text</p>
            <br>
            <a href="xxxxx.php" onclick="">
              <button>Text</button>
            </a>
          </div>
        </div>
    <?php  
      }
    ?>
  </div>
</div>