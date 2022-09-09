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
$search_sql = $conn->prepare("SELECT id,salt, pwd as hash,retry,retry_datetime FROM sys_user WHERE email = ?");
$search_sql->bind_param("s", $email);
$search_sql->execute();
//$search_sql->fetch();
$search_sql->store_result();


//var_dump($search_sql);

if($search_sql->num_rows > 0) 
{       
    session_start();
    $search_sql->bind_result($id, $salt, $hash, $retry, $retry_datetime);
    $search_sql -> fetch();
    $pwdhash = hash("sha512", $salt . $pwd);

    //check retry
    $now = time();
    if($retry >= 3 && $now - $retry_datetime < (60*30))
    {
        echo "You have tried 3 times, please try again after 30 minutes<br/><br/>";
        
        
    }else if(strcmp($pwdhash, $hash) == 0)
    {
        
        $sid = uniqid();
        $_SESSION['sessionId'] = $sid;
        $ip = getIP();
        $start = time();
        $expire = $start + (30*60);// 30min
        $search_sql = $conn->prepare("insert into sys_session(id,user_id,start,expire,client_ip) values(?,?,?,?,?)");
        $search_sql->bind_param("siiis", $sid,$id,$start,$expire,$ip);
        $search_sql->execute();
        $sql = $conn->prepare("update sys_user set retry = 0,retry_datetime = null where id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        header('Location: index.php');
    }
    else
    {
        echo "<h2>The password is wrong, authentication failed</h2>";
        $sql = $conn->prepare("update sys_user set retry = retry + 1,retry_datetime = ? where id = ?");
        $sql->bind_param("ii", $now,$id);
        $sql->execute();
    }
}
else
{
	echo "<h2>Email not exist, authentication failed</h2>";
}

// Close connection
mysqli_close($conn);


Function getIP(){
    $ip='';
    IF(Getenv('HTTP_CLIENT_IP') And StrCaseCmp(Getenv('HTTP_CLIENT_IP'),'unknown')){
        $ip=Getenv('HTTP_CLIENT_IP');
    }ElseIF(Getenv('HTTP_X_FORWARDED_FOR') And StrCaseCmp(Getenv('HTTP_X_FORWARDED_FOR'),'unknown')){
        $ip=Getenv('HTTP_X_FORWARDED_FOR');
    }ElseIF(Getenv('REMOTE_ADDR')And StrCaseCmp(Getenv('REMOTE_ADDR'),'unknown')){
        $ip=Getenv('REMOTE_ADDR');
    }ElseIF(isset($_SERVER['REMOTE_ADDR']) And $_SERVER['REMOTE_ADDR'] And StrCaseCmp($_SERVER['REMOTE_ADDR'],'unknown')){
        $ip=$_SERVER['REMOTE_ADDR'];
    }Else{
        $ip='127.0.0.1';
    }
    Return $ip;
}


?>

<a href="login_form.php">Go back to Login page</a>
<br><br>
<a href="index.php">Go to Home page</a>
</body>
</html>

