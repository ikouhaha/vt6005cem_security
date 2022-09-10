<html>
<head>
<title>Appointment query Form</title>

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
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
<form action="appointment_query_result.php" method="post" id="form">
<h2>Appointment query *required</h2>

Query No*: <input type="text" name="querycode" required><br>
<div id="passportarea" class="form-group">
    Certificate Type*:
      <select name="cardtype" id="cardtype" required onchange="showhkid()">
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

    <button class="g-recaptcha" 
        data-sitekey="6LeaJOchAAAAAJo605nDzUlZAXdO6yUM8HF9RuN0" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button> <BR/><BR/>

<input  name="submit" type="submit" value="submit" style="visibility:hidden  ">
</form>
</body>
</html>
<script>
  showhkid()

  function showhkid() {
 
    if (document.getElementById("cardtype").value=="hkid") {
        document.getElementById("cardno").placeholder = "eg. A123456(7)";

    } 
  }

  function onSubmit(token) {
    document.getElementById("form").submit.click();
   }
</script>
