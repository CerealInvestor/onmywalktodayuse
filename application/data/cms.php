<?php 
	// Check only an admin can see this page
	loggedIn('admin');
	
	$pageTitle = 'CMS Page list';
	
	// if the cms edit form has been posted
	if($_POST) {
	
		// Get all posted data and store in variables
		// $pageId needs to be sent over in a hiddden input from the update form so that we can update the correct page
		$pageId = stripslashes(trim($_POST['pageId']));
		$pageTitle = stripslashes(trim($_POST['pageTitle']));
		$pageContent = stripslashes(trim($_POST['pageContent']));
		
		// Small debug to check all variables have the correct variables
		//echo $pageTitle . '<br />' . $pageContent . '<br />' . $pageId;
		//exit;
		
		// Prepare the mysql update statement with all the content
		$stmt = $db->prepare('UPDATE pages SET pageTitle = :pageTitle, pageContent = :pageContent WHERE pageId = :pageId');
		$stmt->bindValue(':pageTitle', $pageTitle, PDO::PARAM_STR);
		$stmt->bindValue(':pageContent', $pageContent, PDO::PARAM_STR);
		$stmt->bindValue(':pageId', $pageId, PDO::PARAM_INT);
		
		// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
		// or if the query failed we can display that there was a problem.
		if($stmt->execute()){
			header('Location: ' . SITE_ROOT . 'index.php?page=cms&update=true&pageId=' . $pageId);
		} else {
			header('Location: ' . SITE_ROOT . 'index.php?page=cms&error=true&pageId=' . $pageId);
		}
	} else if (isset($_GET['pageId']) && !empty($_GET['pageId'])) {	
		/*
			This else if determines whether a pageId is in the query string, if it is then we setup the data for the cms edit page
		*/
		
		// these variables are used to display messages in the view so we set them to false at first so none are displayed
		$error = false;
		$update = false;
		
		// Set the GET pageId into a variable
		// set the page view which determines the view we show in the controller
		$pageId = stripslashes(trim($_GET['pageId']));
		$pageView = 'cmsedit';
		
		// if an error has occured we set the variable to true and set the message which will be displayed in the view
		if(isset($_GET['error']) && $_GET['error'] == 'true' && stripslashes(trim($_GET['error']))) {
			$error = true;
			$msg = 'Something went wrong.';
		}
		
		// If the update is successful we set the update variable to true and set a message which is used in the view
		if(isset($_GET['update']) && $_GET['update'] == 'true' && stripslashes(trim($_GET['update']))) {
			$update = true;
			$msg = 'Successfully updated';
		}
		
		// Select the pageid and and title which will can display in a list,also select deleted so we can turn it on or off
		$stmt = $db->prepare('SELECT * FROM pages WHERE pageId = :pageId');
		$stmt->bindValue(':pageId', $pageId, PDO::PARAM_STR);
		$stmt->execute();
	
		$content = $stmt->fetch(PDO::FETCH_ASSOC);	
		
		$pageTitle = 'CMS Edit page: ' . $content['pageTitle'];
	} else {
		// if no querystrong values are set we revert back to the  cms page list view
		$pageView = 'cms';
	
		// Select the pageid and and title which will can display in a list,also select deleted so we can turn it on or off
		$stmt = $db->prepare('SELECT pageId, pageTitle, deleted FROM pages');
		$stmt->execute();
		
		// set all data in to a variable for use in the cms view which we will loop through
		$content = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$colCount = 0;
	}
?>