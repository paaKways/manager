<?php
	//Load configuration details
	$config = parse_ini_file('config.ini');
	
	//Connect to database
	$link = mysqli_connect('localhost',$config['username'],$config['password'],$config['db']);
	
	if(mysqli_connect_error()){
		die();
	}
?>