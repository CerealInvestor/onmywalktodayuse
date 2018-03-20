<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<div class="backButton"><a href="<?php echo SITE_ROOT; ?>?page=documentlist">back</a></div>
		<h1>Document List</h1>
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
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?page=documentlist&update=true" method="post">
				<p>
					<label for="contentName">Document List Name</label>
					<input type="text" name="contentName" value="<?php echo $contentList['name']; ?>" />
				</p>
				<p>
					<label for="contentDescription">Description</label>
					<textarea name="contentDescription"><?php echo $contentList['description']; ?></textarea>
				</p>
				<input type="hidden" name="updateContentList" value="true" />
				<input type="hidden" name="contentid" value="<?php echo $contentid ?>" />
				<p class="btnSubmit">
					<input type="submit" value="Update" />
				</p>
			</form>
		</div>
		
		<div class="cmsContainer">
			<div class="backButton">
				<a href="<?php echo SITE_ROOT; ?>?page=documentlist&action=addDocumentFile&contentid=<?php echo $contentid; ?>">upload file</a>
			</div>
			<?php foreach ($documentFiles as $row) : ?>
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
						<a href="<?php echo SITE_ROOT; ?>?page=documentlist&action=deleteDocument&contentid=<?php echo $contentid; ?>&fileid=<?php echo $row['fileid']; ?>">delete</a>
					</div>
					<?php echo $row['fileName']; ?>
				</div>
				<?php $colCount++; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>