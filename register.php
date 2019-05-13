<?php
	include("includes/config.php");
	include("includes/classes/Account.php");
	include("includes/classes/Constants.php");

	$account = new Account($con);
	// $account->register();

	include("includes/handlers/register-handler.php");
	include("includes/handlers/login-handler.php");

	function getInputValue($name){
		if(isset($_POST[$name])){
			echo $_POST[$name];
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Slotify</title>
	<link rel="stylesheet" type="text/css" href="assets/css/register.css">
	<script type="text/javascript" src="assets/js/jquery-3.3.1.min.js"></script>
	<script type="text/javascript" src="assets/js/register.js"></script>
</head>
<body>

	<?php
		if(isset($_POST['registerButton'])){
			echo '
				<script type="text/javascript">
					$(document).ready(function(){
						$("#loginForm").hide();
						$("#registerForm").show();
					});
				</script>
			';
		}
		else{
			echo '
				<script type="text/javascript">
					$(document).ready(function(){
						$("#loginForm").show();
						$("#registerForm").hide();
					});
				</script>
			';
		}
	?>
	<div id="background">

		<div id="loginContainer">

			<div id="inputContainer">
				<form id="loginForm" action="" method="post">
					<h2>Login to your account</h2>
					<p>
						<?php echo $account->getError(Constants::$loginFailed); ?>
						<label for="loginUsername">Username</label>
						<input id="loginUsername" type="text" name="loginUsername" placeholder="e.g joshgato" value="<?php getInputValue('loginUsername') ?>" required>
					</p>
					<p>
						<label for="loginPassword">Password</label>
						<input id="loginPassword" type="password" name="loginPassword" placeholder="Your Password" required>
					</p>
					
					<button type="submit" name="loginButton">LOG IN</button>

					<div class="hasAccountText">
						<span id="hideLogin">Don't have an account yet? Signup here.</span>
					</div>
				</form> <!-- End  loginForm-->

				<form id="registerForm" action="" method="post">
					<h2>Create your free account</h2>
					<p>
						<?php echo $account->getError(Constants::$usernameCharacters); ?>
						<?php echo $account->getError(Constants::$usernameTaken); ?>
						<label for="username">Username</label>
						<input id="username" type="text" name="username" placeholder="e.g joshgato" value="<?php getInputValue('username') ?>" required>
					</p>
					<p>
						<?php echo $account->getError(Constants::$firstNameCharacters); ?>
						<label for="firstName">First name</label>
						<input id="firstName" type="text" name="firstName" placeholder="e.g Joshua" value="<?php getInputValue('firstName') ?>" required>
					</p>
					<p>
						<?php echo $account->getError(Constants::$lastNameCharacters); ?>
						<label for="lastName">Last name</label>
						<input id="lastName" type="text" name="lastName" placeholder="e.g Gato" value="<?php getInputValue('lastName') ?>" required>
					</p>
					<p>
						<?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$emailInvalid); ?>
						<?php echo $account->getError(Constants::$emailTaken); ?>
						<label for="email">Email</label>
						<input id="email" type="email" name="email" placeholder="e.g joshgato@gmail.com" value="<?php getInputValue('email') ?>" required>
					</p>
					<p>
						<label for="email2">Confirm email</label>
						<input id="email2" type="email" name="email2" placeholder="e.g joshgato@gmail.com" value="<?php getInputValue('email2') ?>" required>
					</p>
					<p>
						<?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
						<?php echo $account->getError(Constants::$passwordsNotAlphanumeric); ?>
						<?php echo $account->getError(Constants::$passwordCharacters); ?>
						<label for="password">Password</label>
						<input id="password" type="password" name="password" placeholder="Your Password" required>
					</p>
					<p>
						<label for="password2">Confirm Password</label>
						<input id="password2" type="password" name="password2" placeholder="Your Password" required>
					</p>			
					
					<button type="submit" name="registerButton">SIGN UP</button>

					<div class="hasAccountText">
						<span id="hideRegister">Already have an account? Log in here.</span>
					</div>
				</form> <!-- End registerForm -->
			</div> <!-- End inputContainer -->

			<div id="loginText">
				<h1>Get great music, right now</h1>
				<h2>Listen to loads of songs for free</h2>
				<ul>
					<li>Discover music you'll fall in love with</li>
					<li>Create your own playlist</li>
					<li>Follow artists to keep up to date</li>
				</ul>
			</div>

		</div> <!-- End loginContainer -->
	</div> <!-- End background -->
</body>
</html>