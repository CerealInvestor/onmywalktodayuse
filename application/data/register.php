<?php  
	// Check to see if an error has occurred priviously, if so set the $error vaiable

	// see if the form has been posted
	// Set error variable
	// get all the form inputs and put them in to variables
	// check required fields are filled out correctly
	// prepare the pdo mysql statement to stop SQL injection
	// execute the sql statement to insert user data to the database
	// check that the insert was successful
	// if successful redirect to login page
	// if not successful redirect to register page displaying errors
	if ($_POST) {
		// Unset the error session which is set to pass the error over when the form is submitted if there is an error
		$error = false;
	
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmPassword'];
		
		$email = $_POST['email'];
		$confirmEmail = $_POST['confirmEmail'];
		
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$dob = $_POST['dob'];
		
		$address1 = $_POST['address1'];
		$address2 = $_POST['address2'];
		$postcode = $_POST['postcode'];
		$county = $_POST['county'];
		$country = $_POST['country'];
		$telephone = $_POST['telephone'];
		
		// Run a function which is contained in the php folder which checks to see i the data exists already in the database
		if (checkIfExists('userName', $userName, 'users', $db)) {
			$error = $error . '<p>Username exists, please try another.</p>';
		}
		
		if (checkIfExists('email', $email, 'users', $db)) {
			$error = $error . '<p>Email exists, please try another.</p>';
		}
		
		if ($userName == '') {
			$error = $error . '<p>Username is empty</p>';
		}
		
		if ($password == '') {
			$error = $error . '<p>Password is empty</p>';
		}
		
		if ($confirmPassword == '') {
			$error = $error . '<p>You need to confirm your password</p>';
		}
		
		if ($email == '') {
			$error = $error . '<p>Email is empty</p>';
		}
		
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		  	$error = $error . '<p>Email is not valid</p>';
		}
		
		if (filter_var($confirmEmail, FILTER_VALIDATE_EMAIL) === false) {
		  	$error = $error . '<p>Confirm email is not valid</p>';
		}
		
		if ($confirmEmail == '') {
			$error = $error . '<p>You need to confirm your email</p>';
		}
		
		
		if ($password != $confirmPassword) {
			$error = $error . '<p>Paswords do no match</p>';
		}
		
		if ($email != $confirmEmail) {
			$error = $error . '<p>Emails do no match</p>';
		}
		
				
		// If there are no errors proceed to insert data
		if ($error == false) {
			// Encrypt the password
			$encryptedPassword = passwordEncrypt($password);
			
			// Get user IP address
			$lastIPAddress = $_SERVER["REMOTE_HOST"] ?: gethostbyaddr($_SERVER["REMOTE_ADDR"]);
		
			// pdo statement which sanitizes data for input
			
			$sql = 'INSERT INTO users (userName, password, email, firstName, lastName, dob, address1, address2, postcode, county, country, telephone, userLevel, lastIPAddress)
			VALUES (:userName, :password, :email, :firstName, :lastName, :dob, :address1, :address2, :postcode, :county, :country, :telephone, :userLevel, :lastIPAddress)';
			
			$stmt = $db->prepare($sql);
			$stmt->bindValue(':userName', $userName, PDO::PARAM_STR);
			$stmt->bindValue(':password', $encryptedPassword, PDO::PARAM_STR);
			$stmt->bindValue(':email', $email, PDO::PARAM_STR);
			$stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
			$stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
			$stmt->bindValue(':dob', $dob, PDO::PARAM_STR);
			$stmt->bindValue(':address1', $address1, PDO::PARAM_STR);
			$stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
			$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
			$stmt->bindValue(':county', $county, PDO::PARAM_STR);
			$stmt->bindValue(':country', $country, PDO::PARAM_STR);
			$stmt->bindValue(':telephone', $telephone, PDO::PARAM_STR);
			$stmt->bindValue(':userLevel', 'user', PDO::PARAM_STR);
			$stmt->bindValue(':lastIPAddress', $lastIPAddress, PDO::PARAM_STR);
			
			$stmt->execute();
			
			// Get the newly inserted id || NOT REQUIRED FOR NOW
			//$newId = $db->lastInsertId();
			header('Location: ' . SITE_ROOT . 'index.php?page=login&register=true');
		} 		
	}
?>
<?php
	include(PHP . 'getPage.php');
?>