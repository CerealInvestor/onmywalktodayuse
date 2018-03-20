<?php

// include the data page
include(DATA . 'cms.php');

// include the head and meta
include(LAYOUT . 'head.php');

// include the header
include(LAYOUT . 'header.php');

// include the page content
include(VIEWS . $pageView . '.php');

// include the footer
include(LAYOUT . 'footer.php');

?>