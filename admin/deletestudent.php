<?php 
include "../includes/connection.php";
session_start();
if(!isset($_GET['id'])){
	header("Location:students.php");
}else{
	if(!isset($_SESSION['user_role'])){
		header("Location:../index.php?message=Please+Log+In");
	}else{
		if($_SESSION['user_role'] != 'admin'){
			echo "You Can Not ACCESS!";
			exit();
		}else if($_SESSION['user_role'] == 'admin'){
			$id = $_GET['id'];
			$sqlcheck = "SELECT * FROM `cse` WHERE `student_id` = '$id'";
			$result = mysqli_query($conn,$sqlcheck);
			if(mysqli_num_rows($result) <= 0){
				header("Location:students.php?message=No+Such+File");
				exit();
			}
			$sql = "DELETE FROM `cse` WHERE `student_id` = '$id'";
			if(mysqli_query($conn,$sql)){
				header("Location:students.php?message=Succesfully+Deleted");
			}else{
				header("Location:students.php?message=Could+Not+Delete");
			}
		}
	}
}
?>