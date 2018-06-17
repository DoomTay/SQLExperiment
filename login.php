<?php
$pageTitle = "Log In";
require("templates/header.php");
require("functions/connect.php");
?>
<style>
.infoBox h1
{
	margin-top: 0;
	margin-bottom: 5px;
}

form ul li
{
	list-style-type: none;
	margin: 5px;
}
</style>
<?php
require("templates/body.php");
?>

<div class="infoBox">
<h1><header>Log In</header></h1>

<?php

function error($message)
{
	echo "<span style=\"color: red\">$message</span>";
}

if(!empty($_POST['username']) && !empty($_POST['password']))
{
	//Registering
	if(!empty($_POST['password2']))
	{
		if($_POST['password'] != $_POST['password2']) error("Password does not match");
		else if(empty($_POST['email'])) error("Please input an e-mail address");
		else if($_POST['email'] != $_POST['email2']) error("E-mail address does not match");
		else
		{
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$email = $_POST['email'];

			$checkUsername = $accounts->query("SELECT * FROM user_details WHERE username = '$username'")->fetch(PDO::FETCH_ASSOC);
						
			if($checkUsername) error("This username is taken");
			else
			{
				$registerQuery =  $accounts->prepare("INSERT INTO user_details (username, password, email, joinDate) VALUES(?, ?, ?, now())");
				
				if($registerQuery->execute([$username, $password, $email]))
				{
					login($username, $password);
				}
				else
				{
					error("Registration failed");
				}
			}
		}
	}
	//Logging in
	else
	{
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		
		login($username, $password);
	}
}

if(!empty($_SESSION['loggedIn']))
{
	echo "<div>You are already logged in!</div>";
	require("templates/footer.php");
	exit;
}

function login($username,$password)
{
	global $accounts;
	
	$checkLogin = $accounts->query("SELECT * FROM user_details WHERE username = '$username' AND password = '$password'")->fetch(PDO::FETCH_ASSOC);
	
	if($checkLogin)
	{         
		$_SESSION['username'] = $username;
		$_SESSION['loggedIn'] = true;
		
		header('Location: /');
	}
	else
	{
		error("Invalid username or password");
	}
}

?>

<form action="" method="post" id="register" class="norm">
<h2>Log In</h2>
<dl>
	<dt><label for="username">Username</label></dt>
	<dd><input name="username" id="username" size="30" type="text" required /></dd>

	<dt><label for="password">Password</label></dt>
	<dd><input name="password" id="password" size="30" type="password" required /></dd>
<h2>Register</h2>
	<dt><label for="password2">Confirm Password</label></dt>
	<dd><input name="password2" id="password2" size="30" type="password" /></dd>
	
	<dt><label for="email">E-mail</label></dt>
	<dd><input name="email" id="email" size="30" type="email" /></dd>
	
	<dt><label for="email2">Confirm E-mail</label></dt>
	<dd><input name="email2" id="email2" size="30" type="email" /></dd>
</dl>

<p class="submit">
<input type="submit" class="button" value="Submit" />
<input type="reset" class="button" value="Reset" />
</p>
</form>	
</div>

<?php require("templates/footer.php"); ?>