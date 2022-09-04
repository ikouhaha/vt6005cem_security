<html>
<head>
<title>Register Result</title>
</head>
<body>
<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "test");

// Check connection
if ($conn->connect_error) 
{
    die("Connection failed: ". $conn->connect_error);
} 

// Get user input from the form submitted before
$id = $_POST["id"]; 
$pwd = $_POST["pwd"];
$name = $_POST["name"];
$email = $_POST["email"];
$color = $_POST["color"];

// Set a flag to assume all user input follow the format
$allDataCorrect = true;
    
// Set empty string with error message
$errMsg = "";
    
// Check all data whether follow the format
if(!preg_match("/^[a-zA-Z0-9_]{6,12}$/",$id))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "User ID should be composed within 6 to 12 alphanumeric characters <br><br>"; 
}

if(!preg_match("/^[a-zA-Z0-9?!_)]{8,}$/",$pwd))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Password should be composed with at least 8 alphanumeric characters and ? ! _ symbol <br><br>"; 
}

if(!preg_match("/[A-Z]([a-zA-Z]|\s)*/",$name))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Name should be composed with English characters start with capital letter<br><br>"; 
}

if(!preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/",$email))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Email should contain @ character <br><br>"; 
}

if(!preg_match("/^#[a-fA-F0-9]{6,6}$/",$color))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Color code should be composed with # symbol and hex number <br><br>"; 
}

  
if($allDataCorrect)
{
    // Search user table to see whether user name is exist
    $search_sql = $conn->prepare("select * from user where id = ?");
    $search_sql->bind_param("s", $id);
    $search_sql->execute();
    $search_sql->store_result();

    // If login name can be found in table "user", forbid user register process

    if($search_sql->num_rows > 0) 
    {
        echo "<h2>The user name is registered by others. Please use other user name</h2>";
    }
    else
    {
        $insert_sql = $conn->prepare("insert into user (id, pwd, name, email, color) values (?, ?, ?, ?, ?)");
        $insert_sql->bind_param("sssss", $id, $pwd, $name, $email, $color);
        $insert_sql->execute();
        echo "<h2>Registration Success!!</h2>";
    }
}
else
{
    echo "<h3> $errMsg </h3>";
}
// Close connection
mysqli_close($conn);
?>
<a href="register_form.php">Go back to register page</a>
<br><br>
<a href="login_form.php">Go to login page</a>
</body>
</html>