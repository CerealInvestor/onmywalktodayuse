<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left" style="width: 740px;">
		<?php if (isset($error) && $error == true){  ?>
			<h1>Content List</h1>
			<div class="msgErrorBox">
				<?php echo $msg; ?>
			</div>
		<?php } else { ?>
			<div class="blogFeatured">
				<?php if (isset($content)) : ?>
					<?php foreach ($content as $row) : ?>
						<?php if($content[0]['featured'] == 1) : ?>
							
								<img src="<?php echo UPLOADS . $row['fileName']; ?>" />
								
								<h1>Featured Post</h1>
								<h2><?php echo $content[0]['name']; ?></h2>
								<p>taken on <?php echo date('d/m/Y', strtotime($row['fileDate'])); ?> by <?php echo $row['userid']; ?></p>
								<?php echo $content[0]['description']; ?>
							
						<?php endif; ?>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php } ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>
<?php if (isset($content)) : ?>
	<?php foreach ($content as $row) : ?>
		<?php if($content[0]['featured'] < 1) : ?>
			<div class="blogEntry">
			   <div class="blogPost">
				   <img src="<?php echo UPLOADS . $row['fileName']; ?>" style="width: 400px;" />
	
					<h2><?php echo $content[0]['name']; ?></h2>
					<p>taken on <?php echo date('d/m/Y', strtotime($row['fileDate'])); ?> by <?php echo $row['userid']; ?></p>
					<?php echo $content[0]['description']; ?>
				   <div class="clear">&nbsp;</div>
			   </div>
		   </div>
		<?php endif; ?>
	<?php endforeach; ?>
<?php endif; ?>