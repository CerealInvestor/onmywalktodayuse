<?php
	$pageTitle = 'OnMyWalkToday.co.uk';
	$content = 'Home page';
	
	$newarray = array('test1', 'test2', 'test3');
	
	$error = false;
	$deleted = 0;
	
	$stmt = $db->prepare('
						SELECT
							*
						FROM
							blog
						WHERE
							deleted = :deleted
						AND
							postStatus = "live"
						');
	
	$stmt->bindValue(':deleted', $deleted, PDO::PARAM_STR);
	
	if($stmt->execute())
	{
		$blogEntries = $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	else
	{
		$error = true;
	}
	
	
	
?>