<?php 
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "admin" AND isset($_GET['id'])){
?>
<!doctype html>
<html lang = "en">
	<head>
		<title>Edit Student Details</title>
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
				<h1 class="h2">Edit Student Details</h1>
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
				$student_id = $_GET['id'];
				$formsql = "SELECT * FROM `cse` WHERE `student_id` = '$student_id' ";
				$formresult = mysqli_query($conn,$formsql);
				while($formrow = mysqli_fetch_assoc($formresult)){
					$student_name = $formrow['student_name'];
					$student_section = $formrow['student_section'];
					$student_reg_id = $formrow['student_reg_id'];
			  ?>
			  <form enctype = "multipart/form-data" method = "post">
				Student Name:
				<input placeholder = "Enter Student Name" name = "student_name" class = "form-control" value = "<?php echo $student_name;?>" type = "text"><br>
				Student RegistrationID:
				<input placeholder = "Enter Student RegistrationID" value = "<?php echo $student_reg_id;?>" name = "student_reg_id" class = "form-control" type = "text"><br>
				Student Section:
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
				<input class = "btn btn-info" type = "submit" name = "update">
			  </form>
		<?php   } ?>
			  <?php 
				if(isset($_POST['update'])){
					$student_name = mysqli_real_escape_string($conn,$_POST['student_name']);
					$student_reg_id = mysqli_real_escape_string($conn,$_POST['student_reg_id']);
					$student_section = mysqli_real_escape_string($conn,$_POST['student_section']);
					//checking for empty fields
					if(empty($student_name) OR empty($student_reg_id) OR empty($student_section)){
						header("Location:editblog.php?message=Empty+Fields");
						exit();
					}
						$sql = "UPDATE `cse` SET student_name = '$student_name',student_reg_id = '$student_reg_id',student_section = '$student_section' WHERE student_id = '$student_id';";
						if(mysqli_query($conn, $sql)){
							header("Location: students.php?message=Student+Detail+Updated");
						}else{
							header("Location: editstudent.php?message=Error");
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