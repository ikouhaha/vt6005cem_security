<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Welcome to HKID card appointment system!</title>
</head>

<body>
    <h1><strong>Welcome to HKID card appointment system!
        </strong></h1>
    <?php

    // Create connection
$conn = new mysqli("localhost", "root", "", "cw2");

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: ". $conn->connect_error);
} 

    session_start();
 
    if (!isset($_SESSION['sessionId'])) {
        echo "Please Login first <br/>";
        echo "<a href='login_form.php'>Click Here to Login</a> or <a href='register_form.php'>Click Here to Register</a>";
    } else {

        $search_sql = $conn->prepare("SELECT a.user_id,a.start,a.expire,b.email FROM sys_session a inner join sys_user b on a.user_id = b.id where a.id = ?");
        $search_sql->bind_param("i", $_SESSION['sessionId']);
        $search_sql->execute();
        //$search_sql->fetch();
        $search_sql->store_result();
        $now = time(); // Checking the time now when home page starts.

        if ($search_sql->num_rows > 0) {
            $search_sql->bind_result($id, $start, $expire, $email);
            $search_sql->fetch();
            if ($now > $expire) {
                echo "Your session has expired! <a href='login_form.php'>Login here</a>";
            } else {
                echo "Welcome $email <br/>";
                echo "<a href='logout.php'>Logout</a>";
                echo "<p>Select function:</p>";
                echo "<p><a href='appointment_form.php'>Make an appointment</a></p>";
                echo "<p><a href='appointment_list.php'>View appointment list</a></p>";
            }
        } else {
            echo "Please Login first <br/>";
            echo "<a href='login_form.php'>Click Here to Login</a> or <a href='register_form.php'>Click Here to Register</a>";
        }
   
     
    }



    ?>


</body>

</html>