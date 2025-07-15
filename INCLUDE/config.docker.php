<?php
// Docker environment configuration
$db_host = getenv('DB_HOST') ?: 'database';
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: 'rootpassword';
$db_name = getenv('DB_NAME') ?: 'appointmate';

defined('server') ? null : define("server", $db_host);
defined('user') ? null : define("user", $db_user);
defined('pass') ? null : define("pass", $db_pass);
defined('database_name') ? null : define("database_name", $db_name);

$this_file = str_replace('\\', '/', __File__);
$doc_root = $_SERVER['DOCUMENT_ROOT'];
$web_root = str_replace(array($doc_root, "include/config.php"), '', $this_file);
$server_root = str_replace('config/config.php', '', $this_file);
define('web_root', $web_root);
define('server_root', $server_root);
?>
