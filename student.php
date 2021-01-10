<?php 
    session_start();
    include_once "includes/connection.php";
    if(isset($_SESSION['user_role']) AND $_SESSION['user_role'] == 'user'){
?>
<doctype html>
<html lan = "en">
    <head>
        <title>Student Portal</title> 
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
        <div style = "width:500px;margin:auto auto;margin-top:150px;">
            <form method = "post" class="form-signin">
                <h1 class="h3 mb-3 font-weight-normal">Enter Details</h1>
                Student Registration Id:
                    <input type="text" name = "student_reg_id" class="form-control" placeholder="Registration ID" required autofocus>
                Section :
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
                Session Number:
                    <select name="current_class" class="form-control" id="exampleFormControlSelect1">
                        <?php 
                            for($i = 1;$i <= 8;$i++){
                                ?>						
                                    <option value = "<?php echo $i ?>"><?php echo $i ?></option>
                                <?php
                            }
                        ?>
                    </select>
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
                    </select>
                Date:
                   <input type="date"  name = "date" class="form-control" >
                <br></br>
                <button name = "submit" class="btn btn-lg btn-primary btn-block" type="submit">Log In</button>
            </form>
		</div>
        <?php 
            if(isset($_POST['submit'])){
                $date = $_POST['date'];
                $student_reg_id = $_POST['student_reg_id'];
                $current_subject = $_POST['current_subject'];
                $current_class = $_POST['current_class'];
                $current_section = $_POST['current_section'];
                if($date == $_SESSION['date'] AND $current_subject == $_SESSION['current_subject'] AND $current_section == $_SESSION['current_section'] AND $current_class == $_SESSION['current_class']){
                    $sqlgetid = "SELECT * FROM `cse` WHERE `student_reg_id` = '$student_reg_id';";
                    $resultgetid = mysqli_query($conn,$sqlgetid);
                    if(mysqli_num_rows($resultgetid) <= 0){
                        header("Location:student.php?message=Registration+ID+Not+Recognized");
                        exit();
                    }else{
                        while($row = mysqli_fetch_array($resultgetid)){
                            $student_section = $row['student_section'];
                        }
                        if($student_section == $_SESSION['current_section']){
                            $sqlcheck = "SELECT * FROM `mark_attendance` WHERE `date` = '$date' AND `student_reg_id` = '$student_reg_id';";
                            $resultcheck = mysqli_query($conn,$sqlcheck);
                            if(mysqli_num_rows($resultcheck) <= 0){
                                $sqlmark = "INSERT INTO `mark_attendance` (`date`,`student_reg_id`,`class_$current_class`) VALUES ('$date','$student_reg_id','1');";
                            }else{
                                $sqlmark = "UPDATE `mark_attendance` SET `class_$current_class` = '1' WHERE `date` = '$date' AND `student_reg_id` = '$student_reg_id';";
                            }
                            if(mysqli_query($conn,$sqlmark)){
                                header("Location:student.php?message=Attendance+Marked");
                                exit();
                            }else{
                                header("Location:student.php?message=Error+Marking+Attendance");
                                exit();
                            }
                        }else{
                            header("Location:student.php?message=Incorrect+Details");
                            exit();
                        }
                        
                    }
                }else{
                    header("Location:student.php?message=You+Cannot+Mark+Attendance+Now");
                }
            }
        ?>
        <script src = "js/bootstrap.min.js"></script>
        <script src= "js/scroll.js"></script>
        <script src= "js/jquery.js"></script> 
    </body>
</html>
<?php
    }else{
        echo "You Cannot Mark Attendance Now!";
        exit();
    }
?>