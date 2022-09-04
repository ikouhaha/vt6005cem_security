<html>
<head>
<title>Appointment query Form</title>

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
<h2><a href="index.php">Home</a></h2>
<form action="appointment_query_result.php" method="post">
<h2>Appointment *required</h2>

HKID*: <input name="hkid" type="text" size="30" maxlength="100" placeholder="eg. Z683365(5)" required><br><br>
Date of birth*:<input type="date" id="start" name="dob" min="1850-01-01" max="2022-12-31" required> <br/><br/>
Email*: <input name="email" type="text" size="30" maxlength="100"  placeholder="eg. abc@email.com" required><br><br>
<input name="submit" type="submit" value="submit">
</form>
</body>
</html>
