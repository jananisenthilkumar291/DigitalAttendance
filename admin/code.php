<?php 
    session_start();
    include_once "../includes/connection.php";
    if(isset($_SESSION['user_role']) AND $_SESSION['user_role'] == "user" AND isset($_GET['date'])){
        ?>
<doctype html>
    <html lan = "en">
        <head>
            <title>QR Code</title>
        </head>
        <body>
            <centre>
                <div>
                    <img src = "../includes/1.png">
                </div>
            </centre><br>
            <?php 
                $date = $_SESSION['date'];
                $class = $_SESSION['current_class'];
                $sql = "SELECT `student_reg_id` FROM `mark_attendance` WHERE `date` = '$date' AND `class_$class` = '1';";
                $result = mysqli_query($conn,$sql);
                while($row = mysqli_fetch_assoc($result)){
                    $student_reg_id = $row['student_reg_id'];
                    echo $student_reg_id."____";
                }
            ?>
        </body>
    </html>        
<?php     
}else{
    header("Location:../index.php?message=Please+Login");
}
?>

           