<?php 
	// Check only an admin can see this page
	loggedIn();
	
	$error = false;
	$msg = '';
	
	// check that a contentid is set before we can do anything here
	if (isset($_GET['contentid'])) {
	
		$contentid = stripslashes(trim($_GET['contentid']));
		
		if (isset($_GET['action'])) {
			$action = stripslashes(trim($_GET['action']));
		}
		
		$userid = $_SESSION['userId'];
	
		if ($action == 'publish' || $action == 'draft') {
			// Set the action to a variable
			$action = $action;
			
			// Check that the list exists in the database
			if (checkIfExists('contentid', $contentid, 'contentList', $db)) {
				
				// Check that the list is accessible by the current user requesting to publish
				if (checkUserContentList($contentid, $userid, $db)) {
					// check which action needs to be applied to content list
					switch ($action) {
						case 'publish' :
							$publishVar = 1;
						break;
						case 'draft' :
							$publishVar = 0;
						break;
					}
					
					// Update the coument list to be published or not
					$stmt = $db->prepare('UPDATE contentList SET published = ' . $publishVar . ' WHERE contentid = :contentid');
					$stmt->bindValue(':contentid', $contentid, PDO::PARAM_INT);
					
					if ($stmt->execute()) {
						header('Location: ' . SITE_ROOT . 'index.php?page=documentlist');
					}
				} 
			} else {
				$error = true;
				$msg = '';
			}
		} else {
			$error = true;
			$msg = 'content id is not available';
		}
	}
?>