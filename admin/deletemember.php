<?php 
include "../includes/connection.php";
session_start();
if(!isset($_GET['id'])){
	header("Location:faculty.php");
}else{
	if(!isset($_SESSION['user_role'])){
		header("Location:../index.php?message=Please+Log+In");
	}else{
		if($_SESSION['user_role'] != 'admin'){
			echo "You Can Not ACCESS!";
			exit();
		}else if($_SESSION['user_role'] == 'admin'){
			$id = $_GET['id'];
			$sqlcheck = "SELECT * FROM `user` WHERE `user_id` = '$id';";
			$result = mysqli_query($conn,$sqlcheck);
			if(mysqli_num_rows($result) <= 0){
				header("Location:faculty.php?message=No+Such+File");
				exit();
			}
			$sql = "DELETE FROM `user` WHERE `user_id` = '$id'";
			if(mysqli_query($conn,$sql)){
				header("Location:faculty.php?message=Succesfully+Deleted");
			}else{
				header("Location:faculty.php?message=Could+Not+Delete");
			}
		}
	}
}
?>