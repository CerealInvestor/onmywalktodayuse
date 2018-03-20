<?php 
	include(PHP . 'getPage.php');
	
	// create an object so that we can shorten the way we refer to the users data in the view
	$user = (object)$_SESSION['loggedInUserData'];
	
	if(isset($_GET['error']) && $_GET['error'] == 'true' && stripslashes(trim($_GET['error']))) {
		$error = true;
		$msg = 'Something went wrong.';
	}
	
	// If the update is successful we set the update variable to true and set a message which is used in the view
	if(isset($_GET['update']) && $_GET['update'] == 'true' && stripslashes(trim($_GET['update']))) {
		$update = true;
		$msg = 'Successfully updated';
	}
	
	// Update user details if the form has been submitted
	if ($_POST) {
		// Unset the error session which is set to pass the error over when the form is submitted if there is an error
		$error = false;
		
		$userId = stripslashes(trim($_POST['userId']));
		$userName = stripslashes(trim($_POST['userName']));
		
		$firstName = stripslashes(trim($_POST['firstName']));
		$lastName = stripslashes(trim($_POST['lastName']));
		$dob = stripslashes(trim($_POST['dob']));
		
		$address1 = stripslashes(trim($_POST['address1']));
		$address2 = stripslashes(trim($_POST['address2']));
		$postcode = stripslashes(trim($_POST['postcode']));
		$county = stripslashes(trim($_POST['county']));
		$country = stripslashes(trim($_POST['country']));
		$telephone = stripslashes(trim($_POST['telephone']));
		
		// Prepare the mysql update statement with all the content
		$stmt = $db->prepare('
			UPDATE users SET 
				firstName = :firstName, 
				lastName = :lastName,
				dob = :dob,
				address1 = :address1,
				address2 = :address2,
				postcode = :postcode,
				county = :county,
				country = :country,
				telephone = :telephone
			 WHERE userId = :userId');
			 
		$stmt->bindValue(':firstName', $firstName, PDO::PARAM_STR);
		$stmt->bindValue(':lastName', $lastName, PDO::PARAM_STR);
		$stmt->bindValue(':dob', $dob, PDO::PARAM_STR);
		$stmt->bindValue(':address1', $address1, PDO::PARAM_STR);
		$stmt->bindValue(':address2', $address2, PDO::PARAM_STR);
		$stmt->bindValue(':postcode', $postcode, PDO::PARAM_STR);
		$stmt->bindValue(':county', $county, PDO::PARAM_STR);
		$stmt->bindValue(':country', $country, PDO::PARAM_STR);
		$stmt->bindValue(':telephone', $telephone, PDO::PARAM_STR);
		$stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
		
		// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
		// or if the query failed we can display that there was a problem.
		if($stmt->execute()){
		
			// As the user details page uses session variables to fill out the editable input boxes we need to update the current session so that
			// the fields will show the current correct information pulled from the database and updated for their session
			storeSessionLogin($userName, $db, $userId);
		
			header('Location: ' . SITE_ROOT . 'index.php?page=userdetails&update=true');
		} else {
			header('Location: ' . SITE_ROOT . 'index.php?page=userdetails&error=true');
		}
		
	}
	
?>