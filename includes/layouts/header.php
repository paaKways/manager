<?php if(!isset($layout_context) ) {$layout_context='public';} ?><!DOCTYPE html>
<html>
	<head>
		<title><?php if( $layout_context == 'admin' ) echo 'Admin' ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/style.css" type="text/css">
	</head>

	<body>
		<header class="container">
		 <h1>Manager 1.0</h1>
		</header><!--header-->
		
		<div id="outer" class="container">
	
			<nav class="row">
				<ul class="column col-12" id="navigation">
					<li><a onclick='showNav();' id="collapser">&#9776;</a></li>
					<li><a href="index.php">Home</a></li>
					<li><a href="#">About</a></li>
					<li><a href="#">Contact</a></li>
				</ul>
			</nav><!--row-->
	