<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<div class="backButton">
			<a href="<?php echo SITE_ROOT; ?>?page=documentlist&action=addDocumentList">add list</a> | 
			<a href="<?php echo SITE_ROOT; ?>?page=myaccount">back</a>
		</div>
		<h1><?php echo $pageTitle; ?></h1>
		<?php echo $pageContent; ?>
		
		<?php if ($documentList) : ?>
			<?php foreach ($documentList as $item) : ?>
				<?php 
					if ($colCount == 1) {
						$colCount = -1;
						$colClass = 'white';
					} else {
						$colClass = 'blue';
					}
				?>
					<div class="listRow <?php echo $colClass; ?>">
						<div class="listCol">
							<?php if ($item['published'] == 1) : ?>
								<span class="red">
									URL: <?php echo SITE_URL; ?>?page=published&contentid=<?php echo $item['contentid']; ?>
								</span>
								 | 
								<a href="<?php echo SITE_ROOT; ?>?page=published&contentid=<?php echo $item['contentid']; ?>">view published</a> | 
								<a href="<?php echo SITE_ROOT; ?>?page=documentpublish&action=draft&contentid=<?php echo $item['contentid']; ?>">depublish</a> 
							<?php else : ?>
								<a href="<?php echo SITE_ROOT; ?>?page=documentpublish&action=publish&contentid=<?php echo $item['contentid']; ?>">click to publish</a>
							<?php endif; ?> 
							|
							<a href="<?php echo SITE_ROOT; ?>?page=documentlist&contentid=<?php echo $item['contentid']; ?>">edit</a>
						</div>
						<?php echo $item['name']; ?>
					</div>
					<?php $colCount++; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<p class="centre">No list have been added</p>
		<?php endif; ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>