<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left" style="width: 740px;">
        <?php
            if($blogFeatured) {
        ?>
            <div class="blogFeatured">
                <img src="<?php echo UPLOADS; ?>dunorland.jpg" />
                <h1>Featured Post</h1>
                <h2><?php echo $blogFeatured['blogTitle']; ?></h2>
                <p>taken on <?php echo date('d/m/Y', strtotime($blogFeatured['blogDate'])); ?> by <?php echo $blogFeatured['blogAuthor']; ?></p>
                <?php echo $blogFeatured['blogContent']; ?>
            </div>
        <?php
            }
            else {
                ?>
                <div class="blogError">
            No entries found...
        </div>
                <?php
            }
        ?>
	</div>
	<div class="clear">&nbsp;</div>
</div>
<?php
    if($blogEntries)
    {
        foreach($blogEntries as $blogEntry) {
?>
            <div class="blogEntry">
                <div class="blogPost">
                    <img src="<?php echo UPLOADS; ?>noimage.jpg" />
                    <h2><?php echo $blogEntry['blogTitle']; ?></h2>
                    <?php echo $blogEntry['blogContent']; ?>
                    <div class="blogReadMore">
                        <a href="">read more</a>
                    </div>
                    <div class="clear">&nbsp;</div>
                </div>
            </div>
<?php
        }
    }
    else
    {
?>
        <div class="blogError">
            No entries found...
        </div>
<?php
    }
?>