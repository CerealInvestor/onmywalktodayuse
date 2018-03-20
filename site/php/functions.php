<?php
	/*
		Function to check whether a piece of data exists
		Accepts 1 data value you wish to check
		Sets the where data to whatever $userInput is set to the function
		returns true or false depending on found or not
	*/
	function checkIfExists($data, $userInput, $table, $db) {
		// Check to see is username exists in the database
		$sql = 'SELECT ' . $data. ' FROM ' . $table . ' WHERE ' . $data . ' = :' . $data . '';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':' . $data, $userInput, PDO::PARAM_STR);
		$stmt->execute();
		
		$numRows = $stmt->rowCount();
		
		// Check to see if  a row was found, if it has then the data exists in the database already so an error needs to be returned
		if ($numRows > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	// Encrypt user password
	function passwordEncrypt($password) {
		// set the salt
		$salt = substr(md5(time()), 0, 22);
		
		// encrypt using blowfish with a load of 10
		$password = crypt($password, '$2a$10$' . $salt);
		
		// return the encrypted hash
		return $password;
	}
	
	// This function is needed to get the userid when logging in o that we can update last loggedin function as we login with username
	function getUserIdByUserName($userName, $db) {
		$stmt = $db->prepare('SELECT userid FROM users WHERE userName = :userName');
		$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
		
		$stmt->execute();
		
		$row = $stmt->fetch();
		
		return $row['userid'];
	}
	
	/*
		Once login has been passed we get all the user data here so that we can store it in a session which is accessible everywhere
	*/
	function storeSessionLogin($userName, $db, $userId = null) {
		// Check to see is username exists in the database
		$sql = 'SELECT * FROM users WHERE userName = :userName';
		if (isset($userId)) {
			$sql = $sql . ' AND userId = :userId';
		} 
				
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
		
		if (isset($userId)) {
			$stmt->bindValue(':userId', $userId, PDO::PARAM_STR);
		} 
		
		// Get the user id 
		$userId = getUserIdByUserName($userName, $db);
		
		$stmt->execute();
		
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		
		// As the user is updating the stored session data which generally  will be logging in we can update the last login time
		updateLastLogin($userId, $db);
		
		// store a variable tosay we are logged in
		// Store all user data in a session variable
		$_SESSION['loggedIn'] = true;
		$_SESSION['loggedInUserData'] = $row;
		
		// get a shortr version session variable for user level
		$_SESSION['userLevel'] = $_SESSION['loggedInUserData']['userLevel'];
		$_SESSION['userId'] = $_SESSION['loggedInUserData']['userid'];
		
		// Remove the password hash from the constant session in case it is intercepted:: A bit OTT but helps
		unset($_SESSION['loggedInUserData']['password']);
		
		return true;
	}
	
	// Update the last login ip address and time this will be updated 
	function updateLastLogin($userid, $db) {
		// get closest to the users real ip as we can
		$lastIPAddress = $_SERVER["REMOTE_HOST"] ?: gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		
		// the current time and date of the server
		$lastOnline = date("Y-m-d H:i:s");

		$stmt = $db->prepare('UPDATE users SET lastIPAddress = :lastIPAddress, lastOnline = :lastOnline WHERE userid = :userid');
		$stmt->bindValue(':lastIPAddress', $lastIPAddress, PDO::PARAM_STR);
		$stmt->bindValue(':lastOnline', $lastOnline, PDO::PARAM_STR);
		$stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
		
		$stmt->execute();
		
		return true;
	}
	
	/*
		Check password function when logging in
		first we select the password from the supplied username from the database
		// get the row and set the hash to the currect password from the database
		//run the salts etc and check to see if the passwords match
	*/
	function checkPassword($userName, $password, $db){
		$sql = 'SELECT password FROM users WHERE userName = :userName';
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
		$stmt->execute();
		
		$numRows = $stmt->rowCount();
		
		if ($numRows > 0) {
			$row = $stmt->fetch();
			$hash = $row['password'];

			// run the hash function on $password 
			$fullSalt = substr($hash, 0, 29); 
			$new_hash = crypt($password, $fullSalt); 
			
			// Check that the password matches
			if($hash == $new_hash) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	
	/*
		Function which is called on all restricted pages
		check if user is logged in
		check if userLevel is correct for the page
	*/
	
	function loggedIn($pageType = 'user') {
		
		// check if both $loggedIn and $userLevel sessions are set
		if (isset($_SESSION['userLevel']) && isset($_SESSION['loggedIn'])) {
			// If the user is an admin therefore they will have access
			if ($_SESSION['userLevel'] == 'admin') {
				return true;
			}

			// check to see if the current user level is correct for the current page
			// if it is not equal redirect to access denied page
			if($_SESSION['userLevel'] != $pageType){
				header('Location: ' . SITE_ROOT . '?page=access&error=access');
			} else {
				return true;
			}
		} else {
			// if no session variables are set then somebody is trying to access the page that is not logged in
			header('Location: ' . SITE_ROOT . '?page=access&error=access');
		}
	}
	
	/*
		function to unset all user logged in sessions which have been set when logging in.
	*/
	function logout($userid, $db) {
		// Update the last online and last ip address
		updateLastLogin($userid, $db);
	
		session_unset();
		
		return true;
	}
	
	
	/* this is to check whether users are viewing only their content list*/
	function checkUserContentList($contentid, $userid, $db) {
	
		$stmt = $db->prepare('SELECT * FROM contentList WHERE contentid = :contentid AND userid = :userid');
		$stmt->bindValue(':contentid', $contentid, PDO::PARAM_INT);
		$stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
		
		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			
			// If the row has been found return true otherwise we redirect to access page
			if ($rowCount > 0) {
				return true;
			} else{
				header('Location: ' . SITE_ROOT . '?page=access&error=access');
			}
		} else {
			header('Location: ' . SITE_ROOT . '?page=access&error=access');
		}
	}
?>