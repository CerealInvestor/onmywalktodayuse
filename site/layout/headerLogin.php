<!-- Check to see if the session logged in is set, if it is then we show account options, if not show the login -->
<?php if (isset($_SESSION['loggedIn'])) { ?>
	<div id="headerAccount">
		<ul>
			<!-- if the users login level is admin then we can show additional options to the user -->
			<?php if (isset($_SESSION['userLevel']) && $_SESSION['userLevel'] == 'admin') { ?>
				<li><a href="<?php echo SITE_ROOT; ?>?page=cms">cms</a></li>
			<?php } ?>
			<li><a href="<?php echo SITE_ROOT; ?>?page=myaccount">my account</a></li>
			<li><a href="<?php echo SITE_ROOT; ?>?page=logout">logout</a></li>
		</ul>
	</div>
<?php } else { ?>
	<div id="headerLogin">
		<p><a href="<?php echo SITE_ROOT; ?>?page=register">register an account</a></p>
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?page=login" method="post">
			<div class="formBox">
				<label for="userName">username</label>
				<input type="text" name="userName" />
			</div>
			<div class="formBox">
				<label for="password">password</label>
				<input type="password" name="password" />
			</div>
			<div class="formBox">
				<input type="submit" value="Go" />
			</div>
		</form>
	</div>
<?php } ?>

<!--
used to debug which session variables are set
<div id="phpCode">
	<?php //var_dump($_SESSION); ?>
</div>-->
