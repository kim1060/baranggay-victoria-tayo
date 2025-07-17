<?php
// Use Railway's environment variables with fallback values for local development
defined('server') ? null : define("server", getenv('MYSQLHOST') ?: "db");
defined('user') ? null : define("user", getenv('MYSQLUSER') ?: "appointmate_user");
defined('pass') ? null : define("pass", getenv('MYSQLPASSWORD') ?: "appointmate_password");
defined('database_name') ? null : define("database_name", getenv('MYSQLDATABASE') ?: "appointmate");







$this_file = str_replace('\\', '/', __File__) ;
$doc_root = $_SERVER['DOCUMENT_ROOT'];

$web_root =  str_replace (array($doc_root, "INCLUDE/config.php") , '' , $this_file);
$server_root = str_replace ('INCLUDE/config.php' ,'', $this_file);

define ('web_root' , $web_root);
define('server_root' , $server_root);