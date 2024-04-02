<?php
include_once("includes/config.php");
include_once("includes/classes/Account.php");
include_once("includes/classes/Constants.php");

$account = new Account($pdo);

include_once("includes/handlers/register-handler.php");
include_once("includes/handlers/login-handler.php");

function getInputValue($name)
{
    if (isset($_POST[$name])) {
        echo $_POST[$name];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome to Songify!</title>

	<link rel="stylesheet" href="assets/css/style.css">
	<script src="assets/js/libs/jquery.min.js"></script>
	<script src="assets/js/register.js"></script>
</head>
<body>

<?php
if (isset($_POST['registerButton'])) {
    echo '<script>
                    $(document).ready(function () {
                        $("#loginForm").hide();
                        $("#registerForm").show();
                    });
                </script>';
} else {
    echo '<script>
                    $(document).ready(function () {
                        $("#loginForm").show();
                        $("#registerForm").hide();
                    });
                </script>';
}
?>

<div id="background">
	<div id="loginContainer">
		<div id="inputContainer">
			<form id="loginForm" action="register.php" method="POST" novalidate>
				<h2 class="loginHeading">Login to your account</h2>
				<p>
                    <?php echo $account->getError(Constants::$loginFailed); ?>
					<label for="loginUsername">Username<span class="requiredText">*</span></label>
					<input id="loginUsername" name="loginUsername" type="text" placeholder="e.g. bartSimpson"
						   value="<?php getInputValue('loginUsername'); ?>" required>
				</p>
				<p>
					<label for="loginPassword">Password<span class="requiredText">*</span></label>
					<input id="loginPassword" name="loginPassword" type="password" placeholder="Your password"
						   required>
				</p>
				<button type="submit" name="loginButton">LOG IN</button>

				<div id="textLogin" class="hasAccountText">
					<span id="hideLogin">Don't have an account yet? Signup here</span>
				</div>
			</form>

			<form id="registerForm" action="register.php" method="POST" novalidate>
				<h2>Create your free account</h2>
				<p>
                    <?php echo $account->getError(Constants::$usernameCharacters); ?>
                    <?php echo $account->getError(Constants::$usernameTaken); ?>
					<label for="username">Username<span class="requiredText">*</span></label>
					<input id="username" name="username" type="text" placeholder="e.g. bartSimpson"
						   value="<?php getInputValue('username'); ?>">
				</p>
				<p>
                    <?php echo $account->getError(Constants::$firstNameCharacters); ?>
					<label for="firstName">First name<span class="requiredText">*</span></label>
					<input id="firstName" name="firstName" type="text" placeholder="e.g. Bart"
						   value="<?php getInputValue('firstName'); ?>">
				</p>
				<p>
                    <?php echo $account->getError(Constants::$lastNameCharacters); ?>
					<label for="lastName">Last name<span class="requiredText">*</span></label>
					<input id="lastName" name="lastName" type="text" placeholder="e.g. Simpson"
						   value="<?php getInputValue('lastName'); ?>">
				</p>
				<p>
                    <?php echo $account->getError(Constants::$emailInvalid); ?>
                    <?php echo $account->getError(Constants::$emailsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$emailTaken); ?>
					<label for="email">Email<span class="requiredText">*</span></label>
					<input id="email" name="email" type="text" placeholder="e.g. bart@gmail.com"
						   value="<?php getInputValue('email'); ?>">
				</p>
				<p>
					<label for="email2">Confirm email<span class="requiredText">*</span></label>
					<input id="email2" name="email2" type="email" placeholder="e.g. bart@gmail.com"
						   value="<?php getInputValue('email2'); ?>">
				</p>
				<p>
                    <?php echo $account->getError(Constants::$passwordsDoNotMatch); ?>
                    <?php echo $account->getError(Constants::$passwordNotAlphaNumeric); ?>
                    <?php echo $account->getError(Constants::$passwordCharacters); ?>
					<label for="password">Password<span class="requiredText">*</span></label>
					<input id="password" name="password" type="password" placeholder="Your password">
				</p>
				<p>
					<label for="password2">Confirm password<span class="requiredText">*</span></label>
					<input id="password2" name="password2" type="password" placeholder="Your password">
				</p>
				<button type="submit" name="registerButton">SIGN UP</button>

				<div id="textRegister" class="hasAccountText">
					<span id="hideRegister">Already have an account yet? Login here</span>
				</div>
			</form>
		</div>

		<div id="loginText">
			<h1>Get great music, right now</h1>
			<h2>Listen to loads of songs for free</h2>
			<ul>
				<li>Discover music you'll fall in love with</li>
				<li>Create your own playlists</li>
				<li>Follow artists to keep up to date</li>
			</ul>
			<div id="copyrightContainer">
				<p>&copy 2024 Songify | Milan Koirala</p>
			</div>
		</div>
	</div>
</div>
</body>
</html>

