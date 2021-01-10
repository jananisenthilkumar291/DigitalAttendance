<?php 
session_start();
include_once "includes/connection.php";
?>

<!doctype html>
<html lang = "en">
	<head>
		<title>SignIn</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel = "Stylesheet" href = "css/bootstrap.min.css">
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
		  <h1 class="h3 mb-3 font-weight-normal">Please  Log In</h1>
		  
		  
		  <label for="inputEmail" class="sr-only">Email address</label>
		  <input type="email" name = "user_email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
		  
		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" name = "user_pwd" id="inputPassword" class="form-control" placeholder="Password" required>
		  <br></br>
		  <button name = "login" class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
		</form>
		</div>
		
		<?php 
			if(isset($_POST['login'])){
				$user_email = mysqli_real_escape_string($conn,$_POST['user_email']);
				$user_pwd = mysqli_real_escape_string($conn,$_POST['user_pwd']);
				//Checking for empty fields
				if(empty($user_email) OR empty($user_pwd)){
					header("Location:index.php?message=Empty+Fields");
					exit();
				}
				//checking for email validity
				if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
					header("Location: index.php?message=Please+Enter+Valid+Email");
					exit();
					
				}
				else{
					//checking if email Exits
					$sql = "SELECT * FROM `user` WHERE user_email = '$user_email'";
					$result = mysqli_query($conn,$sql);
					if(mysqli_num_rows($result) <= 0){
						header("Location:index.php?message=LogIn+Error");
						exit();
					}else{
						while($row = mysqli_fetch_assoc($result)){
							//check if password matches
							if(!password_verify($user_pwd,$row['user_pwd'])){
								header("Location:index.php?message=LogIn+Error");
								exit();
							}else if(password_verify($user_pwd,$row['user_pwd'])){
								$_SESSION['user_id'] = $row['user_id'];
								$_SESSION['user_name'] = $row['user_name'];
								$_SESSION['user_email'] = $row['user_email'];
								$_SESSION['user_role'] = $row['user_role'];
								if($_SESSION['user_role'] == "admin"){										
									header("Location:admin/index.php");
								}else{
									header("Location:faculty.php?message=Logged+In");
								}
							}
						}
						
					}
				}
				
			}
		?>
		
		<script src = "js/bootstrap.min.js"></script>
		<script src= "js/scroll.js"></script>
		<script src= "js/jquery.js"></script>
	</body>
</html>