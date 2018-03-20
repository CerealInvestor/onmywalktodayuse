<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<div class="backButton">
			<a href="<?php echo SITE_ROOT; ?>?page=myaccount">back</a>
		</div>
		<h1>CMS Page List</h1>
		<div class="cmsContainer">
			<?php foreach ($content as $row) : ?>
				<?php 
				if ($colCount == 1) {
					$colCount = -1;
					$colClass = 'white';
				} else {
					$colClass = 'blue';
				}
				?>
				<div class="listRow <?php echo $colClass; ?>">
					<div class="listCol"><a href="<?php echo SITE_ROOT; ?>?page=cms&pageId=<?php echo $row['pageId']; ?>">edit</a></div>
					<?php echo $row['pageTitle']; ?>
				</div>
				<?php $colCount++; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>