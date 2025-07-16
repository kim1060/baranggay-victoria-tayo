<?php
require_once("include/initialize.php");
$Username=$_SESSION['Username'];

$con = mysqli_connect("db","root","root","appointmate");

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