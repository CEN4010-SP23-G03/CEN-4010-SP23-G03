<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
if($_SERVER["REQUEST_METHOD"] == "POST")
{
    // connect to MySQL db
    $db_host = "localhost";
    $db_username = "cen4010sp23g03";
    $db_password = "ASpring#2023";
    $db_name = "cen4010sp23g03";
    $db = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if (!$db) { die("No connection to MySQL database!" . mysqli_connect_error()); }

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql_cmd = "SELECT * FROM user_accounts WHERE username = '$username'";
    $result = mysqli_query($db, $sql_cmd);
    if($row = mysqli_fetch_assoc($result))
    {
        if(password_verify($password, $row["password"]))
        {
            // Password is correct, set session variable and redirect to index
            session_start();
            $_SESSION["user_id"] = $row["user_id"];
            header('Location: overview.php');
            exit;
        }
        else
        {
            echo 'Incorrect password.';
        }
    }
    else
    {
        echo 'Incorrect username or password.';
    }

    mysqli_close($db);

}
?>
	<div class="container-fluid">
		<div class="row ">
			<!-- IMAGE CONTAINER BEGIN -->
			<div class="col-lg-6 col-md-6 d-none d-md-block infinity-image-container"></div>
			<!-- IMAGE CONTAINER END -->

			<!-- FORM CONTAINER BEGIN -->
			<div class="col-lg-6 col-md-6 infinity-form-container">				
				<div class="col-lg-9 col-md-12 col-sm-9 col-xs-12 infinity-form">
					<!-- Company Logo -->
					<div class="text-center mb-3 mt-5">
						<img src="logo.png" width="150px">
					</div>
					<div class="text-center mb-4">
			      <h4>Login to your account</h4>
			    </div>
			    <!-- Form -->
					<form class="px-3" method="post">
						<!-- Input Box -->
						<div class="form-input">
							<span><i class="fa fa-user-o"></i></span>
							<input type="text" name="username" placeholder="Username" tabindex="10"required>
						</div>
						<div class="form-input">
							<span><i class="fa fa-lock"></i></span>
							<input type="password" name="password" placeholder="Password" required>
						</div>

						<!-- Remember Checkbox -->
						<!--<div class="row mb-3">
						
					
					
			        <div class="col-auto d-flex align-items-center">
			          <div class="custom-control custom-checkbox">
			            <input type="checkbox" class="custom-control-input" id="cb1">
			           	<label class="custom-control-label text-white" for="cb1">Remember me</label>
			          </div>
			        </div>
					

			 	    </div>-->
			 	    <!-- Login Button -->
			      <div class="mb-3"> 
							<button type="submit" class="btn btn-block">Login</button>
						</div>
						<div class="text-right ">
			        <!--<a href="reset.html" class="forget-link">Forgot password?</a>-->
			      </div>
					
						<div class="text-center mb-5 text-white">Don't have an Overview account? 
							<a class="register-link" href="create-account.php">Create one here</a>
			     	</div>
					</form>
				</div>					
			</div>
			<!-- FORM CONTAINER END -->
		</div>
	</div>	
</body>
</html>
