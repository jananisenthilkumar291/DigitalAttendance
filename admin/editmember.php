<?php 
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "admin" AND isset($_GET['id'])){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Edit Member Details</title>
		<link rel = "Stylesheet" href = "../css/bootstrap.min.css">
		<link rel = "stylesheet" href = "../css/customstyle.css">
	</head>
	<body>
		 <nav class="navbar navbar-dark sticky-top bg-dark  p-0 shadow">
		  <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="index.php">Management Portal</a>		  
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
				<h1 class="h2">Edit Member Details</h1>
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
				$user_id = $_GET['id'];
				$formsql = "SELECT * FROM `user` WHERE `user_id` = '$user_id' ";
				$formresult = mysqli_query($conn,$formsql);
				while($formrow = mysqli_fetch_assoc($formresult)){
					$user_name = $formrow['user_name'];
					$user_email = $formrow['user_email'];
			  ?>
			  <form enctype = "multipart/form-data" method = "post">
			  		<input name = "user_name" type="text"  class="form-control" id="exampleInputEmail" placeholder = "Name" value = "<?php echo $user_name; ?>"><br>
					<input type="email"  name = "user_email" class="form-control" id="exampleInputEmail" placeholder = "Email Address" value = "<?php echo $user_email;?>"><br>
					<input name = "user_pwd" type="password" placeholder = "Password" class="form-control" id="inputPassword" ><br></br>
					<input class = "btn btn-info" type = "submit" name = "update">
			  </form>
		<?php   } ?>
			  <?php 
				if(isset($_POST['update'])){
					$user_name = mysqli_real_escape_string($conn,$_POST['user_name']);
					$user_email = mysqli_real_escape_string($conn,$_POST['user_email']);
					$user_pwd = mysqli_real_escape_string($conn,$_POST['user_pwd']);
					//checking for empty fields
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
								$user_id = $_GET['id'];
								$sql = "UPDATE `user` SET `user_name` = '$user_name',`user_email` = '$user_email' WHERE `user_id` = '$user_id'";
								if(mysqli_query($conn,$sql)){
									header("Location:index.php?message=Record+Updated");
								}else{
									echo "Error Occured";
								}
							}else{
								//user wants to change
								$hash = password_hash($user_pwd,PASSWORD_DEFAULT);
								$user_id = $_GET['id'];
								$sql = "UPDATE `user` SET user_name = '$user_name',user_email = '$user_email',user_pwd = '$hash' WHERE user_id = '$user_id'";
								if(mysqli_query($conn,$sql)){
									header("Location: students.php?message=Faculty+Detail+Updated");	
								}else{
									echo "Error Occured";
								}
								
							}
						}
					}
					
				} ?>
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