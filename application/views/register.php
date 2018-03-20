<div class="contentContainer">
	<?php include(LAYOUT . 'sideNav.php');  ?>
	
	<div class="content left">
		<h1><?php echo $pageTitle; ?></h1>
		<?php echo $pageContent; ?>
		
		<!-- Check to see if the error exists and is not equal to false, if it is fale we do not need to show the error box -->
		<?php if (isset($error) && $error != false){  ?>
			<div class="msgErrorBox">
				<?php echo $error; ?>
			</div>
		<?php } ?>
		
		<!-- User registration form -->
		<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>?page=register" method="post" id="registerForm">
			<p>
				<label for="userName">Username</label>
				<input type="text" name="userName" value="<?php (!empty($userName) ? $userName : ''); ?>" />
			</p>
			<p>
				<label for="password">Password</label>
				<input type="password" name="password" />
			</p>
			<p>
				<label for="confirmPassword">Confirm password</label>
				<input type="password" name="confirmPassword" />
			</p>
			<hr />
			<p>
				<label for="firstName">First Name</label>
				<input type="text" name="firstName" value="<?php echo (!empty($firstName) ? $firstName : ''); ?>" />
			</p>
			<p>
				<label for="lastName">Last name</label>
				<input type="text" name="lastName" value="<?php echo (!empty($lastName) ? $lastName : ''); ?>" />
			</p>
			<p>
				<label for="dob">DOB (dd/mm/yyyy)</label>
				<input type="text" name="dob" value="<?php echo (!empty($dob) ? $dob : ''); ?>" />
			</p>
			<p>
				<label for="email">Email</label>
				<input type="text" name="email" value="<?php echo (!empty($email) ? $email : ''); ?>" />
			</p>
			<p>
				<label for="confirmEmail">Confirm email</label>
				<input type="text" name="confirmEmail" value="<?php echo (!empty($confirmEmail) ? $confirmEmail : ''); ?>" />
			</p>
			<hr />
			<p>
				<label for="address1">Address 1</label>
				<input type="text" name="address1" value="<?php echo (!empty($address1) ? $address1 : ''); ?>" />
			</p>
			<p>
				<label for="address2">Address 2</label>
				<input type="text" name="address2" value="<?php echo (!empty($address2) ? $address2 : ''); ?>" />
			</p>
			<p>
				<label for="postcode">Postcode</label>
				<input type="text" name="postcode" value="<?php echo (!empty($postcode) ? $postcode : ''); ?>" />
			</p>
			<p>
				<label for="county">County</label>
				<input type="text" name="county" value="<?php echo (!empty($county) ? $county : ''); ?>" />
			</p>
			<p>
				<label for="country">Country</label>
				<input type="text" name="country" value="<?php echo (!empty($country) ? $country : ''); ?>" />
			</p>
			<p>
				<label for="telephone">Telephone</label>
				<input type="text" name="telephone" value="<?php echo (!empty($telephone) ? $telephone : ''); ?>" />
			</p>
			<hr />
			<p class="btnSubmit">
				<input type="submit" value="Register" />
			</p>
		</form>
	</div>
	<div class="clear">&nbsp;</div>
</div>