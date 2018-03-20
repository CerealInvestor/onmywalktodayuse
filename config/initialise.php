<?php 
/*
	the initialise file includes all files which are required to make the site work correctly
*/

include('settings.php');
include('db.php');
include('paths.php');
include(PHP . 'functions.php');

// set up the default include_path...this is where the system looks for
// files to include

ini_set("include_path", ROOT.":".ini_get("include_path") );

?>