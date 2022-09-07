<html>

<head>
    <title>Register Result</title>
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


    // Get user input from the form submitted before
    $hkid = $_POST["hkid"];
    $email = $_POST["email"];
    $dob = $_POST["dob"];
    // Set a flag to assume all user input follow the format
    $allDataCorrect = true;
    $aesKey = "1234567890123456";

    // Set empty string with error message
    $errMsg = "";

    if (!preg_match("/^[A-Z]{1,2}[0-9]{6}\([0-9A]\)$/", $hkid)) {
        $allDataCorrect = false;
        $errMsg = $errMsg . "HKID should be composed with capital letter and 6 digits and a bracket with a digit or capital letter<br><br>";
    }


    if (!preg_match("/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/", $email)) {
        $allDataCorrect = false;
        $errMsg = $errMsg . "Email should contain @ character <br><br>";
    }


    if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $dob)) {
        $allDataCorrect = false;
        $errMsg = $errMsg . "Date of birth should be composed with 4 digits, 2 digits, 2 digits<br><br>";
    }


    if ($allDataCorrect)

    // // Select database to search the corresponding user row
    // $search_sql = $conn->prepare("SELECT * FROM user WHERE id = ? AND pwd = ?");
    // $search_sql->bind_param("ss", $id, $pwd);
    // $search_sql->execute();
    // $search_sql->store_result();

    {
        // Search user table to see whether user name is exist
        $search_sql = $conn->prepare("select * from hkid_appointment where email = ? and dob = ? and hkid = ?");
        $search_sql->bind_param("s", $id);
        $search_sql->execute();
        $search_sql->store_result();

        // If login name can be found in table "user", forbid user register process

        if ($search_sql->num_rows <= 0) {
            echo "<h2>Can't found the result.</h2>";
        } else {
            // $insert_sql = $conn->prepare("insert into user (hkid, ename, cname, dob, gender,email,phone,address,salt,status) values (?, ?, ?, ?, ?,?,?,?,?,?)");
            // $salt = generateSalt(16);
            // $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            // $encrypted = openssl_encrypt($hkid, 'aes-256-cbc', $aesKey + $salt, 0, $iv);

            // $insert_sql->bind_param("ssssssssss", $encrypted, $ename, $cname, $dob, $gender, $email, $phone, $address, $salt, $status);
            // $insert_sql->execute();
            // echo "<h2>Appointment Success!!</h2>";
        }
    } else {
        echo "<h3> $errMsg </h3>";
    }
    // Close connection
    mysqli_close($conn);

    // This function generate a random string with particular length
    function generateSalt($length)
    {
        $rand_str = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

        // (1b) Write a for loop to generate a random string which the length is $length. The loop should randomly select a character and append it to string variable $rand_str

        /*______________________________(1b)______________________________*/
        for ($i = 0; $i < $length; $i++) {
            $rand_str .= $chars[rand(0, strlen($chars) - 1)];
        }

        return $rand_str;
    }

    ?>
    <a href="appointment_query.php">Go back to query appointment page</a>
    <br><br>
    <a href="appointment_form.php">Go  to appointment  page</a>
    <br><br>
    <a href="index.php">Go to Home page</a>
</body>

</html>