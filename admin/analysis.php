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
                <h4> Attendance Analysis</h4>
                <div class = "row">
                    <div class = "col-4">
                        <form method = "post">
                            <h5>Filter By Section :</h5>
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
                            <input class = "btn btn-info" type = "submit" name = "section_filter">
                        </form>
                    </div>
                    <div class = "col-4">
                        <form method = "post">       
                            <h5>Filter By Date :</h5>
                            <input type = "date" class = "form-control" name = "date">
                            <input type = "submit" class = "btn btn-info" name = "date_filter">
                        </form>
                    </div>
                    <div class = "col-4">
                        <form method = "post">
                            <h5>Student Analysis :</h5>
                            <input type = "text" name = "student_reg_id" class = "form-control">
                            <input type = "submit" name = "student_filter" class = "btn btn-info">
                        </form>
                    </div>
                </div><br>
              <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>       
                                    <th scope="col">student RegistrationID</th>
                                    <?php
                                        for($i = 1;$i <= 8;$i++){
                                            ?>
                                                <th scope="col">Class <?php echo $i;?></th>
                                            <?php
                                        }
                                    ?>
                                </tr>
                            </thead>
                        <tbody>
                        <?php
                            if(isset($_POST['section_filter'])){
                                $section_id = $_POST['student_section'];
                                $sqlinfo = "SELECT `student_reg_id` FROM cse WHERE `student_section` = '$section_id' ORDER BY `student_reg_id` ASC;";
                                $resultinfo = mysqli_query($conn,$sqlinfo);
                                while($rowinfo = mysqli_fetch_assoc($resultinfo)){
                                    $student_reg_id = $rowinfo['student_reg_id'];
                                    $sqlattbyreg = "SELECT * FROM `mark_attendance` WHERE `student_reg_id` =  '$student_reg_id' ORDER BY `student_reg_id` ASC;";
                                    $sqlattbydate = "SELECT * FROM `mark_attendance` WHERE `student_reg_id` = '$student_reg_id' ORDER BY `student_reg_id` DESC;";
                                    $resultattbydate = mysqli_query($conn,$sqlattbydate);
                                    $resultattbyreg = mysqli_query($conn,$sqlattbyreg);
                                    while($rowattbydate = mysqli_fetch_assoc($resultattbydate)){
                                        $date = $rowattbydate['date'];
                                        while($rowattbyreg = mysqli_fetch_assoc($resultattbyreg)){
                                            $student_reg_id = $rowattbyreg['student_reg_id'];
                                            $class_1 = $rowattbyreg['class_1'];
                                            $class_2 = $rowattbyreg['class_2'];
                                            $class_3 = $rowattbyreg['class_3'];
                                            $class_4 = $rowattbyreg['class_4'];
                                            $class_5 = $rowattbyreg['class_5'];
                                            $class_6 = $rowattbyreg['class_6'];
                                            $class_7 = $rowattbyreg['class_7'];
                                            $class_8 = $rowattbyreg['class_8'];
                                            ?>
                                            <tr>
                                                <td scope = "row"> <?php echo $date; ?></td>
                                                <td scope = "row"><?php echo $student_reg_id;?></td>
                                                <td scope = "row">
                                                    <?php 
                                                        if($class_1 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td>
                                                <td scope = "row">
                                                    <?php 
                                                        if($class_2 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td> 
                                                <td scope = "row">
                                                    <?php 
                                                        if($class_3 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td>
                                                <td scope = "row">
                                                    <?php 
                                                        if($class_4 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td><td scope = "row">
                                                    <?php 
                                                        if($class_5 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td>
                                                <td scope = "row">
                                                    <?php 
                                                        if($class_6 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td>
                                                <td scope = "row">
                                                    <?php 
                                                        if($class_7 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td> 
                                                <td scope = "row">
                                                    <?php 
                                                        if($class_8 == '1') 
                                                            echo "P";
                                                        else
                                                            echo "--";
                                                    ?>  
                                                </td> 
                                            </tr>
                                            <?php
                                        }
                                    }                          
                                }
                            }else if(isset($_POST['date_filter'])){
                                $date = $_POST['date'];
                                $sqlattbyreg = "SELECT * FROM `mark_attendance` ORDER BY `student_reg_id` ASC";
                                $sqlattbydate = "SELECT * FROM `mark_attendance` WHERE `date` = '$date';";
                                $resultattbydate = mysqli_query($conn,$sqlattbydate);
                                $resultattbyreg = mysqli_query($conn,$sqlattbyreg);
                                while($rowattbydate = mysqli_fetch_assoc($resultattbydate)){
                                    $date = $rowattbydate['date'];
                                    while($rowattbyreg = mysqli_fetch_assoc($resultattbyreg)){
                                        $student_reg_id = $rowattbyreg['student_reg_id'];
                                        $class_1 = $rowattbyreg['class_1'];
                                        $class_2 = $rowattbyreg['class_2'];
                                        $class_3 = $rowattbyreg['class_3'];
                                        $class_4 = $rowattbyreg['class_4'];
                                        $class_5 = $rowattbyreg['class_5'];
                                        $class_6 = $rowattbyreg['class_6'];
                                        $class_7 = $rowattbyreg['class_7'];
                                        $class_8 = $rowattbyreg['class_8'];
                                        ?>
                                        <tr>
                                            <td scope = "row"> <?php echo $date; ?></td>
                                            <td scope = "row"><?php echo $student_reg_id;?></td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_1 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_2 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td> 
                                            <td scope = "row">
                                                <?php 
                                                    if($class_3 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_4 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td><td scope = "row">
                                                <?php 
                                                    if($class_5 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_6 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_7 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td> 
                                            <td scope = "row">
                                                <?php 
                                                    if($class_8 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td> 
                                        </tr>
                                        <?php
                                    }
                                }                          
                            }else if(isset($_POST['student_filter'])){
                                $student_reg_id = $_POST['student_reg_id'];
                                $sqlattbyreg = "SELECT * FROM `mark_attendance` WHERE `student_reg_id` = '$student_reg_id';";
                                $sqlattbydate = "SELECT * FROM `mark_attendance` ORDER BY `date` DESC;";
                                $resultattbydate = mysqli_query($conn,$sqlattbydate);
                            $resultattbyreg = mysqli_query($conn,$sqlattbyreg);
                            while($rowattbydate = mysqli_fetch_assoc($resultattbydate)){
                                $date = $rowattbydate['date'];
                                while($rowattbyreg = mysqli_fetch_assoc($resultattbyreg)){
                                    $student_reg_id = $rowattbyreg['student_reg_id'];
                                    $class_1 = $rowattbyreg['class_1'];
                                    $class_2 = $rowattbyreg['class_2'];
                                    $class_3 = $rowattbyreg['class_3'];
                                    $class_4 = $rowattbyreg['class_4'];
                                    $class_5 = $rowattbyreg['class_5'];
                                    $class_6 = $rowattbyreg['class_6'];
                                    $class_7 = $rowattbyreg['class_7'];
                                    $class_8 = $rowattbyreg['class_8'];
                                    ?>
                                    <tr>
                                        <td scope = "row"> <?php echo $date; ?></td>
                                        <td scope = "row"><?php echo $student_reg_id;?></td>
                                        <td scope = "row">
                                            <?php 
                                                if($class_1 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td>
                                        <td scope = "row">
                                            <?php 
                                                if($class_2 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td> 
                                        <td scope = "row">
                                            <?php 
                                                if($class_3 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td>
                                        <td scope = "row">
                                            <?php 
                                                if($class_4 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td><td scope = "row">
                                            <?php 
                                                if($class_5 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td>
                                        <td scope = "row">
                                            <?php 
                                                if($class_6 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td>
                                        <td scope = "row">
                                            <?php 
                                                if($class_7 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td> 
                                        <td scope = "row">
                                            <?php 
                                                if($class_8 == '1') 
                                                    echo "P";
                                                else
                                                    echo "--";
                                            ?>  
                                        </td> 
                                    </tr>
                                    <?php
                                }
                            }                          
                            }else{
                                $sqlattbyreg = "SELECT * FROM `mark_attendance` ORDER BY `student_reg_id` ASC";
                                $sqlattbydate = "SELECT * FROM `mark_attendance` ORDER BY `date` DESC";
                                $resultattbydate = mysqli_query($conn,$sqlattbydate);
                                $resultattbyreg = mysqli_query($conn,$sqlattbyreg);
                                while($rowattbydate = mysqli_fetch_assoc($resultattbydate)){
                                    $date = $rowattbydate['date'];
                                    while($rowattbyreg = mysqli_fetch_assoc($resultattbyreg)){
                                        $student_reg_id = $rowattbyreg['student_reg_id'];
                                        $class_1 = $rowattbyreg['class_1'];
                                        $class_2 = $rowattbyreg['class_2'];
                                        $class_3 = $rowattbyreg['class_3'];
                                        $class_4 = $rowattbyreg['class_4'];
                                        $class_5 = $rowattbyreg['class_5'];
                                        $class_6 = $rowattbyreg['class_6'];
                                        $class_7 = $rowattbyreg['class_7'];
                                        $class_8 = $rowattbyreg['class_8'];
                                        ?>
                                        <tr>
                                            <td scope = "row"> <?php echo $date; ?></td>
                                            <td scope = "row"><?php echo $student_reg_id;?></td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_1 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_2 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td> 
                                            <td scope = "row">
                                                <?php 
                                                    if($class_3 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_4 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td><td scope = "row">
                                                <?php 
                                                    if($class_5 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_6 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td>
                                            <td scope = "row">
                                                <?php 
                                                    if($class_7 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td> 
                                            <td scope = "row">
                                                <?php 
                                                    if($class_8 == '1') 
                                                        echo "P";
                                                    else
                                                        echo "--";
                                                ?>  
                                            </td> 
                                        </tr>
                                        <?php
                                    }
                                }                          
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