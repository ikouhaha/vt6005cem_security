<html>
<head>
<title>Register Form</title>
<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
</head>
<body>
<h2><a href="index.php">Home</a></h2>
<form action="register_result.php" method="post">
<h2>Register *required</h2>

Email*: <input name="email" type="text" size="30" maxlength="100"  placeholder="eg. abc@email.com" required><br><br>
Password*:<input type="password" id="pwd" name="pwd" required placeholder="eg. Aa123456"> <br/><br/>
Confirm Password*:<input type="password" id="cpwd" name="cpwd" required placeholder="eg. Aa123456"> <br/><br/>

English name*: <input name="ename" type="text" size="30" maxlength="100"  placeholder="eg. Chan Tai Man" required><br><br>
Chinese name*: <input name="cname" type="text" size="30" maxlength="100"   placeholder="eg. 陳大明" required><br><br>
Date of birth*:<input type="date" id="start" name="dob" min="1850-01-01" max="2022-12-31" required> <br/><br/>

Gender*:  <div class="form-check form-check-inline">

  <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked required>
  <label class="form-check-label" for="male">male</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="gender" id="female" value="female" >
  <label class="form-check-label" for="female">Female</label>
</div>
<br/>
<br/>

Phone*: <input name="phone" type="text" size="30" maxlength="100"  placeholder="eg. 22678951" required><br><br>
Address*: <input name="address" type="text" size="30" maxlength="100"  placeholder="" required><br><br>
<input name="submit" type="submit" value="submit">
</form>
</body>
</html>
