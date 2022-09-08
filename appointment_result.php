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

    $cardno = $_POST["cardno"];
    $type = $_POST["type"];
    $cardtype = $_POST["cardtype"];
    $querycode = $_POST["querycode"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $venue = $_POST["venue"];
    $querycode = $_POST["querycode"];


    // Set a flag to assume all user input follow the format
    $allDataCorrect = true;
    $aesKey = "12345678123456781234567812345678";
  
    // Set empty string with error message
    $errMsg = "";

    // Check all data whether follow the format



    if (!preg_match("/^(apply|change)$/", $type)) {
        $allDataCorrect = false;
        $errMsg .= "Please select the appointment type <br/>";
    }



    if (!preg_match("/^(bc|pp|hkid)$/", $cardtype)) {
        $allDataCorrect = false;
        $errMsg .= "Please select the certificate type <br/>";
    }

    //check certificate number
    if ($cardtype == "bc") {
        if (!preg_match("/^[A-Z]{1,2}[0-9]{6}\([0-9A]\)$/", $cardno)) {
            $allDataCorrect = false;
            $errMsg .= "Please enter the correct birth certificate number <br/>";
        }
    } else if ($cardtype == "pp") {
        if (!preg_match("/^[A-Z]{1,2}[0-9]{6,7}[0-9A-F]{1}$/", $cardno)) {
            $allDataCorrect = false;
            $errMsg .= "Please enter the correct passport number <br/>";
        }
    } else if ($cardtype == "hkid") {
        if (!preg_match("/^[A-Z]{1,2}[0-9]{6}\([0-9A]\)$/", $cardno)) {
            $allDataCorrect = false;
            $errMsg .= "Please enter the correct HKID number <br/>";
        }
    }

    //check date
    if (!preg_match("/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/", $date)) {
        $allDataCorrect = false;
        $errMsg .= "Please enter the correct date <br/>";
    }

    //check time
    if (!preg_match("/^[0-9]{1,2}:[0-9]{2}$/", $time)) {
        $allDataCorrect = false;
        $errMsg .= "Please enter the correct time <br/>";
    }

    //check venue
    if (!preg_match("/^(kt|st|ct|wc)$/", $venue)) {
        $allDataCorrect = false;
        $errMsg .= "Please select the venue <br/>";
    }

    //check query code
    if (!preg_match("/^[0-9]{4}$/", $querycode)) {
        $allDataCorrect = false;
        $errMsg .= "Please enter the 4 custom digit query code <br/>";
    }

    // If all data are correct, insert the data into the database
    if ($allDataCorrect) {
        // Search user table to see whether user name is exist
        $search_sql = $conn->prepare("select * from hkid_appointment where user_id  = ? and status <> 'rejected'");
        $search_sql->bind_param("s", $uid);
        $search_sql->execute();
        $search_sql->store_result();


        // If login name can be found in table "user", forbid user register process

        if ($search_sql->num_rows > 0) {
            echo "<h2>Your appointment is made. Please query the appointment information</h2>";
        } else {

            // Insert user data into table "hkid_appointment"
            $status = "pending";
            $insert_sql = $conn->prepare("insert into hkid_appointment (user_id, type, card_type, card_no, date, time, venue, query_code, status,iv) values (?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
 
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted = openssl_encrypt($cardno, 'aes-256-cbc', $aesKey , 0, $iv);

            $insert_sql->bind_param("ssssssssss", $uid, $type, $cardtype, $encrypted, $date, $time, $venue, $querycode, $status, $iv);
            $insert_sql->execute();
            echo "<h2>Appointment Success!!</h2>";
        }
    } else {
        echo "<h3> $errMsg </h3>";
    }
    // Close connection
    mysqli_close($conn);


    ?>
    <a href="appointment_query.php">Go to appointment query page</a>
    <br><br>
    <a href="index.php">Go to Home page</a>
</body>

</html>