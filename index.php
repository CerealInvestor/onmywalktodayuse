<?php // main index.php 
// Start a session
session_start();

// connect to the initialise file first 
include("config/initialise.php");

// Get the page querystring, strip the slashes and trim for security, do not trust users 
//set a variable for the controller with the page name from the querystring
if (isset($_GET['page'])) {
	$page = stripslashes(trim($_GET["page"]));
} else if (empty($_GET['page']) == 'home') {
	$page = 'home';
}

// set the file controller to whatever page we are currently on
$file = CONTROLLERS . $page . '_controller.php';
//echo $file;

// make sure $page is set and that the controller exists for the current page otherwise we redirect to the 404 page not found
if (isset($page) && file_exists($file)) {
	include($file);
} else {
	include(CONTROLLERS . '404_controller.php');
}
?>
