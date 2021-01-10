<?php 
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "admin"){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Management Portal</title>
		<meta name = "viewport" content = "width=device-width,initial-scale=1">		
		<link rel = "Stylesheet" href = "../css/bootstrap.min.css">
	</head>
	<body>		
		 <nav class="navbar navbar-dark sticky-top bg-dark  p-0 shadow">
		  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.html">Management Portal</a>
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
				<h1 class="h2">Dashboard</h1>
				<h6>Howdy  <?php echo $_SESSION['user_name'];?>  | You are <?php echo $_SESSION['user_role'];?></h6>
			  </div>			  
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
			  <div id = "admin-index-form">
			  <h1>Your profile</h1>
					<form method = "post">
						  <input name = "user_name" type="text"  class="form-control" id="exampleInputEmail" placeholder = "Name" value = "<?php echo $_SESSION['user_name'];?>"><br>
						  <input type="email"  name = "user_email" class="form-control" id="exampleInputEmail" placeholder = "Email Address" value = "<?php echo $_SESSION['user_email'];?>"><br>
						  <input name = "user_pwd" type="password" placeholder = "Password" class="form-control" id="inputPassword" ><br></br>
					   <button type="submit" name = "update" class="btn btn-primary">Update</button>
					</form>
					<?php 
						if(isset($_POST['update'])){
							$user_name = mysqli_real_escape_string($conn,$_POST['user_name']);
							$user_email = mysqli_real_escape_string($conn,$_POST['user_email']);
							$user_pwd = mysqli_real_escape_string($conn,$_POST['user_pwd']);
							//Checking if fields are empty
							if(empty($user_name) OR empty($user_email)){
								echo "Empty Fields";
							}else{
								// Checking email valid
								if(!filter_var($user_email,FILTER_VALIDATE_EMAIL)){
									echo "Enter valid email";
								}else{
									//check if password is new
									if(empty($user_pwd)){
										//user does not want to change
										$user_id = $_SESSION['user_id'];
										$sql = "UPDATE `user` SET user_name = '$user_name',user_email = '$user_email' WHERE user_id = '$user_id'";
										if(mysqli_query($conn,$sql)){
											$_SESSION['user_name'] = $user_name;
											$_SESSION['user_email'] = $user_email;
											header("Location:index.php?message=Record+Updated");
										}else{
											echo "Error Occured";
										}
									}else{
										//user wants to change
										$hash = password_hash($user_pwd,PASSWORD_DEFAULT);
										$user_id = $_SESSION['user_id'];
										$sql = "UPDATE `user` SET user_name = '$user_name',user_email = '$user_email',user_pwd = '$hash' WHERE user_id = '$user_id'";
										if(mysqli_query($conn,$sql)){
											$_SESSION['user_name'] = $user_name;
											$_SESSION['user_email'] = $user_email;
											$_SESSION['user_pwd'] = $hash;
											session_unset();
											session_destroy();
											header("Location:login.php?message=Record+Updated+You+May+Login+Again+Now");
										}else{
											echo "Error Occured";
										}
									}
								}
							}
						}
					?>
			  </div>
			</main>
		  </div>
		</div>
		<script src = "../js/bootstrap.min.js"></script>
		<script src= "../js/scroll.js"></script>
		<script src= "../js/jquery.js"></script>
	</body>
</html>	
<?php
}else{
	header("Location:../index.php?message=Please+Login");
}
?>