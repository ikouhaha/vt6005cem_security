<html>
<head>
<title>Login Result</title>
</head>
<body>
<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "cw2");

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: ". $conn->connect_error);
} 

/* Get user input which name is "email" and "pwd" 
(assume the email and pwd has correct format) */
$email = $_POST["email"]; 
$pwd = $_POST["pwd"]; 

// (2a) Write prepare statements to retrieve the columns salt and hash with the corresponding user

/*______________________________(2a)______________________________*/

// If login name can be found in table "userhash"
// Select database to search the corresponding user row
$search_sql = $conn->prepare("SELECT id,salt, pwd as hash FROM sys_user WHERE email = ?");
$search_sql->bind_param("s", $email);
$search_sql->execute();
//$search_sql->fetch();
$search_sql->store_result();


//var_dump($search_sql);

if($search_sql->num_rows > 0) 
{       
    $search_sql -> bind_result($id,$salt,$hash);
    $search_sql -> fetch();
    $pwdhash = hash("sha512", $salt . $pwd);

    session_start();
    if(strcmp($pwdhash, $hash) == 0)
    {
        
        $sid = uniqid();
        $_SESSION['sessionId'] = $sid;
        $start = time();
        $expire = $start + (30*60);// 30min
        $search_sql = $conn->prepare("insert into sys_session(id,user_id,start,expire) values(?,?,?,?)");
        $search_sql->bind_param("siii", $sid,$id,$start,$expire);
        $search_sql->execute();
        header('Location: index.php');

    }
    else
    {
        echo "<h2>The password is wrong, authentication failed</h2>";
    }
}
else
{
	echo "<h2>Email not exist, authentication failed</h2>";
}

// Close connection
mysqli_close($conn);


?>

<a href="login_form.php">Go back to Login page</a>
<br><br>
<a href="index.php">Go to Home page</a>
</body>
</html>

