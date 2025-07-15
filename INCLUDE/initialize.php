<?php
//define the core paths
//Define them as absolute peths to make sure that require_once works as expected

//DIRECTORY_SEPARATOR is a PHP Pre-defined constants:
//(\ for windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

defined('SITE_ROOT') ? null : define('SITE_ROOT', $_SERVER['DOCUMENT_ROOT']);

defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT . DS . 'include');

//load the database configuration first.
// Use Docker config if running in Docker, otherwise use regular config
if (file_exists(LIB_PATH . DS . "config.docker.php") && getenv('DB_HOST')) {
    require_once(LIB_PATH . DS . "config.docker.php");
} else {
    require_once(LIB_PATH . DS . "config.php");
}
require_once(LIB_PATH . DS . "function.php");
require_once(LIB_PATH . DS . "session.php");
require_once(LIB_PATH . DS . "useraccount.php");
require_once(LIB_PATH . DS . "downloadablefile.php");

require_once(LIB_PATH . DS . "officials.php");


require_once(LIB_PATH . DS . "_clearance.php");
require_once(LIB_PATH . DS . "_cedula.php");
require_once(LIB_PATH . DS . "_permit.php");
require_once(LIB_PATH . DS . "_indigency.php");
require_once(LIB_PATH . DS . "_court.php");
require_once(LIB_PATH . DS . "announcement.php");
require_once(LIB_PATH . DS . "monthlydues.php");
//load the database connection
require_once(LIB_PATH . DS . "database.php");