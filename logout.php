<?php
require_once 'include/initialize.php';
// Four steps to closing a session
// (i.e. logging out)

// 1. Find the session
@session_start();

// 2. Unset all the session variables

unset($_SESSION['UserID']);
unset($_SESSION['Firstname']);
unset($_SESSION['Middlename']);
unset($_SESSION['Lastname']);

unset($_SESSION['Address']);
unset($_SESSION['Age']);
unset($_SESSION['Status']);
unset($_SESSION['Citizenship']);
unset($_SESSION['Email']	);
unset($_SESSION['Contact']);

unset($_SESSION['Username']);
unset($_SESSION['Password']);	
unset($_SESSION['UserType']);
unset($_SESSION['IsVerified']);

// 4. Destroy the session
session_destroy();
//redirect("index.php?logout=1");
redirect("login.php?logout=1");