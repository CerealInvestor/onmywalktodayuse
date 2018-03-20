<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left" style="width: 740px;">
    	<?php
            if($blogEntries) :
				foreach($blogEntries as $featured) :
					echo $featured['postFeatured'] .'<br />';
						if($featured['postFeatured'] == 1) :
        ?>
						<div class="blogFeatured">
			                <img src="<?php echo UPLOADS; ?>dunorland.jpg" />
			                <h1>Featured Post</h1>
			                <h2><?php echo $featured['postTitle']; ?></h2>
			                <p>taken on <?php echo date('d/m/Y', strtotime($featured['postDate'])); ?> by <?php echo $featured['postAuthor']; ?></p>
			                <?php echo $featured['postContent']; ?>
			            </div>			           
        <?php
					endif;
	        	endforeach;
            else :
                ?>
                <div class="blogError">
            No entries found...
        </div>
                <?php
            endif;
        ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>
<?php
    if($blogEntries) :
		foreach($blogEntries as $postEntry	) :
			echo $featured['postFeatured'] .'<br />';
				if($featured['postFeatured'] < 1) :
?>
				<div class="blogEntry">
	                <div class="blogPost">
	                    <img src="<?php echo UPLOADS; ?>noimage.jpg" />
	                    <h2><?php echo $postEntry['postTitle']; ?></h2>
	                    <?php echo $postEntry['postContent']; ?>
	                    <div class="blogReadMore">
	                        <a href="">read more</a>
	                    </div>
	                    <div class="clear">&nbsp;</div>
	                </div>
	            </div>		           
<?php
			endif;
    	endforeach;
    else :
        ?>
        <div class="blogError">
    No entries found...
</div>
        <?php
    endif;
?>