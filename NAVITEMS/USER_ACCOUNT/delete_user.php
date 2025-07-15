<?php
require_once("include/initialize.php");

$PlaceOrderID = $_POST['PlaceOrderID'];


$sql = "DELETE FROM user_account WHERE UserType<>'ADMIN' UserID=$PlaceOrderID";
$mydb->setQuery($sql);
$mydb->executeQuery();
