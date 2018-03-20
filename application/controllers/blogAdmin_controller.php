<?php

// include the data page
include(DATA . 'blogAdmin.php');

// include the head and meta
include(LAYOUT . 'head.php');

// include the header
include(LAYOUT . 'header.php');

// the $pageView variable is set throughout the documentlist data file as it it determines which view is loaded in to the controller
include(VIEWS . $pageView . '.php');

// include the footer
include(LAYOUT . 'footer.php');

?>