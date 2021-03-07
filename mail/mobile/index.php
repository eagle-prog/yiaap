<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//echo "vvv".$_COOKIE['inout_username'];exit(0);
/*echo $_SERVER['SCRIPT_NAME'];
			$var=$_SERVER['SCRIPT_NAME'];
			echo strrpos ($var,"/");
			$var=substr($var,0,strrpos($var,"/")); 
			echo "<br>xxx".$var;*/
//exit(0);
//Error Reporting
error_reporting(1);

// Including script directory configuration
include("script.inc.php");

// Loading the main class
include($library_path."Nesote/Main.class.php");

// Creating a singleton class object.
$main=Main::getInstance();

// Dispatching the page.
$main->dispatch();

?>