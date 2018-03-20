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
					<input type="text" name="contentName" />
				</p>
				<p>
					<label for="contentDescription">Description</label>
					<textarea name="contentDescription"></textarea>
				</p>
				<!-- [MOD] NOT REQUIRED as a contentid has not been created yet -->
				<!--<input type="hidden" name="contentid" value="<?php //echo $contentid ?>" />-->
				<input type="hidden" name="addContentList" value="true" />
				<p class="btnSubmit">
					<input type="submit" value="Add" />
				</p>
			</form>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>