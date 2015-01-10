<?php include ('views/includes/header.php'); ?>

<div class="row">
	<div class="small-12 small-centered medium-7 large-4 text-center columns">
		
		<?php
		// show potential errors / feedback (from login object)
		if (isset($login)) {
			if ($login->errors) {
				foreach ($login->errors as $error) {
					include 'views/includes/error.php';
				}
			}
			if ($login->messages) {
				foreach ($login->messages as $message) {
					include 'views/includes/message.php';
				}
			}
		}
		?>

		<form method="post" action="index.php" name="loginform">

			<input id="login_input_username" class="login_input" type="text" name="user_name" placeholder="Username" required />
			<input id="login_input_password" class="login_input" type="password" name="user_password" placeholder="Password" autocomplete="off" required />
			<input type="hidden" name="fingerprint" value="" />
			<input type="hidden" name="uagent" value="" />

			<button type="submit" name="login">Log in</button>
		</form>
	</div>
</div>

<?php include ('views/includes/footer.php'); ?>