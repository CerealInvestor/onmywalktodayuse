<?php

// Get the page content from the database
include(PHP . 'getPage.php');

// include the data page
include(DATA . 'myaccount.php');

// include the head and meta
include(LAYOUT . 'head.php');

// include the header
include(LAYOUT . 'header.php');

// include the page content
include(VIEWS . 'myaccount.php');

// include the footer
include(LAYOUT . 'footer.php');

?>