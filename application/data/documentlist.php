<?php 
	loggedIn();
	
	include(PHP . 'getPage.php');
	
	if (isset($_POST['addContentList'])) {
		/*
			create a content list, $_POST['addContentList'] is a hidden value sent with the add content list form
		*/
		
		$contentName = stripslashes(trim($_POST['contentName']));
		$contentDescription = stripslashes(trim($_POST['contentDescription']));
		$contentDate = date("Y-m-d H:i:s");
		
		// Prepare the mysql update statement with all the content
		$stmt = $db->prepare('INSERT INTO contentList (name, description, dateAdded, contentType, userid) VALUES (:contentName, :contentDescription, :dateAdded, :contentType, :userid)');
		$stmt->bindValue(':contentName', $contentName, PDO::PARAM_STR);
		$stmt->bindValue(':contentDescription', $contentDescription, PDO::PARAM_STR);
		$stmt->bindValue(':dateAdded', $contentDate, PDO::PARAM_STR);
		$stmt->bindValue(':contentType', 'public', PDO::PARAM_STR);
		$stmt->bindValue(':userid', $_SESSION['userId'], PDO::PARAM_INT);
		
		// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
		// or if the query failed we can display that there was a problem.
		if($stmt->execute()){
			$contentid = $db->lastInsertId();

			header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&contentid=' . $contentid . '&update=true');
		} else {
			header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&action=add&error=true');
		}
	} else if (isset($_POST['updateContentList'])) {
	/*
		update a content list $_POST['addDocumentFile'] is a hidden value sent with the upload file form
	*/

		// Get all posted data and store in variables
		// $pageId needs to be sent over in a hiddden input from the update form so that we can update the correct page
		$contentid = stripslashes(trim($_POST['contentid']));
		$contentName = stripslashes(trim($_POST['contentName']));
		$contentDescription = stripslashes(trim($_POST['contentDescription']));
		
		// Prepare the mysql update statement with all the content
		$stmt = $db->prepare('UPDATE contentList SET name = :contentName, description = :contentDescription WHERE contentid = :contentid');
		$stmt->bindValue(':contentName', $contentName, PDO::PARAM_STR);
		$stmt->bindValue(':contentDescription', $contentDescription, PDO::PARAM_STR);
		$stmt->bindValue(':contentid', $contentid, PDO::PARAM_STR);
		
		// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
		// or if the query failed we can display that there was a problem.
		if($stmt->execute()){
			header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&contentid=' . $contentid . '&update=true');
		} else {
			header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&error=true&contentid=' . $contentid);
		}

	} else if (isset($_POST['addDocumentFile']) && isset($_POST['contentid'])) {
		/*
			upload a document file $_POST['addDocumentFile'] is a hidden value sent with the upload file form
		*/
		
		// In case of an error instead of redirectng we just change the pageView and which will keep the $error and $msg ariable avaliable for use in the view
		$pageView = 'documentfileAdd';
		
		$error = false;
		$msg = false;

		// Get the contentid which the file is linked to stored into a variable
		$contentid = stripslashes(trim($_POST['contentid']));
		
		// Store all the file details into an array
		$file = $_FILES['file'];
		
		$userid = $_SESSION['userId'];
		
		// Get file data for the database		
		$fileName = $userid . '_' . str_replace(' ', '_', (basename($file['name'])));
		$fileSize = $file['size'];
		$fileType = $file['type'];
		$fileDate = date("Y-m-d H:i:s");
		
		//print_r($file);

		if ($file['error'] > 0) {
			$error = true;
			$msg = 'Error: ' . $file['error'];
		} else {
			// Check the userid which we store in the database so we can check if the correct user is editing the file in future
			if (!isset($_SESSION['userId'])) {
				$error = true;
				$msg = 'Something went wrong with your session';
			} elseif (file_exists(UPLOADS . $fileName)) {
				$error = true;
				$msg = 'File already exists';
			
			} else {
				// move the tmp file and see i
				if (move_uploaded_file($file['tmp_name'], UPLOADS . $fileName)) {
					// Prepare the mysql update statement with all the content
					$stmt = $db->prepare('INSERT INTO contentFiles (fileName, fileSize, fileType, contentid, userid, fileDate) VALUES (:fileName, :fileSize, :fileType, :contentid, :userid, :fileDate)');
					$stmt->bindValue(':fileName', $fileName, PDO::PARAM_STR);
					$stmt->bindValue(':fileSize', $fileSize, PDO::PARAM_INT);
					$stmt->bindValue(':fileType', $fileType, PDO::PARAM_STR);
					$stmt->bindValue(':contentid', $contentid, PDO::PARAM_INT);
					$stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
					$stmt->bindValue(':fileDate', $fileDate, PDO::PARAM_STR);
					
					// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
					// or if the query failed we can display that there was a problem.
					if($stmt->execute()){
						header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&contentid=' . $contentid . '&update=true');
					} else {
						$error = true;
						$msg = 'Database error';
					}
				} else {
					$error = true;
					$msg = 'File file could not be moved';
				}
			}
		} 
	} else if (isset($_GET['page']) && $_GET['page'] == 'documentlist' && isset($_GET['contentid']) && !empty($_GET['contentid']) && !isset($_GET['action'])) {		
		/*
			The next else display the content list editing page which has the content list title and description along with a list of files added
		*/
		
		// Set the GET pageId into a variable
		// set the page view which determines the view we show in the controller
		$contentid = stripslashes(trim($_GET['contentid']));
		$pageView = 'documentlistEdit';
		
		// Cehck the correct user is viewing the content list
		checkUserContentList($contentid, $_SESSION['userId'], $db);
		
		// these variables are used to display messages in the view so we set them to false at first so none are displayed
		$error = false;
		$update = false;
		
		// If the update is successful we set the update variable to true and set a message which is used in the view
		if(isset($_GET['update']) && $_GET['update'] == 'true' && stripslashes(trim($_GET['update']))) {
			$update = true;
			$msg = 'Success';
		}
		
		// if an error has occured we set the variable to true and set the message which will be displayed in the view
		if (isset($_GET['error']) && stripslashes(trim($_GET['error']))) {
			$error = true;
			
			switch($_GET['error']){
				case 'userfile' :
					$msg = 'You do not have access to delete this file!'; 
				break;
				case 'true' :
					$msg = 'Something went wrong.';
				break;
				case 'updatefile' :
					$msg = 'DB Update failed';
				break;
			}
		}
		
		// jin statement which isnt really required so we have shortened it below
		/*$stmt = $db->prepare('
		SELECT 
			*
		 FROM 
		 	contentList as cl
		 LEFT JOIN
		 	contentFiles as cf
		 ON
		 	cl.contentid = cf.contentid
		 
		  WHERE cl.contentid = :contentid
		  ');
		  */
		  
		  
		
		$stmt = $db->prepare('SELECT * FROM contentFiles WHERE contentid = :contentid AND deleted < 1 ORDER BY fileDate DESC');
		$stmt->bindValue(':contentid', $contentid, PDO::PARAM_STR);
		//$stmt->bindValue(':userid', $userid, PDO::PARAM_INT);
		$stmt->execute();
	
		$documentFiles = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		
		$stmt = $db->prepare('SELECT * FROM contentList WHERE contentid = :contentid');
		$stmt->bindValue(':contentid', $contentid, PDO::PARAM_STR);
		$stmt->execute();
		
		$contentList = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$colCount = 0;
	} else if (isset($_GET['action']) && $_GET['action'] == 'deleteDocument' && isset($_GET['contentid']) && isset($_GET['fileid']) && stripslashes(trim($_GET['action']))) {
	/*
		Delete a file from a content list
	*/
		$contentid = stripslashes(trim($_GET['contentid']));
		$fileid = stripslashes(trim($_GET['fileid']));
		$userid = $_SESSION['userId'];
		
		/*
			We need to select the fileid from the database to check that the correct user is deleteing the file
		*/
		$stmt = $db->prepare('SELECT fileid, fileName FROM contentFiles WHERE contentid = :contentid AND fileid = :fileid AND userid = :userid');
		$stmt->bindValue(':contentid', $contentid, PDO::PARAM_STR);
		$stmt->bindValue(':fileid', $fileid, PDO::PARAM_STR);
		$stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
		
		// see if the file exists with the correct userid
		if ($stmt->execute()) {
			$rowCount = $stmt->rowCount();
			
			// If the row has been found then we can prepare to update the file to be set to deleted
			if ($rowCount > 0) {
				// Get the row we have selected from the database 
				$row = $stmt->fetch();
			
				$stmt = $db->prepare('UPDATE contentFiles SET deleted = 1 WHERE fileid = :fileid');
				$stmt->bindValue(':fileid', $fileid, PDO::PARAM_INT);
				
				// Get the filename so we can physically delete it
				$filePath = UPLOADS . $row['fileName'];
				
				// If the file exists then delete it
				if (file_exists($filePath)) {
					unlink($filePath);
				}
				
				// Update the file to deleted or redirect with error
				if ($stmt->execute()) {
					header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&contentid=' . $contentid . '&update=true');
				} else {
					header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&contentid=' . $contentid . '&error=updatefile');
				}
			} else {
				/* user is trying to delet a file that is not theirs */
				header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&contentid=' . $contentid . '&error=userfile');
			}
		} else {
			/* user is trying to delet a file that is not theirs */
			header('Location: ' . SITE_ROOT . 'index.php?page=documentlist&contentid=' . $contentid . '&error=userfile');
		}
	
	} else if (isset($_GET['action']) && $_GET['action'] == 'addDocumentList' && stripslashes(trim($_GET['action']))) {
		/*
			include the view to add the document list
		*/
		$pageView = 'documentListAdd';
	} else if (isset($_GET['action']) && $_GET['action'] == 'addDocumentFile' && isset($_GET['contentid']) && stripslashes(trim($_GET['action']))) {
		/*
			include the view to upload files to a document list
		*/
		$pageView = 'documentfileAdd';
	} else {
		/*
			Include the view to list the document lists which have been added
		*/
		
		// if no querystring values are set we revert back to the  cms page list view
		$pageView = 'documentlist';
	
		// select the document lists for the current user and order by date 
		$stmt = $db->prepare('SELECT * FROM contentList WHERE userId = :userId ORDER BY dateAdded DESC');
		$stmt->bindValue(':userId', $_SESSION['userId'], PDO::PARAM_STR);
		//$stmt->bindValue(':contentType', 'documentList', PDO::PARAM_STR);
		
		$stmt->execute();
		
		$documentList = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$colCount = 0;
	}
?>