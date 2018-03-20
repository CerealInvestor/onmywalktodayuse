<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left" style="width: 680px;">
		<h1><?php echo $pageTitle; ?></h1>
		<?php echo $pageContent; ?>
		<div class="userAccountBoxes">
			<a href="<?php echo SITE_ROOT; ?>?page=blogAdmin">Blogs</a>
			<a href="<?php echo SITE_ROOT; ?>?page=userdetails">User Details</a>
			<a href="<?php echo SITE_ROOT; ?>?page=documentlist">Documents</a>
			<!--
				To be included in phase 2
				<a href="<?php echo SITE_ROOT; ?>?page=gallerylist">Photo Galleries</a>
			-->
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>