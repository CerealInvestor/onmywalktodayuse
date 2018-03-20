<?php

/*
	Store as constants paths to different locations around the website
*/

// define the root of the project

define("ROOT", dirname(dirname(__FILE__)) );
// dirname(__FILE__) finds the path to the folder which the current file is in (ie the config folder)
// dirname(dirname(__FILE__)) finds the folder which the config folder is in (ie the root folder)


// set up the paths...

define("APPLICATION", ROOT.DS . "application".DS);
define("CONTROLLERS", APPLICATION . "controllers".DS);

define("DATA", APPLICATION . "data" . DS);
define("VIEWS", APPLICATION . "views" . DS);

define("CONFIG", ROOT . DS ."config" . DS);

define("SITE", ROOT.DS . "site" . DS);
define("SITE_ROOT", '');
define("SITE_URL", 'http://localhost:8888/onmywalktoday/v2.0' . DS);

define("CSS", SITE_ROOT . "site/css/");
define("IMAGES", SITE_ROOT . "site/images/");
define("JS", SITE_ROOT . "site/js/");
define("PHP", SITE_ROOT . "site/php/");
define("UPLOADS", SITE_ROOT . "site/uploads/");
define("USER_DOWNLOADS", SITE_ROOT . "site/uploads/");

define("LIB", SITE_ROOT . "site/lib/");
define("STYLES", SITE_ROOT . "site/styles/");

define("LAYOUT", SITE . "layout/");
define("CONTENT", SITE . "content/");

?>