<?php
	session_start();
	
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
	{
		header("location : login.php");
		exit;
	}
	
	require_once "connect.php";
	
	//define variables and initialize with empty values
	$new_password = $confirm_password = "";
	$new_password_err = $confirm_password_err = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST")
	{
		//validate new password
		if(empty(trim($_POST["new_password"])))
		{
			$new_password_err = "Please enter the new password.";
		}
		elseif (strlen(trim($_POST["new_password"])) < 6)
		{
			$new_password_err = "Password must have at least 6 characters.";
		}
		else
		{
			$new_password = trim($_POST["new_password"]);
		}
		
		//validate confirm password
		if(empty(trim($_POST["confirm_password"])))
		{
			$confirm_password_err = "Please confirm the password.";
		}
		else
		{
			$confirm_password = trim($_POST["confirm_password"]);
			if(empty($new_password_err) && ($new_password != $confirm_password))
			{
				$confirm_password_err = "Passwords did not match.";
			}
		}
		
		//Check input errors before updating the database
		
		if(empty($new_password_err) && empty($confirm_password_err))
		{
			$sql = "UPDATE users SET password = ? WHERE id = ?";
			
			if($stmt = $mysqli -> prepare($sql))
			{
				//Bind variables to the prepared statement as parameters
				$stmt -> bind_param("si", $param_password, $param_id);
				
				//Set parameters
				$param_password = password_hash($new_password, PASSWORD_DEFAULT);
				$param_id = $_SESSION["id"];
				
				//attempt to execute the prepared statement
				if($stmt -> execute())
				{
					//password updated successfully. destroy the session, and redirect
					//to login page
					session_destroy();
					header("location: login.php");
					exit();
				}
				else
				{
					echo "Oops! Something went wrong. Please try again.";
				}
			}
			
			$stmt -> close();
		}
		
		$mysqli -> close();
	}
?>

<!DOCTYPE html>
<html lang = "en">
	<head>
=		<title>Reset Password</title>
		<link rel = "stylesheet" href = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<meta name="viewport" content="width=device-width, initial-scale=1,user-scaleable=no">
		<meta charset="utf-8">
		<style type = "text/css">
			body{font: 20px;
			color: black;}
			.divul{width:350px; padding:20px;

					}
			@font-face { font-family:Angelface; src: url('Angelface.otf'); }

		</style>
		<script 
			src="https://code.jquery.com/jquery-3.4.1.js"
			integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
			crossorigin="anonymous">
	</script>
	<script src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class ="navbar navbar-default navbar-fixed-top" id="navbar">
		<div class="container">
			<ul class="nav navbar-nav">
						<li><a href="index.php" id="text"> Home</a></li>								
						<li><a href="products.php" id="text"> Products </a></li>
				</ul>
			<ul class="nav navbar-nav navbar-right" >
        		<li><a href="registration.php" id="text">Sign up</a></li>
        		<li><a href="login.php" id="text">Log in</a></li>
        		<li><a href="#" id="text">My account</a></li>
        		<li><a href="shoppingcart.php" id="text">Shopping cart</a></li>
      		</ul>
		</div>
	</nav>
		<div class = "container divul">
			<h1> <b> Reset password </b></h1>
			<p>Please fill out this form to reset your password.</p>
			<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method = "post">
				<div class = "form-group <?php echo (!empty($new_password_err)) ? 'has-error' : '' ; ?>">
					<label>New password</label>
					<input type = "password" name = "new_password" class = "form-control" value = "<?php echo $new_password; ?>">
					<span class = "help-block"><?php echo $new_password_err; ?></span>
				</div>
				<div class = "form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : '' ; ?>">
					<label>Confirm password</label>
					<input type = "password" name = "confirm_password" class = "form-control" value = "<?php echo $new_password; ?>">
					<span class = "help-block"><?php echo $confirm_password_err; ?></span>
				</div>
				<div class = "form-group">
					<input type = "submit" class = "buton btn-default"  value = "Submit">
					<a id="login" class = " btn-link" href = "principala.php">Cancel</a>
				</div>
			</form>
		</div>
	</body>
</html>