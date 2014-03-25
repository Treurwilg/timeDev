<!DOCTYPE html>
<html>
	<head
		<title></title>
		<link href="tijdschrijf.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div class="page">
		<h1>RivierenlandICT</h1>
		<ul id="navigation">
			<li><a href="index.php">Main Page</a></li>
			<li><a href="formTijd.php">Tijdschrijven</a></li>
			<li><a href="showProjects.php">Overzicht Projecten</a></li>
			<li><a href="user.php" >Log In/Out</a></li>
		</ul>
		
		<?php
		if(!isset($_SESSION)) {
			session_start();	
		}
		if(isset($_SESSION["flash"])) {
			?>
		   <div id="flash"> <?= $_SESSION["flash"] ?> </div>
		   <?php
		   unset($_SESSION["flash"]);	
		}
		?>