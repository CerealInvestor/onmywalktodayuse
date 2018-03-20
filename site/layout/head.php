<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $pageTitle; ?></title>
		<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>styles.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS; ?>layout.css" />
		
		<link type="text/css" href="<?php echo STYLES; ?>bottom.css" rel="stylesheet" />
		<script type="text/javascript" src="<?php echo JS; ?>jquery.js"></script>
        <script type="text/javascript" src="<?php echo LIB; ?>jquery.jcarousel.min.js"></script>
		<script type="text/javascript" src="<?php echo LIB; ?>jquery.pikachoose.min.js"></script>
		<script type="text/javascript" src="<?php echo LIB; ?>jquery.touchwipe.min.js"></script>
		<script language="javascript">
			$(document).ready(
				function (){
					$("#homeSlider").PikaChoose({carousel:true, autoPlay:false});
				});
		</script>
		
</head>
<body>