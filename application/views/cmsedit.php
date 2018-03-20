<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<div class="backButton">
			<a href="<?php echo SITE_ROOT; ?>?page=cms">back</a>
		</div>

		<h1>CMS Edit page</h1>
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
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?page=cms&update=true" method="post">
				<p>
					<label for="pageTitle">Page Title</label>
					<input type="text" name="pageTitle" value="<?php echo $content['pageTitle']; ?>" />
				</p>
				<p>
					<label for="pageContent">Page Content</label>
					<textarea name="pageContent"><?php echo $content['pageContent']; ?></textarea>
				</p>
				<input type="hidden" name="pageId" value="<?php echo $pageId ?>" />
				<p class="btnSubmit">
					<input type="submit" value="Update" />
				</p>
			</form>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>