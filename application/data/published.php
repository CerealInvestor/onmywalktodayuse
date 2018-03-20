<?php 
	// get the content list id
	// set error vars
	// check it exists
	// if contentlist exists see if the user has clicked download
	// check if public, if it is anyone can view else need to login
	// if private check that the user logged in is the owner of the list or has access
	// if error variable set display error
	$errror = false;
	$pageTitle = 'Published Document List';
		
	if (isset($_GET['download']) && $_GET['download'] == 'true' && stripslashes(trim($_GET['download'])) && isset($_GET['fileid'])) {
		$fileid = stripslashes(trim($_GET['fileid']));
		
		if (checkIfExists('fileid', $fileid, 'contentFiles', $db)) {
			$fileName = stripslashes(trim($_GET['fileName']));
			header('Location: ' . USER_DOWNLOADS . $fileName);
		} else {
			$error = true;
			$msg = 'File does not exist';
		}
	}
	
	$stmt = $db->prepare('
		SELECT 
			cl.name,
			cl.description,
			cl.featured,
			cf.*
		FROM 
			contentList as cl
		JOIN
			contentFiles as cf
		ON
			cl.contentid = cf.contentid
		WHERE 
			cl.published = 1
		AND
			cl.deleted = 0
		AND
			cf.deleted = 0
		ORDER BY
			cl.featured DESC
	');

	// Removed from SQL
	//cl.contentid = :contentid
	//AND
	
	// [MOD] we want to get all lists not just one
	//$stmt->bindValue(':contentid', $contentid);
	$stmt->execute();
	
	$numRows = $stmt->rowCount();
	
	if ($numRows > 0) {
		$content = $stmt->fetchAll();
		
		// Create an array which we loop through to set up our data nicely to be used in view
		//$content = array();
		
		$i = 0;
		while($row = $stmt->fetch()) {
			if ($i == 0) {
				$content['name'] = $row['name'];
				$content['description'] = $row['description'];
				$content['featured'] = $row['featured'];
				
				// Set the pageTitle to the document list
				$pageTitle = $content['name'];

			} else {
				$content['data'] = $row;
			}
			$i++;
		}
		
		// colCount is used for the columns in the view to give it a certiain class
		$colCount = 0;
	} else {
		$error = true;
		$msg = 'Content list has not been published';
	}
	
?>