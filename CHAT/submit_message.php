<?php
session_start();
include('db.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection (similar to chat.php)

    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];

    $sql = "INSERT INTO chat_messages  VALUES (null,'$sender', '$receiver', '$message',NOW(),0)";
    $conn->query($sql);
    $conn->close();
}


?>