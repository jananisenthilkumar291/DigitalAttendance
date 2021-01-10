<?php 
include_once "../includes/connection.php";
session_start();
if (isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "admin"){
	if($_SESSION['user_role'] == "admin"){
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
				<h1 class="h2">Students</h1>
				<h6>Howdy  <?php echo $_SESSION['user_name']?>  | You are <?php echo $_SESSION['user_role']?></h6>
			  </div>
<!-- Displaying message for Error-->
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
<!-- Displaying message for Error-->
			  <div id = "admin-index-form">
              <h4> All Students :</h4>
              <a href = "newstudent.php"><button class = "btn btn-info">Add New</button></a><br></br>
              <div style = "float:right;">
                    <form method = "post">
                        <h4>Filter By Section</h4>
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
                        </select>
                        <input class = "btn btn-info" type = "submit" name = "submit">
                    </form>
              </div>
              <?php
                    if(isset($_POST['submit'])){
                        $section_id = $_POST['student_section'];
                        $sql = "SELECT * FROM cse WHERE `student_section` = '$section_id' ORDER BY `student_reg_id` ASC;";
                    }else{
                        $sql = "SELECT * FROM `cse` ORDER BY `student_reg_id` ASC";
                    }
                        ?>
                        <table class="table">
                            <thead>
                                <tr>
                                <th scope="col">student ID</th>
                                <th scope="col">student RegistrationID</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                        <tbody>
                        <?php 
                            $result = mysqli_query($conn,$sql);
                            while($row = mysqli_fetch_assoc($result)){
                                $student_name = $row['student_name'];
                                $student_reg_id = $row['student_reg_id'];
                                $student_id = $row['student_id'];
                                ?>
                                <tr>
                                    <th scope = "row"><?php echo $student_id;?></th>
                                    <td scope = "row"><?php echo $student_reg_id;?></td>
                                    <td scope = "row"><?php echo $student_name;?></td>
                                    <th scope = "row">
                                        <a href = "deletestudent.php?id=<?php echo $student_id;?>"><button onclick = "return confirm('Are You Sure?')"class = "btn btn-danger">Delete</button></a>
                                        <a href = "editstudent.php?id=<?php echo $student_id;?>"><button class = "btn btn-warning">Edit</button></a>
                                    </th>
                                </tr>
                                <?php
                            }
                        ?>				
                            </tbody>
                        </table>
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
	}
?>	
<?php
}else{
	header("Location:login.php?message=Please+Login");
}
?>