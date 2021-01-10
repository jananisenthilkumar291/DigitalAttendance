<?php 
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role'])){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>New Member</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">
		<link rel = "Stylesheet" href = "../css/bootstrap.min.css">
	</head>
	<body>
		
		 <nav class="navbar navbar-dark sticky-top bg-dark  p-0 shadow">
		  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Management Portal</a>		  
		  <ul class = "navbar-nav px-3">
			<li class="nav-item text-nowrap">
			  <a class="nav-link" href="logout.php">Log out</a>
			</li>
		  </ul>
		</nav>
		
		
		<div class="container-fluid">
		  <div class="row">
			<?php include_once "nav.inc.php";?>
			<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
			  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">Add New Member</h1>
				<h6>Howdy  <?php echo $_SESSION['user_name']?>  | You are <?php echo $_SESSION['user_role']?></h6>
			  </div>
			  
			  <?php 
					if(isset($_GET['message'])){
						$msg = $_GET['message'];
						echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
				'.$msg.'
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				  </button>
				</div>';
					}
					
			  ?>
			  
			  <form enctype = "multipart/form-data" method = "post">
				Member Name :
				<input placeholder = "Enter Name" name = "user_name" class = "form-control" type = "text"><br>
				
				Member Email:
				<input placeholder = "Enter Email" name = "user_email" class = "form-control" type = "email"><br>
				Member Password:
				<input type = "password" name = "user_pwd" class = "form-control"><br>
				<input class = "btn btn-info" type = "submit" name = "submit">
			  </form>
			  <?php 
				if(isset($_POST['submit'])){
					$user_name = mysqli_real_escape_string($conn,$_POST['user_name']);
					$user_email = mysqli_real_escape_string($conn,$_POST['user_email']);
					$user_pwd = mysqli_real_escape_string($conn,$_POST['user_pwd']);
					//Checking for empty fields
					if(empty($user_name) OR empty($user_email) OR empty($user_pwd)){
						header("Location:newmember.php?message=Empty+Fields");
						exit();
					}
					//checking for email validity
					if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
						header("Location: newmember.php?message=Please+Enter+Valid+Email");
						exit();
						
					}
					else{
						//checking if email Exits
						$sql = "SELECT * FROM `user` WHERE user_email = '$user_email'";
						$result = mysqli_query($conn,$sql);
						if(mysqli_num_rows($result) > 0){
							header("Location:newmember.php?message=Email+Already+Exits");
						}else{
							
							//hashing password
							$hash = password_hash($user_pwd,PASSWORD_DEFAULT);
							
							//Signing Up The User
							$sql = "INSERT INTO `user`(`user_name`,`user_email`,`user_pwd`,`user_role`) VALUES ('$user_name','$user_email','$hash','user');
									";
							if(mysqli_query($conn,$sql)){
								header("Location: faculty.php?message=succesfully+registered");
								exit();
							}else{
								header("Location: newmember.php?message=registeration+failed");
								exit();
							}
						}
					}
					
				}
			  ?>
			</main>
		  </div>
		</div>
		
		<script src = "../js/bootstrap.min.js"></script>
		<script src= "../js/scroll.js"></script>
		<script src= "../js/jquery.js"></script>
		
		<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ey5ln3e6qq2sq6u5ka28g3yxtbiyj11zs8l6qyfegao3c0su"></script>

		<script>tinymce.init({ selector:'textarea' });</script>
	</body>
</html>	
<?php
}else{
	header("Location:login.php?message=Please+Login");
}
?>

