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

  session_start();

  if (!isset($_SESSION['sessionId'])) {
    echo "Please Login first <br/>";
    echo "<a href='login_form.php'>Click Here to Login</a> or <a href='register_form.php'>Click Here to Register</a>";
    return;
  }

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
    <div id="hkidarea" class="form-group">

      HKID*: <input name="hkid" type="text" size="30" maxlength="100" placeholder="eg. Z683365(5)" required>
    </div>
    <div class="form-group">
      Appointment Date*:<input type="date" id="start" name="dob" list="date-list">
       <datelist id="date-list">
        <option id="01" value="2021-10-01">2021-10-01</option>
       </datelist>
    </div>
    <div class="form-group">
      <input type="time" id="appt" name="appt" list="time-list">

      <datalist id="time-list">
        <option id="09" name="09" value="09:30" datatype="time">
        <option id="10" name="10" value="10:30" datatype="time">
        <option id="13" name="13" value="13:30" datatype="time">
        <option id="20" name="20" value="20:30" datatype="time">
      </datalist>
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
    var x = document.getElementById("hkidarea");
    if (document.getElementById("apply").checked) {
      x.style.display = "none";
    } else {
      x.style.display = "block";
    }
  }
</script>

<style>
  .form-group {
    margin: 10px;
  }
</style>