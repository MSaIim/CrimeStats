<!DOCTYPE html>
<html>
	<head>
		<title>CS336 - Crime Stats</title>

		<meta charset="utf-8"/>
		<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<link rel="icon" type="image/png" href="assets/images/favicon.png">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

		<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

		<!-- FONTS -->
		<link href="https://fonts.googleapis.com/css?family=Francois+One|Roboto|Open+Sans|Bungee" rel="stylesheet"> 
	</head>

<body data-target=".navbar-collapse">

	<!-- HEADER -->
	<header class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<a href="index.php">
					<img src="assets/images/favicon.png" width="40" height="40" /> 
					<span class="title">Crime Statistics</span>
				</a>

				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu" aria-expanded="false" aria-controls="navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>

			<nav class="navbar-collapse collapse" id="menu">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="index.php">Search Tables</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<!-- TABLES -->
	<section class="container dafont">
		<?php 
			include("assets/php/DBCrimeStats.php");

			// Open connection and fetch the results
			$conn = new DBCrimeStats();
			$conn->fetch();
	
			// Close the connection
			$conn->close();
		?>
	</section>

	<!-- FOOTER -->
	<footer></footer>
	
</body>
</html>