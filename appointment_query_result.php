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
        echo "Please Login first <br/><br/>";
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
        echo "Please Login first <br/><br/>";
        echo "<a href='login_form.php'>Click Here to Login</a> or <a href='register_form.php'>Click Here to Register</a>";
        return;
    }
    //--------------------------checking session end--------------------------


    // Get user input from the form submitted before

    $cardno = $_POST["cardno"];
    $querycode = $_POST["querycode"];
    $cardtype = $_POST["cardtype"];


    $allDataCorrect = true;

    $aesKey = "12345678123456781234567812345678";

    // Set empty string with error message
    $errMsg = "";

    if (!preg_match("/^(bc|pp|hkid)$/", $cardtype)) {
        $allDataCorrect = false;
        $errMsg .= "Please select the certificate type <br/><br/>";
    }

    //check certificate number
    if ($cardtype == "bc") {
        if (!preg_match("/^[A-Z]{1,2}[0-9]{6}\([0-9A]\)$/", $cardno)) {
            $allDataCorrect = false;
            $errMsg .= "Please enter the correct birth certificate number <br/><br/>";
        }
    } else if ($cardtype == "pp") {
        if (!preg_match("/^[A-Z]{1,2}[0-9]{6,7}[0-9A-F]{1}$/", $cardno)) {
            $allDataCorrect = false;
            $errMsg .= "Please enter the correct passport number <br/><br/>";
        }
    } else if ($cardtype == "hkid") {
        if (!preg_match("/^[A-Z]{1,2}[0-9]{6}\([0-9A]\)$/", $cardno)) {
            $allDataCorrect = false;
            $errMsg .= "Please enter the correct HKID number <br/><br/>";
        }
    }


    if ($allDataCorrect)


    {


        $search_sql = $conn->prepare("select ltype.display as type,b.ename,b.cname,b.dob,b.gender,b.email,b.phone,b.address,a.status,a.card_no,a.date,ltime.display as time,lvenue.display as venue,a.iv  
        from hkid_appointment a inner join sys_user b on a.user_id = b.id
        left join sys_lookup_value ltype on ltype.type = 'type' and ltype.value = a.type
        left join sys_lookup_value ltime on ltime.type = 'time' and ltime.value = a.time
        left join sys_lookup_value lvenue on lvenue.type = 'venues' and lvenue.value = a.venue where card_type = ?  and query_code = ?");
        
        
        $search_sql->bind_param("ss", $cardtype, $querycode);
        $search_sql->execute();
        $search_sql->store_result();
        
        if ($search_sql->num_rows > 0) {
            $search_sql->bind_result($type, $ename, $cname, $dob, $gender, $email, $phone, $address, $status, $dbcardno, $date, $time, $venue,$iv);
            $search_sql->fetch();
            
            $decrypted = openssl_decrypt($dbcardno, 'aes-256-cbc', $aesKey, 0, $iv);
            //check card no
            if($cardno!=$decrypted){
                echo "Please enter the correct card number <br/><br/>";
                
            }else{
                echo "Your appointment information is as follows: <br/><br/>";
                echo "Appointment Type: " . $type . "<br/><br/>";
                echo "English Name: " . $ename . "<br/><br/>";
                echo "Chinese Name: " . $cname . "<br/><br/>";
                echo "Date of Birth: " . $dob . "<br/><br/>";
                echo "Gender: " . $gender . "<br/><br/>";
                echo "Email: " . $email . "<br/><br/>";
                echo "Phone: " . $phone . "<br/><br/>";
                echo "Address: " . $address . "<br/><br/>";
                echo "Appointment Status: " . $status . "<br/><br/>";
                echo "Appointment Date: " . $date . "<br/><br/>";
                echo "Appointment Time: " . $time . "<br/><br/>";
                echo "Appointment Venue: " . $venue . "<br/><br/>";
            }

       
            
           




          

        } else {
            echo "<h2>Can't found the result.</h2>";
            
        }


      
    } else {
        echo "<h3> $errMsg </h3>";
    }
    // Close connection
    mysqli_close($conn);


    ?>
    <a href="appointment_query.php">Go back to query appointment page</a>
    <br><br>
    <a href="appointment_form.php">Go to appointment page</a>
    <br><br>
    <a href="index.php">Go to Home page</a>
</body>

</html>