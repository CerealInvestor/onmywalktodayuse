<?php 
	// Check only an admin can see this page
	loggedIn('admin');
	
	$pageid = stripslashes(trim($_GET['pageId']));
	
	if (!isset($pageid) {
		header('Location: ' . SITE_ROOT . '?page=cms');
	}
	
	// Select the pageid and and title which will can display in a list,also select deleted so we can turn it on or off
	$stmt = $db->prepare('SELECT * FROM pages WHERE pageId = :pageId');
	$stmt->BindValue(':pageId', $pageId, PDO::PARAM_STR);
	$stmt->execute();
	
	$pageList = $stmt->fetch(PDO::FETCH_ASSOC);
?>