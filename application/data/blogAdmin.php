<?php 
	loggedIn();
	
	include(PHP . 'getPage.php');
	
	if (isset( $_POST['blogAddPost'] )) {
		/*
			create a content list, $_POST['addContentList'] is a hidden value sent with the add content list form
		*/
		
		$postTitle = stripslashes(trim($_POST['postTitle']));
		$postContent = stripslashes(trim($_POST['postContent']));
		$postDate = date("Y-m-d H:i:s");
		
		// Prepare the mysql update statement with all the content
		$stmt = $db->prepare('INSERT INTO blog (postTitle, postContent, postDate, postAuthor) VALUES (:postTitle, :postContent, :postDate, :postAuthor)');
		$stmt->bindValue(':postTitle', $postTitle, PDO::PARAM_STR);
		$stmt->bindValue(':postContent', $postContent, PDO::PARAM_STR);
		$stmt->bindValue(':postDate', $postDate, PDO::PARAM_STR);
		$stmt->bindValue(':postAuthor', 1, PDO::PARAM_INT);
		
		// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
		// or if the query failed we can display that there was a problem.
		if($stmt->execute()){
			$postid = $db->lastInsertId();

			header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&contentid=' . $postid . '&update=true');
		} else {
			header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&action=add&error=true');
		}
	} else if (isset($_POST['updatePost'])) {
	/*
		update a content list $_POST['addDocumentFile'] is a hidden value sent with the upload file form
	*/

		// Get all posted data and store in variables
		// $pageId needs to be sent over in a hiddden input from the update form so that we can update the correct page
		$postid = stripslashes(trim($_POST['postid']));
		$postTitle = stripslashes(trim($_POST['postTitle']));
		$postContent = stripslashes(trim($_POST['postContent']));
		
		// Prepare the mysql update statement with all the content
		$stmt = $db->prepare('UPDATE blog SET postTitle = :postTitle, postContent = :postContent WHERE postid = :postid');
		$stmt->bindValue(':postTitle', $postTitle, PDO::PARAM_STR);
		$stmt->bindValue(':postContent', $postContent, PDO::PARAM_STR);
		$stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
		
		// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
		// or if the query failed we can display that there was a problem.
		if($stmt->execute()){
			header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&postid=' . $postid . '&update=true');
		} else {
			header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&error=true&postid=' . $postid);
		}
		
	} else if (isset($_POST['addImage']) && isset($_POST['postid'])) {
		
		/*
			upload a post image file $_POST['addImage'] is a hidden value sent with the upload file form
		*/
		
		// In case of an error instead of redirectng we just change the pageView and which will keep the $error and $msg ariable avaliable for use in the view
		$pageView = 'postImageAdd';
		
		$error = false;
		$msg = false;

		// Get the contentid which the file is linked to stored into a variable
		$postid = stripslashes(trim($_POST['postid']));
		
		// Store all the file details into an array
		$file = $_FILES['file'];
		
		// Get file data for the database		
		$fileName = $postid . '_' . str_replace(' ', '_', (basename($file['name'])));
		$fileSize = $file['size'];
		$fileType = $file['type'];
		$fileDate = date("Y-m-d H:i:s");
		
		//print_r($file);

		if ($file['error'] > 0) {
			$error = true;
			$msg = 'Error: ' . $file['error'];
		} else {
			// Check the userid which we store in the database so we can check if the correct user is editing the file in future
			if (file_exists(UPLOADS . $fileName)) {
				$error = true;
				$msg = 'File already exists';
			
			} else {
				// move the tmp file and see i
				if (move_uploaded_file($file['tmp_name'], UPLOADS . $fileName)) {
					// Prepare the mysql update statement with all the content
					$stmt = $db->prepare('INSERT INTO contentFiles (fileName, fileSize, fileType, contentid, fileDate) VALUES (:fileName, :fileSize, :fileType, :contentid, :fileDate)');
					$stmt->bindValue(':fileName', $fileName, PDO::PARAM_STR);
					$stmt->bindValue(':fileSize', $fileSize, PDO::PARAM_INT);
					$stmt->bindValue(':fileType', $fileType, PDO::PARAM_STR);
					$stmt->bindValue(':contentid', $postid, PDO::PARAM_INT);
					$stmt->bindValue(':fileDate', $fileDate, PDO::PARAM_STR);
					
					// Execute the update query, if it is successful we redirect with a $_GET variable we can call use to display a success message
					// or if the query failed we can display that there was a problem.
					if($stmt->execute()){
						header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&postid=' . $postid . '&update=true');
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
		
		
		
		
		
	} else if (isset($_GET['page']) && $_GET['page'] == 'blogAdmin' && isset($_GET['postid']) && !isset($_GET['action'])) {	
		
		/*
			The next else display the content list editing page which has the content list title and description along with a list of files added
		*/
		
		// Set the GET pageId into a variable
		// set the page view which determines the view we show in the controller
		$postid = stripslashes(trim($_GET['postid']));
		$pageView = 'postEdit';
		
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
		
		// Using the contentFiles table we dont need to change everything in the blog just make contentid = to postid
		$stmt = $db->prepare('SELECT * FROM contentFiles WHERE contentid = :postid AND deleted < 1 ORDER BY fileDate DESC');
		$stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
	
		$stmt->execute();
	
		$postImages = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
		// Get the post variables
		$stmt = $db->prepare('SELECT * FROM blog WHERE postid = :postid');
		$stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
		$stmt->execute();
		
		// This is returned to the view
		$post = $stmt->fetch(PDO::FETCH_ASSOC);
		
		$colCount = 0;


		
	} else if (isset($_GET['action']) && $_GET['action'] == 'deleteImage' && isset($_GET['postid']) && isset($_GET['fileid']) && stripslashes(trim($_GET['action']))) {
	/*
		Delete a file from a content list
	*/
		$postid = stripslashes(trim($_GET['postid']));
		$fileid = stripslashes(trim($_GET['fileid']));
		
		/*
			We need to select the fileid from the database
		*/
		$stmt = $db->prepare('SELECT fileid, fileName FROM contentFiles WHERE contentid = :postid AND fileid = :fileid');
		$stmt->bindValue(':postid', $postid, PDO::PARAM_STR);
		$stmt->bindValue(':fileid', $fileid, PDO::PARAM_STR);
		
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
					header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&postid=' . $postid . '&update=true');
				} else {
					header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&postid=' . $postid . '&error=updatefile');
				}
			} else {
				/* user is trying to delet a file that is not theirs */
				header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&postid=' . $postid . '&error=userfile');
			}
		} else {
			/* user is trying to delet a file that is not theirs */
			header('Location: ' . SITE_ROOT . 'index.php?page=blogAdmin&postid=' . $postid . '&error=userfile');
		}
		
	
	} else if (isset($_GET['action']) && $_GET['action'] == 'addImage' && isset($_GET['postid'])) {
		/*
			include the view to upload files to a document list
		*/
		$pageView = 'postImageAdd';
	
	} else {
		/*
			Include the view to list the document lists which have been added
		*/
		
		// if no querystring values are set we revert back to the  cms page list view
		$pageView = 'blogAdmin';
	
		// select the document lists for the current user and order by date 
		$stmt = $db->prepare('SELECT * FROM blog WHERE deleted = 0 ORDER BY postDate DESC');
		
		$stmt->execute();
		
		$documentList = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		$colCount = 0;
	}
?>