<html>
<head>
<title>Login Form</title>
<script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
<form action="login_result.php" method="post" id="form" >
<h1>Login</h1>
Email: <input name="email" type="text" size="30" maxlength="100" required><br><br>
Password: <input name="pwd" type="password" size="30" maxlength="100" required>
<br><br>
<button class="g-recaptcha" 
        data-sitekey="6LeaJOchAAAAAJo605nDzUlZAXdO6yUM8HF9RuN0" 
        data-callback='onSubmit' 
        data-action='submit'>Submit</button> <BR/><BR/>

<input  name="submit" type="submit" value="submit" style="visibility:hidden  ">
</form>
</body>
</html>


<script>
   function onSubmit(token) {
    document.getElementById("form").submit.click();
   }
 </script>