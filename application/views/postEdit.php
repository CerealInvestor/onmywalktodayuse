<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<div class="backButton"><a href="<?php echo SITE_ROOT; ?>?page=blogAdmin">back</a></div>
		<h1>Edit Post</h1>
		<?php if (isset($error) && $error != false){  ?>
			<p>
				<div class="msgErrorBox">
					<?php echo $msg; ?>
				</div>
			</p>
		<?php } ?>
		
		<?php if (isset($update) && $update == true){  ?>
			<p>
				<div class="msgBox">
					<?php echo $msg; ?>
				</div>
			</p>
		<?php } ?>
		
		<div class="cmsContainer">
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?page=blogAdmin&update=true" method="post">
				<p>
					<label for="postTitle">Title</label>
					<input type="text" name="postTitle" value="<?php echo $post['postTitle']; ?>" />
				</p>
				<p>
					<label for="postContent">Content</label>
					<textarea name="postContent"><?php echo $post['postContent']; ?></textarea>
				</p>
				<input type="hidden" name="updatePost" value="true" />
				<input type="hidden" name="postid" value="<?php echo $postid ?>" />
				<p class="btnSubmit">
					<input type="submit" value="Update" />
				</p>
			</form>
		</div>
		
		<div class="cmsContainer">
			<div class="backButton">
				<a href="<?php echo SITE_ROOT; ?>?page=blogAdmin&action=addImage&postid=<?php echo $postid; ?>">upload image</a>
			</div>
			<?php foreach ($postImages as $row) : ?>
				<?php 
				if ($colCount == 1) {
					$colCount = -1;
					$colClass = 'white';
				} else {
					$colClass = 'blue';
				}
				?>
				<div class="listRow <?php echo $colClass; ?>" style="clear: both;">
					<div class="listCol">
						<a href="<?php echo SITE_ROOT; ?>?page=blogAdmin&action=deleteImage&postid=<?php echo $postid; ?>&fileid=<?php echo $row['fileid']; ?>">delete</a>
					</div>
					<?php echo $row['fileName']; ?>
				</div>
				<?php $colCount++; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>