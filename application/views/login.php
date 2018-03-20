<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<h1><?php echo $pageTitle; ?></h1>
		<?php echo $pageContent; ?>
		<?php if (isset($register) && $register == true){  ?>
			<div class="msgBox">
				<?php echo $msg; ?>
			</div>
		<?php } ?>
		
		<!-- Check to see if the error exists and is not equal to false, if it is fale we do not need to show the error box -->
		<?php if (isset($error) && $error != false){  ?>
			<div class="msgErrorBox">
				<?php echo $error; ?>
			</div>
		<?php } ?>
		<div id="loginBox">
			<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?page=login" method="post">
				<p>
					<label for="userName">Username</label>
					<input type="text" name="userName" />
				</p>
				<p>
					<label for="password">Password</label>
					<input type="password" name="password" />
				</p>
				<p>
					<input type="submit" value="Login" />
				</p>
			</form>
		</div>
	</div>
	<div class="clear">&nbsp;</div>
</div>