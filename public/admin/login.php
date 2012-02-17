<?php
require_once("../../includes/initialize.php");


if ($session->is_logged_in()) {
	redirect_to("index.php");
}


if (isset($_POST['submit'])) {

	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	
	
	$found_user = User::authenticate($username, $password);
	
	if ($found_user) {
		$session->login($found_user);
		redirect_to("index.php");
	} else {
		$message = "username/password combination incorrect. ";
	}
} else {
	$username = "";
	$password = "";
}
?>
<html>
	<head>
		<title>Photo Gallery</title>
		<link href="../stylesheets/main.css" media="all" rel="stylesheet"
		tyle="text/css" />
	</head>
	<body>
		<div id="header">
			<h1>Photo Gallery</h1>
		</div>
		<div id="main">
			<h2>Staff Login</h2>
			<?php if(isset($message)) {
				echo output_message($message);
			} ?>
			
			<form action="login.php" method="post">
				<table>
					<tr>
						<td>Username:</td>
						<td>
							<input type="text" name="username" maxlength="30"
							 value="<?php echo htmlentities($username); ?>" />
						</td>
					</tr>
					<tr>
						<td>Password:</td>
						<td>
							<input type="password" name="password" maxlength="30"
							value="<?php echo htmlentities($password);?>"
						</td>
					</tr>
					<tr>
						<td clspan="2">
							<input type="submit" name="submit" value="Login" />
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="footer">Copyright <?php echo date("Y",time()); ?> 
			Jawaria Sadiq </div>
			
	</body>
</html>
<?php if(isset($database)) { $database->close_connection(); } ?>








