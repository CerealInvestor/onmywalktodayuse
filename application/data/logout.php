<?php 
	// call the logout function in php/functions.php
	// Redirect to the home page afterwards
	logout($_SESSION['userId'], $db);
	
	header('Location: ' . SITE_ROOT . '?page=home');
?>