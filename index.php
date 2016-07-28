<?php
header('Content-type:text/html;charset=utf8');
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
define('APPLICATION_PATH', dirname(__FILE__));

$application = new Yaf\Application( APPLICATION_PATH . "/conf/application.ini");

$application->bootstrap()->run();
?>
