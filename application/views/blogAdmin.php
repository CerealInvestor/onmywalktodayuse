<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content adminContent">
		<div class="backButton">
			<a href="<?php echo SITE_ROOT; ?>?page=blog&action=blogAddPost">add Post</a> | 
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
							<?php if ($item['postStatus'] == 'live') : ?>
								<a href="<?php echo SITE_ROOT; ?>?page=blogAdmin&action=draft&postid=<?php echo $item['postid']; ?>">depublish</a> 
							<?php else : ?>
								<a href="<?php echo SITE_ROOT; ?>?page=blogAdmin&action=publish&postid=<?php echo $item['postid']; ?>">click to publish</a>
							<?php endif; ?> 
							|
							<a href="<?php echo SITE_ROOT; ?>?page=blogAdmin&postid=<?php echo $item['postid']; ?>">edit</a>
						</div>
						<?php echo $item['postTitle']; ?>
					</div>
					<?php $colCount++; ?>
			<?php endforeach; ?>
		<?php else : ?>
			<p class="centre">No posts have been added</p>
		<?php endif; ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>