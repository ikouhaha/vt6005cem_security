<html>
<head>
<title>Register Result</title>
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

// Get user input from the form submitted before

$ename = $_POST["ename"];
$cname = $_POST["cname"];
$gender = $_POST["gender"];
$email = $_POST["email"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$dob = $_POST["dob"];
$pwd = $_POST["pwd"];
$cpwd = $_POST["cpwd"];
// Set a flag to assume all user input follow the format
$allDataCorrect = true;

// Set empty string with error message
$errMsg = "";
    
// Check all data whether follow the format
if(!preg_match("/[A-Z]([a-zA-Z]|\s)*/",$ename))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "English Name should be composed with English characters start with capital letter<br><br>"; 
}

if(!preg_match("/\p{Han}+/u",$cname))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Chinese Name should be composed with Chinese characters<br><br>"; 
}

if(!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/",$pwd))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Password should Minimum eight characters, at least one uppercase letter, one lowercase letter and one numbe<br><br>"; 
}

if($cpwd != $pwd)
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Confirm Password should be the same as Password<br><br>"; 
}


if(!preg_match("/^(male|female)$/",$gender))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Please choose the valid gender<br><br>"; 
}

if(!preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/",$email))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Email should contain @ character <br><br>"; 
}

if(!preg_match("/^[0-9]{8}$/",$phone))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Phone number should be composed with 8 digits<br><br>"; 
}

if(!preg_match("/([a-zA-Z1-9]|\s|\p{Han}+)*/",$address))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Address not valid<br><br>"; 
}

if(!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/",$dob))
{
    $allDataCorrect = false;
    $errMsg = $errMsg . "Date of birth should be composed with 4 digits, 2 digits, 2 digits<br><br>"; 
}

// if(!preg_match("/^[a-zA-Z0-9?!_)]{8,}$/",$pwd))
// {
//     $allDataCorrect = false;
//     $errMsg = $errMsg . "Password should be composed with at least 8 alphanumeric characters and ? ! _ symbol <br><br>"; 
// }



// if(!preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/",$email))
// {
//     $allDataCorrect = false;
//     $errMsg = $errMsg . "Email should contain @ character <br><br>"; 
// }

// if(!preg_match("/^#[a-fA-F0-9]{6,6}$/",$color))
// {
//     $allDataCorrect = false;
//     $errMsg = $errMsg . "Color code should be composed with # symbol and hex number <br><br>"; 
// }

  
if($allDataCorrect)
{
    // Search user table to see whether user name is exist
    $search_sql = $conn->prepare("select * from sys_user where email = ?");
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
        $insert_sql = $conn->prepare("insert into sys_user (pwd,ename, cname, dob, gender,email,phone,address,salt) values (?, ?, ?, ?, ?,?,?,?,?)");
        $salt = generateSalt(16);
        // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // $encrypted = openssl_encrypt($hkid, 'aes-256-cbc', $aesKey.$salt, 0, $iv);
        $pwd = hash("sha512", $salt . $pwd);
        $insert_sql->bind_param("sssssssss", $pwd, $ename, $cname, $dob, $gender,$email,$phone,$address,$salt);
        $insert_sql->execute();
        echo "<h2>Register Success!!</h2>";
    }
}
else
{
    echo "<h3> $errMsg </h3>";
}
// Close connection
mysqli_close($conn);

// This function generate a random string with particular length
function generateSalt($length)
{
    $rand_str = "";
    $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    
    // (1b) Write a for loop to generate a random string which the length is $length. The loop should randomly select a character and append it to string variable $rand_str
    
    /*______________________________(1b)______________________________*/
    for($i = 0; $i < $length; $i++)
    {
        $rand_str .= $chars[rand(0, strlen($chars) - 1)];
    }
    
    return $rand_str;
}

?>
<a href="login_form.php">Go back to Login page</a>
<br><br>
<a href="index.php">Go to Home page</a>
</body>
</html>