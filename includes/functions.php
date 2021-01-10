<?php 
include_once "connection.php";
	function add_jumbotron(){
		echo '<div class="jumbotron jumbotron-fluid" style = background-color:lightgrey;>
			  <div class="container">
				<h1 class="display-4">CSBooks</h1>
				<p class="lead">Avail Computer Science Books Here For Free..!!</p>
			  </div></div><br></br>';
	}
	
	function getCategoryName($id){
		global $conn;
		$sql = "SELECT * FROM `category` WHERE `category_id` = '$id'";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$category_name = $row['category_name'];
			echo $category_name; 			
		}
	}
	function getSettingValue($setting){
		global $conn;
		$sql = "SELECT * FROM `settings` WHERE `setting_name` = '$setting'";
		$result = mysqli_query($conn,$sql);
		while($row = mysqli_fetch_assoc($result)){
			$value = $row['setting_value'];
			echo $value;
		}
	}
	function setSettingValue($setting,$value){
		global $conn;
		$sql = "UPDATE `settings` SET setting_value='$value' WHERE setting_name = '$setting'" ;
		if(mysqli_query($conn,$sql)){
			return true;
		}else{
			return false;
		}
	}
	function setInfo($dt,$sec,$sess){
		global $date = $dt;
		global $section = $sec;
		global $session = $sess; 
	}
	function getDate(){
		return $date , $sec , $sess;
	}
?>