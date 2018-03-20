<?php
	$pageTitle = 'Onmywalktoday Blog';

	// Get the featured post
	 $stmt = $db->prepare('
						SELECT
							bl.postid, bl.postTitle, cf.fileName
						FROM
							blog as bl,
							contentfiles as cf
						WHERE
							cf.contentid = bl.postid
						AND
							bl.deleted = 0
						AND
							bl.postStatus = "live"
						ORDER BY
							bl.postDate DESC
						');
	
	//$stmt->bindValue(':deleted', $deleted, PDO::PARAM_STR);
	
	if($stmt->execute())
	{
		$content = array();
		
		$posts = $stmt->fetchAll();
		
	
	//	print_r($posts);
		
		
		$firstOfMany = 1;
		
		$prevPostid = 0;
		foreach( $posts as $item ) {
			$postid = $item['postid'];
			$prevPostid = $item['postid'];
			
			echo 'prevPostId: ' . $prevPostid . '<br />';
			echo 'Postid: ' . $postid;
			echo '<br />';
			
			if( $prevPostid != $postid ) {
				$content[$postid]['postTitle'] = $item['postTitle'];
			}
			
			$content[$postid]['fileName'] = $item['fileName'];
		} 
		
		echo '<pre id="phpCode">';
			print_r( $content );
		echo '</pre>';
	}
	else
	{
		$error = true;
	}
?>