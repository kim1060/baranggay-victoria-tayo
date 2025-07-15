<?php
require_once("include/initialize.php");
$Username=$_SESSION['Username'];

// Use Docker environment variables if available
$db_host = getenv('DB_HOST') ?: 'localhost';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';
$db_name = getenv('DB_NAME') ?: 'appointmate';

$con = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

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