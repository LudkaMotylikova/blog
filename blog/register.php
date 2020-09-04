<?php

	// register form submitted
	if ( $_SERVER['REQUEST_METHOD'] === 'POST' )
	{
		$email = filter_input( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
		$password = $_POST['password'];
		$password_repeat = $_POST['repeat'];

		$register = $auth->register( $email, $password, $password_repeat );

		if ( $register['error'] ) {
			flash()->error( $register['message'] );
		}
		else {
			flash()->success('Welcome! Now enter the same into a new form!');
			redirect('/login');
		}
	}

	include_once "_partials/header.php";

?>

	<form method="post" action="" class="box box-auth">
		<h2 class="box-auth-heading">
			Register
		</h2>

		<input type="text" value="<?= $_POST['email'] ?: '' ?>" class="form-control" name="email" placeholder="Email Address" required autofocus>
		<input type="password" class="form-control" name="password" placeholder="Password" required>
		<input type="password" class="form-control" name="repeat" placeholder="Password again" required>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>

		<p class="alt-action text-center">
			or <a href="<?= BASE_URL ?>/login">come inside</a>
		</p>
	</form>

<?php include_once "_partials/footer.php" ?>
