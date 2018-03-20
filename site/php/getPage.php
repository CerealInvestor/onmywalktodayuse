<?php
	// First we prepare our statement with PDO to stop any kind of injection using a placeholder ie :pageName
	// using bindValue we will set the the variable to fill :pageName will be $page which is set index.php
	// execute the query
	$stmt = $db->prepare('select * from pages where pageName = :pageName');
	$stmt->bindValue(':pageName', $page, PDO::PARAM_STR);
	$stmt->execute();
	
	// Fetch the roow in a associate array
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	
	// Check to see if the page has been found, if it hasnt then we redirect the user to the 404 page
	// else store the page variables
	if ($row < 1) {
		header('Location: ' . SITE_ROOT . '?page=404');
	} else {
		$pageTitle = $row['pageTitle'];
		$pageContent = $row['pageContent'];
	}
?>