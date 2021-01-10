<?php 
    session_start();
    include_once "includes/connection.php";
    if(isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "user"){
?>
<doctype html>
<html lan = "en">
        <head>
            <title>Faculty Portal</title>
            <meta name = "viewport" content = "width=device-width,initial-scale=1">		
            <link rel = "Stylesheet" href = "css/bootstrap.min.css">
        </head>
        <body>
            <nav class="navbar navbar-dark sticky-top bg-dark  p-0 shadow">
            <a class="navbar-brand col-md-3 col-lg-2 mr-0 px-3" href="faculty.php">Member Portal</a>
            <ul class = "navbar-nav px-3">
                <li class="nav-item text-nowrap">
                <a class="nav-link" href="admin/logout.php">Log out</a>
                </li>
            </ul>
            </nav>
              <div style = "background-color:darkgrey;color:black;padding:10px;border-radius:15px;"class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
				<h1 class="h2">Dashboard</h1>
				<h5><strong>Howdy!</strong>&nbsp;&nbsp;<?php echo $_SESSION['user_name'];?>&nbsp;||&nbsp;You are <?php echo $_SESSION['user_role'];?></h5>
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
              
              <div id = "admin-index-form formy" style = "padding:20px;">
					<form method = "post">
                        Section:
                            <select name="current_section" class="form-control" id="exampleFormControlSelect1">
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
                        Subject:
                            <select name="current_subject" class="form-control" id="exampleFormControlSelect1">						
                            <?php 
                                    $sql = "SELECT * FROM `subjects`";
                                    $result = mysqli_query($conn,$sql);
                                    while($row = mysqli_fetch_assoc($result)){
                                        ?>						
                                            <option value = "<?php echo $row['subject_id']?>"><?php echo $row['subject_name'];?></option>
                                        <?php
                                    }
                                ?>
                            </select><br>
                        Class:
                            <select name="current_class" class="form-control" id="exampleFormControlSelect1">
                                <?php 
                                    for($i = 1;$i <= 8;$i++){
                                        ?>						
                                            <option value = "<?php echo $i ?>"><?php echo $i ?></option>
                                        <?php
                                    }
                                ?>
                            </select><br>
                        Date :
                            <input type="date"  name = "date" class="form-control" ><br>
                        <button type="submit" name = "submit" id = "addimage" class="btn btn-primary">Submit</button>

                        <?php 
                            if(isset($_POST['submit'])){
                                $current_section = $_POST['current_section'];
                                $current_subject = $_POST['current_subject'];
                                $current_class = $_POST['current_class'];
                                $date = $_POST['date'];
                                $sqlget = "INSERT INTO `get_attendance` (`current_subject`,`current_class`,`current_section`,`date`) VALUES ('$current_subject','$current_class','$current_section','$date')";
                                if(mysqli_query($conn,$sqlget)){
                                    $_SESSION['current_section'] = $current_section;
                                    $_SESSION['current_subject'] = $current_subject;
                                    $_SESSION['current_class'] = $current_class;
                                    $_SESSION['date'] = $date;
                                    echo "<script> window.location = 'admin/code.php';</script>";
                                }else{
                                    header("Location:faculty.php?message=Error+Generating+Code");
                                }
                            }
                        ?>
					</form>
				</div>
            <script src = "js/bootstrap.min.js"></script>
            <script src= "js/scroll.js"></script>
            <script src= "js/jquery.js"></script>    
            
        </body>
</html>

<?php
    }else{
        header("Location:index.php?message=Please+Log+In");
    }
?>