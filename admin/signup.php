<?php 
include_once "../includes/connection.php";

?>

<!doctype html>
<html lang = "en">
	<head>
		<title>SignUp</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel = "Stylesheet" href = "../css/bootstrap.min.css">
	</head>
	<body>
	
		<?php 
			if(isset($_GET['message'])){
				$msg = $_GET['message'];
				echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>'.$msg.'</strong>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>';
			}
		
		?>
	
	
		<div style = "width:500px;margin:auto auto;margin-top:250px;">
		<form method = "post" class="form-signin">
		  <h1 class="h3 mb-3 font-weight-normal">Please sign Up</h1>
		  
		  <label for="inputEmail" class="sr-only">Name</label>
		  <input type="text" id="inputEmail" name = "user_name" class="form-control" placeholder="Name" required autofocus>
		  
		  <label for="inputEmail" class="sr-only">Email address</label>
		  <input type="email" name = "user_email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		  
		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" name = "user_pwd" id="inputPassword" class="form-control" placeholder="Password" required>
		  <br></br>
		  <button name = "signup" class="btn btn-lg btn-primary btn-block" type="submit">Sign Up</button>
		</form>
		</div>
		
		<?php 
			if(isset($_POST['signup'])){
				$user_name = mysqli_real_escape_string($conn,$_POST['user_name']);
				$user_email = mysqli_real_escape_string($conn,$_POST['user_email']);
				$user_pwd = mysqli_real_escape_string($conn,$_POST['user_pwd']);
				//Checking for empty fields
				if(empty($user_name) OR empty($user_email) OR empty($user_pwd)){
					header("Location:signup.php?message=Empty+Fields");
					exit();
				}
				//checking for email validity
				if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
					header("Location: signup.php?message=Please+Enter+Valid+Email");
					exit();
					
				}
				else{
					//checking if email Exits
					$sql = "SELECT * FROM `user` WHERE user_email = '$user_email'";
					$result = mysqli_query($conn,$sql);
					if(mysqli_num_rows($result) > 0){
						header("Location:signup.php?message=Email+Already+Exits");
					}else{
						
						//hashing password
						$hash = password_hash($user_pwd,PASSWORD_DEFAULT);
						
						//Signing Up The User
						$sql = "INSERT INTO `user`(`user_name`,`user_email`,`user_pwd`,`user_role`) VALUES ('$user_name','$user_email','$hash','user');
								";
						if(mysqli_query($conn,$sql)){
							header("Location: index.php?message=succesfully+registered");
							exit();
						}else{
							header("Location: signup.php?message=registeration+failed");
							exit();
						}
					}
				}
				
			}
		?>
		
		<script src = "../js/bootstrap.min.js"></script>
		<script src= "../js/scroll.js"></script>
		<script src= "../js/jquery.js"></script>
	</body>
</html>