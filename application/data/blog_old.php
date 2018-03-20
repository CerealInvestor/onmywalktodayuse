<?php
	$pageTitle = 'Onmywalktoday Blog';

	// Get the featured post
	 $stmt = $db->prepare('
						SELECT
						*
						FROM
						blog
						WHERE
						deleted = 0
						AND
						blogStatus = "live"
						AND
						blogFeatured = 1
						');
	
	//$stmt->bindValue(':deleted', $deleted, PDO::PARAM_STR);
	
	if($stmt->execute())
	{
		$blogFeatured = $stmt->fetch(PDO::FETCH_ASSOC);
	}
	else
	{
		$error = true;
	}
	
	// Get all the next posts
    $stmt = $db->prepare('
						SELECT
							*
						FROM
							blog
						WHERE
							deleted = 0
						AND
							blogStatus = "live"
						AND
							blogFeatured = 0
						');
	
	//$stmt->bindValue(':deleted', $deleted, PDO::PARAM_STR);
	
	if($stmt->execute())
	{
		$blogEntries = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	else
	{
		$error = true;
	}
?>