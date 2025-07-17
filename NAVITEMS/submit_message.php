<?php
require_once("INCLUDE/initialize.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (similar to chat.php)

    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];

$sql = "INSERT INTO chat_messages VALUES (NULL,'{$sender}','{$receiver}','{$message}',NOW())";
$mydb->setQuery($sql);
$mydb->executeQuery();
}


?>