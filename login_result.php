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

/* Get user input which name is "id" and "pwd" 
(assume the id and pwd has correct format) */
$id = $_POST["id"]; 
$pwd = $_POST["pwd"]; 

// Select database to search the corresponding user row
$search_sql = $conn->prepare("SELECT * FROM user WHERE id = ? AND pwd = ?");
$search_sql->bind_param("ss", $id, $pwd);
$search_sql->execute();
$search_sql->store_result();

// If login name can be found in table "user"
if($search_sql->num_rows > 0) 
{
	echo "<h2>Authentication success!</h2>";
}
else
{
    echo "<h2>The password is wrong, authentication failed</h2>";
}

// Close connection
mysqli_close($conn);
?>
</body>
</html>

