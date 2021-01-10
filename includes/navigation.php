<?php 

	include_once "connection.php";
?>
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			  <a class="navbar-brand" href="./index.php">CSBooks</a>
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mx-auto">
				  <li class="nav-item active">
					<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="books.php">Books</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="blogs.php">Blogs</a>
				  </li>
				  <li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" id="navbarDropdown" href = "#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Categories
					</a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					</div>
				  </li>
				 
					  <li class="nav-item">
						<a class="nav-link" href="admin/logout.php" >LogOut</a>
					  </li>
					  <li class = "nav-item">
						<h6 style = "color:white;padding:10px;">Welcome!</h6>
					  </li>
					 <li class="nav-item">
						<a class="nav-link" href="admin/login.php" >LogIn</a>
					  </li>
					  <li class="nav-item">
						<a class="nav-link" href="admin/signup.php" >SignUp</a>
					  </li>
				  
				</ul>
				<form action = "search.php" class="form-inline my-2 my-lg-0">
				  <input name = "s" class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
				  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
				</form>
			  </div>
			</nav>
			
