<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</head>
<body>
<?php
if(isset($_SESSION["user_id"]))
{
	header('Location: overview.php');
	exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    // connect to MySQL db
    $db_host = "localhost";
    $db_username = "cen4010sp23g03";
    $db_password = "ASpring#2023";
    $db_name = "cen4010sp23g03";
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if (!$db) { die("No connection to MySQL database!" . mysqli_connect_error()); }

    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql_cmd = "INSERT INTO user_accounts (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($db, $sql_cmd);

    if (!$result)
    {
        echo 'Error creating account: ' . mysqli_error($db);
    }
    else
    {
        echo 'Account created successfully!';
        mysqli_close($db);
        header('Location: login.php');
    }   
}
?>
	<div class="container-fluid">
		<div class="row ">
			<!-- IMAGE CONTAINER BEGIN -->
			<div class="col-lg-6 col-md-6 d-none d-md-block infinity-image-container"></div>
			<!-- IMAGE CONTAINER END -->

			<!-- FORM CONTAINER BEGIN -->
			<div class="col-lg-6 col-md-6 infinity-form-container">					
				<div class="col-lg-9 col-md-12 col-sm-8 col-xs-12 infinity-form">
					<!-- Company Logo -->
					<div class="text-center mb-3 mt-5">
						<img src="logo.png" width="150px">
					</div>
					<div class="text-center mb-4">
				    <h4>Create an account</h4>
				  </div>
					<!-- Form -->
					<form class="px-3">
						<!-- Input Box -->
						<div class="form-input">
							<span><i class="fa fa-user-o"></i></span>
							<input type="text" name="username" placeholder="Username" tabindex="10" required>
						</div>
						<div class="form-input">
							<span><i class="fa fa-lock"></i></span>
							<input type="password" name="password" placeholder="Password" required>
						</div>
						<!-- Register Button -->
				    <div class="mb-3"> 
							<button type="submit" class="btn btn-block">Create Account</button>
						</div>
						
						<div class="text-center mb-5 text-white">Already have an Overview account?
							<a class="login-link" href="login.php">Login here</a>
		       	</div>
					</form>
				</div>
			</div>
			<!-- FORM CONTAINER END -->
		</div>
	</div>	
</body>
</html>