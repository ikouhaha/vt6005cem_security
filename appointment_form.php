<html>

<head>
  <title>Appointment Form</title>
  <!-- CSS only -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>

<body>

  <?php
  // Create connection
  $conn = new mysqli("localhost", "root", "", "cw2");

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

//--------------------------checking session start--------------------------
session_start();

if (!isset($_SESSION['sessionId'])) {
    echo "Please Login first <br/>";
    echo "<a href='login_form.php'>Click Here to Login</a> or <a href='register_form.php'>Click Here to Register</a>";
    return;
}

$search_sql = $conn->prepare("SELECT a.user_id,a.start,a.expire,b.email FROM sys_session a inner join sys_user b on a.user_id = b.id where a.id = ?");
$search_sql->bind_param("s", $_SESSION['sessionId']);
$search_sql->execute();
$search_sql->store_result();
$now = time();
if ($search_sql->num_rows > 0) {
    $search_sql->bind_result($uid, $start, $expire, $email);
    $search_sql->fetch();
    
    if ($now > $expire) {
        echo "Your session has expired! <a href='login_form.php'>Login here</a>";
        return;
    } 
} else {
    echo "Please Login first <br/>";
    echo "<a href='login_form.php'>Click Here to Login</a> or <a href='register_form.php'>Click Here to Register</a>";
    return;
}
//--------------------------checking session end--------------------------


  ?>

  <h2><a href="index.php">Home</a></h2>
  <form action="appointment_result.php" method="post">
    <h2>Appointment *required</h2>
    <div class="form-group">
      Appointment Type*: <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" id="apply" value="apply" checked required onchange="showhkid()">
        <label class="form-check-label" for="apply">apply the HKID card</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" id="change" value="change" onchange="showhkid()">
        <label class="form-check-label" for="change">change new HKID card</label>
      </div>
    </div>
    <div id="passportarea" class="form-group">
    Certificate Type*:
      <select name="cardtype" id="cardtype" required>
        <?php

        $sql = "SELECT value,display FROM sys_lookup_value where type = 'cardtype'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            echo sprintf("<option id=\"%s\" value=" . $row["value"] . ">" . $row["display"] . "</option>","card".$row["value"]);
          }
        } else {
          echo "0 results";
        }
        ?>
      </select>
      Certificate Number*: <input name="cardno" id="cardno" type="text" size="30" maxlength="100" placeholder="" required>
    </div>

    <div class="form-group">
      Appointment Date*:
      <?php
      echo  sprintf("<input type=\"date\" id=\"start\" name=\"date\" min=\"%s\" max=\"%s\" list=\"date-list\" step=\"4\" required>", date("Y-m-d"), date("Y-m-d", strtotime("+2 month")));
      ?>

    </div>
    <div class="form-group">
      Appointment Time*:
      <select name="time" id="time">
        <?php

        $sql = "SELECT value,display FROM sys_lookup_value where type = 'time'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            echo "<option value=" . $row["value"] . ">" . $row["display"] . "</option>";
          }
        } else {
          echo "0 results";
        }
        ?>
      </select>
    </div>
    <div class="form-group">
      venues*:
      <select name="venue" id="venue">
        <?php

        $sql = "SELECT value,display FROM sys_lookup_value where type = 'venues'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
          // output data of each row
          while ($row = $result->fetch_assoc()) {
            echo "<option value=" . $row["value"] . ">" . $row["display"] . "</option>";
          }
        } else {
          echo "0 results";
        }
        ?>

      </select>
    </div>
    <div class="form-group">
      <p> <b>Please enter a custom 4-digit query code. You will need to enter this code if you need to check your appointment information later.</b> </p> 
      Query Code*<input type="text" name="querycode" id="querycode"  required>
    </div>

    <div class="form-group">
      <input name="submit" type="submit" value="submit">
    </div>
  </form>
</body>

</html>

<script>
  showhkid()

  function showhkid() {
 
    if (document.getElementById("apply").checked) {
      document.getElementById("cardtype").value = "bc";
      document.getElementById("cardbc").disabled = false;
      document.getElementById("cardpp").disabled = false;
      document.getElementById("cardhkid").disabled = true;
      document.getElementById("cardno").placeholder = "";

    } else {
      document.getElementById("cardtype").value = "hkid";
      document.getElementById("cardbc").disabled = true;
      document.getElementById("cardpp").disabled = true;
      document.getElementById("cardhkid").disabled = false;
      document.getElementById("cardno").placeholder = "eg. A123456(7)";
    }
  }
</script>

<style>
  .form-group {
    margin: 10px;
  }
</style>