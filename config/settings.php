<?php // settings.php

// any website setting can be declared here...such as
// * timezone and date settings
// * defining any site constants
// * error handling


// site constants

// define the directory separator...normally this is "/" but sometimes it is "\"
// the built in constant DIRECTORY_SEPARATOR will know what it is for the system it is using
define("DS", DIRECTORY_SEPARATOR);


// error display settings TURNO OFF ON PRODUCTION
ini_set("display_errors", "on");
ini_set("error_reporting", E_ALL);

// change this to et database local or live
const DB_STATE = 'local';

// Database constants local and live are seperate
const DB_LOCAL_USER = 'root';
const DB_LOCAL_PASSWORD = 'root';
const DB_LOCAL_NAME = 'onmywalktoday';
const DB_LOCAL_HOST = 'localhost';
const DB_LOCAL_PORT = 8889;


const DB_USER = 'onmywalk_MySQL';
const DB_PASSWORD = 'element22';
const DB_NAME = 'onmywalk_today';
const DB_HOST = 'localhost';
const DB_PORT = 8889;

const SITE_NAME = 'OnMyWalkToday.co.uk';

?>