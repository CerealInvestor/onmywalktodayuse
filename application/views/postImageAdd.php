<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<div class="backButton"><a href="<?php echo SITE_ROOT; ?>?page=blogAdmin&postid=<?php  echo $_GET['postid']; ?>">back</a></div>
		<h1>Upload File</h1>
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
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?page=blogAdmin&action=addImage&postid=<?php echo $_GET['postid']; ?>" method="post" enctype="multipart/form-data">
				<p><input type="file" name="file" /></p>
				<input type="hidden" name="postid" value="<?php echo $_GET['postid']; ?>" />
				<input type="hidden" name="addImage" value="true" />
				<p class="btnSubmit">
					<input type="submit" value="Upload" />
				</p>
			</form>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>