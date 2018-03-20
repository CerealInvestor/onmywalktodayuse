<?php
	include(PHP . 'getPage.php');
	
	// Here we check to see if the user has been sent to the login page from a successful sign up, if they have we can set a message for them
	// [FIX] sanitize input
	if (isset($_GET['register'])) {
		$register = stripslashes(trim($_GET['register']));
		
		if ($register == true) {
			$msg = 'Thank you for signing up to PUBMyContent please login below.';
		}
	}
	
	// check if form has been posted
	// check username and password has been filled out
	// cehck that the username exists in the database
	// check that the password is correct
	// set login session arrays including storing the majority of user data in a array
	
	if($_POST) {
		$error = '';
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		
		if ($userName == '') {
			$error = $error . '<p>Please enter your username</p>';
		}
		
		if ($password == '') {
			$error = $error . '<p>Please enter a password</p>';
		}
		
		if ($error == '') {
			if(checkIfExists('userName', $userName, 'users', $db)) {
				if (!checkPassword($userName, $password, $db)) {
					$error = $error . '<p>Password is incorrect</p>';
				} else {
					// Store session data for the user that has logged in
					storeSessionLogin($userName, $db);

					//Redirect to the homepage
					header('Location: ' . SITE_ROOT . '?page=home');
				}
			} else {
				$error = $error . '<p>User does not exist</p>';
			}
		}
	}
?>