<?php
require_once("include/initialize.php");
$Username=$_SESSION['Username'];

// Use Railway MySQL env vars first, fallback to Docker/local
$servername = getenv('MYSQLHOST') ?: "db";
$username = getenv('MYSQLUSER') ?: "appointmate_user";
$password = getenv('MYSQLPASSWORD') ?: "appointmate_password";
$database = getenv('MYSQLDATABASE') ?: "appointmate";

$con = mysqli_connect($servername, $username, $password, $database);ire_once("include/initialize.php");
$Username=$_SESSION['Username'];

// Use Railway MySQL env vars first, fallback to Docker/local
$servername = getenv('MYSQLHOST') ?: getenv('DATABASE_HOST') ?: "db";
$username = getenv('MYSQL_USER') ?: getenv('DATABASE_USER') ?: "appointmate_user";
$password = getenv('MYSQLPASSWORD') ?: getenv('DATABASE_PASSWORD') ?: "appointmate_password";
$database = getenv('MYSQL_DATABASE') ?: getenv('DATABASE_NAME') ?: "appointmate";

$con = mysqli_connect($servername, $username, $password, $database);

    // SQL query to display row count
    // in building table
    $sql = "SELECT * FROM chat_messages where receiver='$Username' AND `read`=0";

    if ($result = mysqli_query($con, $sql)) {

    // Return the number of rows in result set
    $rowcount = mysqli_num_rows( $result );

    // Display result
    //printf("Total rows in this table : %d\n", $rowcount);
    echo $rowcount;
}

// Close the connection
mysqli_close($con);





?>