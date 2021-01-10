<?php 
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role'])){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>New Student</title>
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
				<h1 class="h2">Add New Student</h1>
				<h6>Howdy  <?php echo $_SESSION['user_name']?>  | You are <?php echo $_SESSION['user_role']?></h6>
			  </div>
			  <!--Displaying Error Messages If Any-->
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
			  <!--Displaying Error Messages If Any-->
			  <form enctype = "multipart/form-data" method = "post">
				Student Name:
				<input placeholder = "Enter Student Name" name = "student_name" class = "form-control" type = "text"><br>
				Student RegistrationID:
				<input placeholder = "Enter Student RegistrationID" name = "student_reg_id" class = "form-control" type = "text"><br>
				Student section:
				<select name="student_section" class="form-control" id="exampleFormControlSelect1">
				<?php 
					$sql = "SELECT * FROM `sections`";
					$result = mysqli_query($conn,$sql);
					while($row = mysqli_fetch_assoc($result)){
						?>						
							<option value = "<?php echo $row['section_id']?>"><?php echo $row['section_name'];?></option>
						<?php
					}
				?>
				</select><br>
				
				<input class = "btn btn-info" type = "submit" name = "submit">
			  </form>
			  <?php 
				if(isset($_POST['submit'])){
					$student_name = mysqli_real_escape_string($conn,$_POST['student_name']);
					$student_section = mysqli_real_escape_string($conn,$_POST['student_section']);
					$student_reg_id = mysqli_real_escape_string($conn,$_POST['student_reg_id']);
					//checking for empty fields
					if(empty($student_name) OR empty($student_section) OR empty($student_reg_id)){
						header("Location:newstudent.php?message=Empty+Fields");
						exit();
                    }
                    $sql = "INSERT INTO `cse` (`student_name`,`student_section`,`student_reg_id`) VALUES ('$student_name', '$student_section','$student_reg_id');";
					if(mysqli_query($conn, $sql)){
						header("Location: students.php?message=Student+Joined");
					}else{
						header("Location: newstudent.php?message=Error");
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

