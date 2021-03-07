<?php
//echo $_GET['page'];
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
